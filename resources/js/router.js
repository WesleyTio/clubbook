import Vue from 'vue'
import VueRouter from 'vue-router';

import Login from './Vue/pages/Login.vue'
import Register from './Vue/pages/Register.vue'
import Home from './Vue/pages/Home.vue'

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes:[{
            name: 'Home',
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
        }]
})
