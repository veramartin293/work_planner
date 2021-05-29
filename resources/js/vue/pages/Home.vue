<template>
    <div v-if="$store.getters.authenticatedUserFlag">
        <the-header></the-header>
        <form-auth v-if="!$store.getters.user"></form-auth>
        <orders-list v-if="$store.getters.user"></orders-list>
    </div>
</template>

<script>
import FormAuth from '../components/FormAuth.vue';
import TheHeader from '../components/TheHeader.vue';
import OrdersList from '../components/OrdersList.vue';

export default {
    components: {
        FormAuth,
        TheHeader,
        OrdersList
    }
}
</script>