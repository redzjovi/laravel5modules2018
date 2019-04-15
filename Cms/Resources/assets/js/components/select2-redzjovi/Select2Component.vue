<template>
    <select
        :multiple="multiple"
        :name="name"
    >
        <slot></slot>
    </select>
</template>

<script>
export default {
    mounted: function () {
        var vm = this;

        var configurations = new Object();

        if (vm.ajax === true) {
            configurations.ajax = {
                data: function (params) {
                    return {
                        [vm.ajaxDataSearch]: params.term,
                        per_page: vm.ajaxDataPerPage,
                        sort: vm.ajaxDataSort
                    };
                },
                headers: {
                    'Accept-Language': document.documentElement.lang
                },
                processResults: function (response) {
                    let responseResults = response.data.map((value, i) => {
                        return {
                            id: value[vm.ajaxProcessResultsId],
                            text: value[vm.ajaxProcessResultsText]
                        }
                    });

                    return { results: responseResults };
                },
                url: this.ajaxUrl
            }
        }

        configurations.language = document.documentElement.lang;
        configurations.minimumInputLength = vm.minimumInputLength;
        configurations.tags = vm.tags;
        configurations.theme = vm.theme;

        $(this.$el).select2(configurations);
    },
    name: 'select2',
    props: {
        ajax: Boolean,
        ajaxDataPerPage: {
            default: 10,
            type: Number
        },
        ajaxDataSearch: {
            default: 'search',
            type: String
        },
        ajaxDataSort: String,
        ajaxProcessResultsId: {
            default: 'id',
            type: String,
        },
        ajaxProcessResultsText: {
            default: 'text',
            type: String,
        },
        ajaxUrl: String,
        minimumInputLength: {
            default: 0,
            type: Number
        },
        multiple: String,
        name: String,
        tags: Boolean,
        theme: String
    }
}
</script>

<style></style>
