<template>
    <div>
        <h2>Order Detail</h2>
        <router-link to="/">Return home</router-link>
        <p v-if="error.state">{{error.message}}</p>
        <div v-if="order" class="order-detail">
            <div class="order-detail__image">
                <img :src="`/storage/${order.logo}`" alt="logo">
            </div>
            <div class="order-detail__info">
                <h3>{{ order.team_name }}</h3>
                <p>{{ order.date }}</p>
                <p>Typography: {{ order.typography }}</p>
                <p>colors: {{ order.colors }}</p>
                <p>{{ order.is_in_progress }}</p>
            </div>

            <div class="order-detail__uniforms">
                <div class="order-detail__uniform" v-for="uniform in orderUniforms" :key="uniform.id">
                    <p>{{ uniform.legend }}</p>
                    <p>{{ uniform.number }}</p>
                    <p>{{ uniform.size }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            order: null,
            orderUniforms: [],
            error: {
                state: false,
                message: ''
            }
        }
    },
    created() {
        this.getOrderDetail();
    },
    methods: {
        async getOrderDetail() {
            const orderId = this.$route.params.id;
            const response = await fetch(`/api/orders/${orderId}`);
            const responseData = await response.json();

            if (response.ok) {
                this.order = responseData;
                this.getOrderUniforms();
            } else {
                this.error.state = true;
                this.error.message = responseData.error;
            }
        },
        async getOrderUniforms() {
            const orderId = this.$route.params.id;
            const response = await fetch(`/api/uniforms/${orderId}`);
            const responseData = await response.json();

            if (response.ok) {
                this.orderUniforms = responseData;
            } else {
                this.error.state = false;
                this.error.message = responseData.error;
            }
        }
    }

}
</script>

<style scoped>
img {
    height: 300px;
}
</style>