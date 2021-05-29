<template>
    <div class="order-card">
        <h3>{{order.team_name}}</h3>
        <p>{{order.date}}</p>
        <div class="order-card__specs">
            <img :src="`/storage/${order.logo}`" alt="">
            <p>Typography: {{order.typography}}</p>
            <p>Colors: {{order.colors}}</p>
            <p>In progress: {{order.is_in_progress}}</p>
            <router-link :to="`/orders/${order.id}`">Ver detalle</router-link>
        </div>
    </div>
</template>

<script>
export default {
    props: ['order']
}
</script>

<style scoped>
img {
    height: 100px;
}
</style>