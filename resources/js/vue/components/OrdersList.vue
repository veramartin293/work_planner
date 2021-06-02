<template>
    <div>
        <h1>Lista De Ordenes</h1>
        <div class="order-list-container">
            <order-card v-for="order in orders" :key="order.id"
            :order="order"></order-card>
        </div>
    </div>
</template>

<script>
import OrderCard from './OrderCard';

export default {
    components: {
        OrderCard
    },
    data() {
        return {
            orders: []
        }
    },
    created() {
        this.getAllOrders();
    },
    methods: {
        async getAllOrders() {
            const response = await fetch('/api/orders');
            const responseData = await response.json();

            if (response.ok) {
                this.orders = responseData;
            } else {
                console.log(responseData.error);
            }
        }
    }
}
</script>

<style scoped>
h1 {
    padding: 0px 0px 50px 0px;
    text-align: center;
}
.order-list-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
}
</style>