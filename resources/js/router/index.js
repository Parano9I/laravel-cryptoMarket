import {createRouter, createWebHistory} from 'vue-router';

import Home from '../pages/Home.vue';
import Register from '../pages/Auth/Register.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

export default router;
