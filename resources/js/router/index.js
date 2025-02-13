import { createRouter , createWebHistory } from "vue-router";

import Home  from '../../components/Home/Index.vue'
import Product  from '../../components/Product/index.vue'

const routes = [
    {
        path: '/',
        name: 'home.index',
        component: Home,
    },
    {
        path: '/product',
        name: 'product.index',
        component: Product,
    },
];

const router = createRouter({
    history : createWebHistory(),
    routes
});


export default router