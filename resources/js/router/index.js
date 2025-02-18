import { createRouter, createWebHistory } from "vue-router";

import Dashboard from "../../components/Backend/Dashboard.vue";
import Roles from "../../components/Backend/Settings/Roles.vue";
import Users from "../../components/Backend/Settings/User.vue";
import Branch from "../../components/Backend/Settings/branchs/Branch.vue";
import Login from "../../components/Login.vue";
import YouNotAuthorized from "../../components/YouNotAuthorized.vue";
import Village from "../../components/Backend/Settings/Village.vue";

const isAuthenticated = () => !!localStorage.getItem('auth_token');

const routes = [
    {
        path: "/",
        name: "dashboard",
        component: Dashboard,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                next("/login");
            } else {
                next();
            }
        },
    },
    {
        path: "/branch",
        name: "branch",
        component: Branch,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                next("/login");
            } else {
                next();
            }
        },
    },
    {
        path: "/roles",
        name: "roles",
        component: Roles,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                next("/login");
            } else {
                next();
            }
        },
    },
    {
        path: "/users",
        name: "users",
        component: Users,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                next("/login");
            } else {
                next();
            }
        },
    },
    {
        path: "/villages",
        name: "villages",
        component: Village,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                next("/login");
            } else {
                next();
            }
        },
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next('/');
            } else {
                next();
            }
        },
    },
    {
        path: "/403_authorized",
        name: "403_authorized",
        component: YouNotAuthorized,
        beforeEnter: (to, from, next) => {
                next();
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
