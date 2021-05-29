import {createRouter, createWebHistory} from 'vue-router';

import Home from './vue/pages/Home.vue';
import NotFound from './vue/pages/NotFound.vue';
import OrderDetail from './vue/pages/OrderDetail.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/orders/:id',
            component: OrderDetail
        },
        {
            path: '/:notFound(.*)',
            component: NotFound
        }
    ]
});

export default router;