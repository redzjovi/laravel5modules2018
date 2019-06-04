<template>
    <div>
        <h3>{{ title }}</h3>
        <pre>{{ valueString }}</pre>
    </div>
</template>
<script>
export default {
    computed: {
        valueString() {
            return JSON.stringify(this.value, null, 2);
        }
    },
    name: 'raw-displayer',
    props: {
        title: {
            required: true,
            type: String
        },
        value: {
            required: true,
            type: Array
        }
    }
};
</script>
<style scoped>
pre {
    text-align: start;
}
</style>
