<template>
    <router-view></router-view>
</template>

<script>
export default {
  created() {
    this.checkAuthentication();
  },
  methods: {
    checkAuthentication() {
      const user = localStorage.getItem('user');
      const token = localStorage.getItem('token');

      if (token !== undefined) {
        this.$store.commit('setUser', JSON.parse(user));
      } else {
      }
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