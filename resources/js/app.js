require('./bootstrap');

import Vue from 'vue'
import App from './Vue/App.vue'
import VueRouter from 'vue-router';
import {routes} from './routes';

import './axios'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
