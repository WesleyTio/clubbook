require('./bootstrap');
require('./axios')

import {createApp} from 'vue'
import App from './Vue/App.vue'
import router from './router'

const app = createApp(App)
app.use(router)
app.mount('#app')
