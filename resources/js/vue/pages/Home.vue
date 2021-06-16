<template>
    <div v-if="$store.getters.authenticatedUserFlag">
        <main>
            <form-auth v-if="!$store.getters.user"></form-auth>
            <orders-list v-if="$store.getters.user"></orders-list>
        </main>
    </div>
</template>

<script>
import FormAuth from '../components/FormAuth.vue';
import OrdersList from '../components/OrdersList.vue';

export default {
    data() {
        return {
        };
    },
    components: {
        FormAuth,
        OrdersList,
    },
    methods: {
    }
}
</script>

<style scoped>
main {
    width: 80%;
    margin: 0 auto;
}
</style>