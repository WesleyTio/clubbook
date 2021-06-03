
import {createWebHistory, createRouter} from 'vue-router';

import Login from './Vue/pages/Login.vue'
import Register from './Vue/pages/Register.vue'
import Home from './Vue/pages/Home.vue'
import Book from './Vue/pages/Book.vue'


export const routes = [
        {
            name: 'home',
            path: '/',
            component: Home

        },{
            name: 'login',
            path: '/login',
            component: Login

        },{
            name: 'register',
            path: '/register',
            component: Register
        },{
            name: 'books',
            path: '/books',
            component: Book
        }
];


const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;

