<template>
    <div>
        <div  v-if="isLoggedIn">

        </div>
        <div v-else >
            <Home></Home>
        </div>
    </div>
</template>

<script>

import Login from './pages/Login.vue'
import Register from './pages/Register'
import Home from './pages/Home'
export default {
    components: {Login, Register, Home},
    data(){
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },

}
</script>

<style>

</style>
