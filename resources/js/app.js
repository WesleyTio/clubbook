require('./bootstrap');

import Vue from 'vue'
import App from './Vue/App.vue'
import router from './router'


import './axios'


const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
