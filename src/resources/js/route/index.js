import {createRouter, createWebHistory} from 'vue-router';

import Home from '../pages/Home.vue';
import Login from '../pages/Auth/Login.vue';
import Register from '../pages/Auth/Register.vue';
import Preferences from '../pages/Preferences.vue';
import Logout from "../pages/Auth/Logout.vue";


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            authRequired: true,
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            authRequired: false,
        }
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout,
        meta: {
            authRequired: true,
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            authRequired: false,
        }
    },
    {
        path: '/preferences',
        name: 'preferences',
        component: Preferences,
        meta: {
            authRequired: true,
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    // const isAuth = localStorage.getItem('token') || false;
    // const userJSON = localStorage.getItem('user') || '';
    // const isFirstLogin = userJSON ? JSON.parse(userJSON).first_login : false;

    // if (isAuth) {
    //     if (to.name !== 'preferences') {
    //         if (isFirstLogin) next('preferences');
    //         if (!isFirstLogin) next(from.name);
    //     }
    //     if (['login', 'register'].includes(to.name)) {
    //         next(from.name);
    //     }
    // } else {
    //     if (to.meta.authRequired) {
    //         next('login');
    //     }
    // }
    next();
})

export default router;
