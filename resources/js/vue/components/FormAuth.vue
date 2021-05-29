<template>
    <form @submit.prevent>
        <legend>Iniciar sesión</legend>
        <input type="email" placeholder="email" v-model="email">
        <input type="password" placeholder="password" v-model="password">
        <button @click="login">Iniciar sesión</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        async login() {
            // Perfrom the request
            const response = await fetch('/api/login', {
                method: 'POST',
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const responseData = await response.json();

            // Check if request was ok
            if (response.ok) {
                this.$store.commit('setUser', responseData.user); // Set user in state
                localStorage.setItem('token', `Bearer ${responseData.token}`); // Save token in storage
            } else {
                console.log(responseData.error);
            }  
        },
    }
}
</script>

<style scoped>
form legend {
    font-weight: bold;
    font-size: 1.4em;
}

input {
    display: block;
}
</style>