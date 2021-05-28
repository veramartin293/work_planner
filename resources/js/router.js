import {createRouter, createWebHistory} from 'vue-router';

import Home from './vue/pages/Home.vue';
import NotFound from './vue/pages/NotFound.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/:notFound(.*)',
            component: NotFound
        }
    ]
});

export default router;