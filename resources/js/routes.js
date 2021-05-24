import Login from './Vue/pages/Login.vue'
import Register from './Vue/pages/Register.vue'

export const routes =[
    {
        name: 'Home',
        path: '/',
        component: Login

    },
    {
        name: 'login',
        path: '/login',
        component: Login

    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
]
