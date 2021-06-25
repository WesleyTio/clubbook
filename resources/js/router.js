
import {createWebHistory, createRouter} from 'vue-router';

import Login from './Vue/pages/Login.vue'
import Register from './Vue/pages/Register.vue'
import Home from './Vue/pages/Home.vue'
import Books from './Vue/pages/books.vue'
import Reservations from './Vue/pages/Reservations.vue'
import UserBooks from './Vue/components/UserBooks.vue'
import EditBook from './Vue/components/EditBook.vue'
import AddBook from './Vue/components/AddBook.vue'
import UserReservations from './Vue/components/UserReservations.vue'


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
            name: 'mybooks',
            path: '/mybooks',
            component: Books,
            props: true,
            children: [
                { path: '', component: UserBooks, props: true},
                { path: 'add', component: AddBook, props: true},
                { path: ':id', component: EditBook, props: true},
                { path: ':id/editar/:edit', component: EditBook, props: true}
            ]
        },{
            name: 'myreservations',
            path: '/myreservations',
            component: Reservations,
            props: true,
            children: [
                { path: '', component: UserReservations, props: true},
                { path: ':id', component: EditBook, props: true},
            ]

        }

];


const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;

