//require('./bootstrap');

import {createApp} from 'vue';
import App from './vue/App.vue';
import router from './router.js';
import store from './store.js';

import BaseModal from './vue/components/BaseModal.vue';
import BaseForm from './vue/components/BaseForm.vue';

const app = createApp(App);
app.use(router);
app.use(store);
app.component('base-modal', BaseModal);
app.component('base-form', BaseForm);
app.mount('#app');