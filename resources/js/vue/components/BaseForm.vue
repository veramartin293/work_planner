<template>
    <form @submit.prevent class="base-form">
        <slot name="form-legend"></slot>
        <slot name="form-body"></slot>
        <div class="form-actions">
            <button>submit</button>
            <button>cancel</button>
        </div>
    </form>
</template>

<script>
export default {
    
}
</script>

<style>
.base-form legend {
    font-size: 1.5em;
    font-weight: bold;
    text-align: center;
}

.form-actions {
    display: flex;
    justify-content: center;
}

.form-actions button:last-child {
    margin-left: 10px;
}
</style>
