<template>
    <router-view></router-view>
</template>

<script>
export default {
  created() {
    this.checkAuthentication();
  },
  methods: {
    async checkAuthentication() {
      const token = localStorage.getItem('token');

      if (token !== undefined && token) {
        console.log(token);
        const response = await fetch('/api/authenticated', {
          headers: {
            Authorization: token
          }
        });
        const responseData =  await response.json();
        this.$store.commit('setUser', responseData);
      }
      this.$store.commit('changeAuthenticatedUserFlag');
    }
  }
}
</script>

<style>
/* General styles */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700;900&display=swap');

html {
  box-sizing: border-box;
  font-family: 'Roboto';
}
*, *:before, *:after {
  box-sizing: inherit;
}


</style>