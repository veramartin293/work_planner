<template>
    <div class="order-card" :style="{'background-image':`url(/storage/${order.logo})`}">
        <div class="order-card__title">
            <router-link :to="`/orders/${order.id}`">
                <h3>{{order.team_name}}</h3>
                <p>Ver detalle</p>
            </router-link>
        </div>
        <p class="order-card__date">
            {{order.date}}
        </p>
        <!-- <div class="order-card__image">
            <img :src="`/storage/${order.logo}`" alt="Image not found">
        </div>
        <div class="order-card__info">
            <h3>{{order.team_name}}</h3>
            <p>{{order.date}}</p>  
            <router-link :to="`/orders/${order.id}`">Ver detalle</router-link>          
        </div> -->
        <!-- <div class="order-card__specs">
            <img :src="`/storage/${order.logo}`" alt="">
            <p>Typography: {{order.typography}}</p>
            <p>Colors: {{order.colors}}</p>
            <p>In progress: {{order.is_in_progress}}</p>
            <router-link :to="`/orders/${order.id}`">Ver detalle</router-link>
        </div> -->
    </div>
</template>

<script>
export default {
    props: ['order']
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
</style>