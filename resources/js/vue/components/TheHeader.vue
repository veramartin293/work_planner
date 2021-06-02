<template>
    <header class="header">
        <h1 class="header__title">work planner</h1>
        <div v-if="$store.getters.user" class="header__user-info">
            <p><strong>{{ $store.getters.user.name }}</strong></p>
            <button class="btn-logout" @click="logout">Cerrar sesión</button>
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

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    padding: 25px 50px;
}

.header h1 {
    font-size: 2.5em;
    text-transform: capitalize;
}

.btn-logout {
    transition: all 0.3s ease;
}

.btn-logout:hover {
    transform: scale(1.1);
}

.header__user-info {
    display: flex;
    align-items: center;
}

.header__user-info p {
    margin-right: 10px;
    font-size: 1.2em;
    text-transform: capitalize;
}
</style>