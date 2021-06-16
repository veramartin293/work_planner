<template>
    <div class="order-card" :style="{'background-image':`url(/storage/${order.logo})`}">
        <div class="order-card__title">
            <router-link :to="`/orders/${order.id}`">
                <h3>{{order.team_name}}</h3>
                <p>Ver detalle</p>
            </router-link>
        </div>

        <!-- position absolute elements -->
        <p class="order-card__date">
            {{order.date}}
        </p>

        <div class="order-card__actions">
            <button @click="editOrder" class="btn-blue">editar</button>
            <button @click="deleteOrder" class="btn-red">eliminar</button>
        </div>

    </div>
</template>

<script>
export default {
    props: ['order'],
    methods: {
        editOrder() {
            this.$emit('editClicked', this.order);
        },
        deleteOrder() {
            this.$emit('deleteClicked', this.order);
        }
    }
}
</script>

<style scoped>
.order-card {
    height: 250px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
    transition: all 0.3s ease;
}

.order-card__title {
    background-color: rgba(255,255,255,0.7);
    width: 100%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 10px;
    text-align: center;
    transition: all 0.3s ease;
}

.order-card__title h3 {
    letter-spacing: 5px;
}

.order-card__title:hover {
    cursor: pointer;
    background-color: black;
    color: white;
}

.order-card__date {
    background-color: rgba(255,255,255,0.7);
    position: absolute;
    padding: 2px 5px;
}

.order-card__actions {
    position: absolute;
    bottom: 0;
    right: 0;
}
</style>