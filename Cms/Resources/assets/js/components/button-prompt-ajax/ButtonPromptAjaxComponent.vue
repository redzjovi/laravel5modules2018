<template>
    <button
        type="button"
        @click="promptMethod"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    methods: {
        promptMethod() {
            let inputValue = prompt(this.propmtText, this.promptDefaultText);

            if (inputValue === null) {
                return;
            }

            axios.post(this.ajaxUrl, {
                [this.ajaxName]: inputValue
            })
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                alert(error.response.data.message);
            });
        }
    },
    name: 'button-prompt-ajax',
    props: {
        ajaxName: String,
        ajaxUrl: String,
        promptDefaultText: String,
        propmtText: String
    }
}
</script>

<style></style>
