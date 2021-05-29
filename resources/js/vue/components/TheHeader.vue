<template>
    <header class="header">
        <h1>work planner</h1>
        <div v-if="$store.getters.user" class="header__user-info">
            <p>{{ $store.getters.user.name }}</p>
            <button @click="logout">Cerrar sesión</button>
        </div>
    </header>
</template>

<script>
export default {
    methods: {
        async logout() {
            // Perform the request
            const token = localStorage.getItem('token');
            const response = await fetch('/api/logout', {
                headers: {
                    Authorization: token
                }
            });
            const responseData = await response.json();

            // Check if request was ok
            if (response.ok) {
                this.$store.commit('setUser', null); // Remove user from state
                localStorage.removeItem('token'); // Remove token from storage
            } else {
                console.log(responseData);
            }
        }
    }
}
</script>