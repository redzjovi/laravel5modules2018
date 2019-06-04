<template>
    <div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <select @change="typeChangeMethod" class="form-control" v-model="nestableType">
                    <option v-for="(typeName, type) in types" :key="type" :selected="nestableType == type" :value="type">
                        {{ typeName }}
                    </option>
                </select>
            </div>
            <Multiselect
                @search-change="typeTitleSearchChangeMethod"
                class="form-control"
                placeholder=""
                v-model="nestableTypeTitle"
                :id="'menu_' + Date.now()"
                :internal-search="false"
                :loading="nestableTypeTitleLoading"
                :options="typeTitles"
            >
                <template slot="option" slot-scope="props">
                    {{ props.option.id + ' - ' + props.option.title }}
                </template>
                <template slot="singleLabel" slot-scope="props">
                    {{ props.option.id + ' - ' + props.option.title }}
                </template>
            </Multiselect>
            <div class="input-group-append">
                <button @click="itemAddMethod" class="btn btn-secondary btn-sm" type="button">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-12">
                <menu-nestable-nested :children="items" :types="types" />
            </div>
        </div>
        <div class="row">
            <input type="hidden" :name="name" :value="JSON.stringify(items)" />
            <rawDisplayer class="col-12 d-none" :value="items" title="List" />
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import menuNestableNested from './MenuNestableNestedComponent';
import Multiselect from 'vue-multiselect';
import rawDisplayer from './RawDisplayerComponent';

export default {
    components: {
        draggable,
        menuNestableNested,
        Multiselect,
        rawDisplayer
    },
    data() {
        return {
            // items: [
            //     {
            //         id: 0,
            //         open_link_in_a_new_tab: 0,
            //         type: 'page',
            //         typeId: 0,
            //         typeTitle: 'Andy',
            //         children: [
            //             {
            //                 id: 1,
            //                 open_link_in_a_new_tab: 1,
            //                 type: 'page',
            //                 typeId: 0,
            //                 typeTitle: 'Harry',
            //                 children: []
            //             }
            //         ]
            //     }
            // ],
            items: [],
            nestableType: 'page',
            nestableTypeTitle: '',
            nestableTypeTitleLoading: false,
            typeTitles: [],
            types: []
        }
    },
    methods: {
        itemAddMethod() {
            if (this.nestableTypeTitle.id) {
                this.items.push({
                    id: Date.now(),
                    open_link_in_a_new_tab: 0,
                    type: this.nestableType,
                    typeId: this.nestableTypeTitle.id,
                    typeTitle: this.nestableTypeTitle.title,
                    children: []
                });
            }
        },
        itemDeleteMethod(id) {
            let vm = this;

            this.items = this.items
                .filter(function (item) {
                    return item.id !== id
                })
                .map(function (item) {
                    return vm.itemDeleteFromTreeMethod(item, id);
                });
        },
        itemDeleteFromTreeMethod(parent, childIdToRemove) {
            let vm = this;

            parent.children = parent.children
                .filter(function (child) {
                    return child.id !== childIdToRemove
                })
                .map(function (child) {
                    return vm.itemDeleteFromTreeMethod(child, childIdToRemove)
                });

            return parent;
        },
        typeChangeMethod() {
            this.nestableTypeTitle = '';
            this.typeTitles = [];
        },
        typesGet() {
            let vm = this;

            axios.get('/api/v1/menu/nestable/type')
                .then(function (response) {
                    vm.types = response.data.data;
                });

            return this.types;
        },
        typeTitleSearchChangeMethod(search) {
            this.nestableTypeTitleLoading = true;
            this.typeTitleSearchGet(search);
        },
        typeTitleSearchGet(search) {
            let vm = this;

            axios.get('/api/v1/menu/nestable/type-title', {
                    params: {
                        'per_page': 100,
                        'type': this.nestableType,
                        'type_title': search
                    }
                })
                .then(function (response) {
                    vm.nestableTypeTitleLoading = false;
                    vm.typeTitles = response.data.data;
                });

            return this.typeTitles;
        }
    },
    mounted() {
        let vm = this;

        this.$root.$on('itemDeleteEmit', function (id) {
            vm.itemDeleteMethod(id);
        });
        this.items = this.value;
        this.typesGet();
    },
    name: 'menu-nestable',
    props: {
        name: String,
        value: Array
    }
}
</script>

<style lang="css">
@import '~vue-multiselect/dist/vue-multiselect.min.css';
.multiselect {
    border: none;
    padding: 0;
}
</style>
