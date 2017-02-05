<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">{{title}}</p>
                <button class="delete" @click="$emit('close')"></button>
            </header>
            <section v-html="body" class="modal-card-body">
            </section>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: [ 'title', 'body'],
        data() {
            return {
                showModal: false
            };
        },
        methods: {
            hideModal() {
                this.showModal = false;
            }
        }
    }
</script>
