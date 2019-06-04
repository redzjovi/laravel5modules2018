<template>
    <draggable class="dragArea" tag="ul" :group="{ name: 'g1' }" :list="children">
        <li v-for="item in children" :key="item.id">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fa fa-align-justify"></i>
                    </button>
                </div>
                <input class="form-control" readonly type="text" :value="types[item.type] + ' - ' + item.typeId + ' - ' + item.typeTitle" />
                <div class="input-group-append">
                    <b-button variant="outline-primary" v-b-toggle="'accordion-' + item.id">
                        <i class="fa fa-edit"></i>
                    </b-button>
                    <button @click="itemDeleteMethod(item.id)" class="btn btn-outline-danger" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <b-collapse role="tabpanel" :id="'accordion-' + item.id">
                <b-card>
                    <div class="form-group row">
                        <label class="col-sm-2">Type</label>
                        <div class="col-sm-10">{{ types[item.type] }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Type Title</label>
                        <div class="col-sm-10">{{ item.typeTitle }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10">
                            <b-form-checkbox unchecked-value="0" value="1" v-model.number="item.open_link_in_a_new_tab">
                                Open link in a new tab
                            </b-form-checkbox>
                        </div>
                    </div>
                </b-card>
            </b-collapse>
            <menu-nestable-nested :children="item.children" :types="types" />
        </li>
    </draggable>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    components: {
        draggable
    },
    methods: {
        itemDeleteMethod(id) {
            this.$root.$emit('itemDeleteEmit', id);
        }
    },
    name: 'menu-nestable-nested',
    props: {
        children: {
            required: true,
            type: Array
        },
        types: {}
    }
}
</script>

<style scoped>
.dragArea li {
    list-style: none;
}
</style>
