<template>
    <the-header></the-header>
    <router-view></router-view>
</template>

<script>
import TheHeader from './components/TheHeader.vue';

export default {
  components: {
    TheHeader
  },
  created() {
    this.checkAuthentication();
  },
  methods: {
    async checkAuthentication() {
      const token = localStorage.getItem('token');

      if (token !== undefined && token) {
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

* {
  padding: 0px;
  margin: 0px;
}

a {
  text-decoration: none;
  color: inherit;
}

button {
  padding: 5px 5px;
  background: white;
  border: 1px solid black;
  transition: all 0.3s ease;
}

button:hover {
  cursor: pointer;
}

img {
  display: block;
}

section {
  width: 80%;
  margin: 0 auto;
}

.btn-blue {
  background-color: #009dff;
  color: white;
  border-color: #009dff;
}

.btn-blue:hover {
  background-color: white;
  color: #009dff;
  border-color: #009dff;
}

.btn-red {
  background-color: red;
  color: white;
  border-color: red;
}

.btn-red:hover {
  background-color: white;
  color: red;
  border-color: red;
}
</style>