<template>
    <div v-if="$store.getters.authenticatedUserFlag">
        <the-header></the-header>
        <form-auth v-if="!$store.getters.user"></form-auth>
    </div>
</template>

<script>
import FormAuth from '../components/FormAuth.vue';
import TheHeader from '../components/TheHeader.vue';

export default {
    components: {
        FormAuth,
        TheHeader
    }
}
</script>