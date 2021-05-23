import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios';

axios.defaults.baseURL ='http://localhost:8000/'

Vue.use({
    install(Vue) {
        Vue.prototype.$http = axios
    }
})
