//require('./bootstrap');

import {createApp} from 'vue';
import App from './vue/App.vue';
import router from './router.js';
import store from './store.js';

const app = createApp(App);
app.use(router);
app.use(store);
app.mount('#app');