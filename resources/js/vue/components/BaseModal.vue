<template>
    <div class="modal" @click="closeForm">
        <div class="modal-content" @click.stop>
                <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        closeForm() {
            this.$emit('closeForm');
        }
    }
}
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(107, 107, 107, 0.329);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
}

.modal-content {
    background-color: white;
    width: 30%;
    margin: 0 auto;
    padding: 20px 40px;
}
</style>