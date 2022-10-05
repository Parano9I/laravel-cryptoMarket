import {createRouter, createWebHistory} from 'vue-router';

import Home from '../pages/Home.vue';
import Login from '../pages/Auth/Login.vue';
import Register from '../pages/Auth/Register.vue';
import Preferences from '../pages/Preferences.vue';
import Logout from "../pages/Auth/Logout.vue";
import auth from "./middlewares/auth.js";
import middlewarePipeline from "./middlewares/middlewarePipeline.js";
import firstLogin from "./middlewares/firstLogin.js";
import guest from "./middlewares/guest";


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            middleware: [auth, firstLogin],
        }
    }, {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            middleware: [guest],
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            middleware: [guest],
        }
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout,
        meta: {
            middleware: [auth],
        }
    },
    {
        path: '/preferences',
        name: 'preferences',
        component: Preferences,
        meta: {
            middleware: [auth],
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {

    if (to.meta.middleware.length) {
        const middleware = to.meta.middleware;
        const context = {from, next, router, to};
        const nextMiddleware = middlewarePipeline(context, middleware, 1);

        return middleware[0]({...context, next: nextMiddleware});
    }

    return next()
})

export default router;
