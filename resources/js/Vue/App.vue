<template>
    <div>
        <Navbar></Navbar>
        <router-view/>
    </div>
</template>

<script>

import Login from './pages/Login.vue'
import Register from './pages/Register'
import Home from './pages/Home'
import Navbar from './components/Navbar'
export default {
    components: {Login, Register, Home, Navbar},
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
