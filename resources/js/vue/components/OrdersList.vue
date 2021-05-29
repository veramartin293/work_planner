<template>
    <div>
        <h1>Orders List</h1>
        <order-card v-for="order in orders" :key="order.id"
        :order="order"></order-card>
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