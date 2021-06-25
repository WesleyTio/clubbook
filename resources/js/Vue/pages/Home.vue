<template>
    <div>
        <div class="justify-content-center container-fluid my-4 ">
        <Search></Search>
        <ListLastBooks></ListLastBooks>
        </div>
    </div>
</template>

<script>

import Search from '../components/Search.vue'
import ListLastBooks from '../components/ListLastBooks.vue'
export default {
    components: { Search, ListLastBooks },
    mounted(){
        const logado = localStorage.getItem('isLoggedIn')
        if( logado === 'true'){
            axios.get('api/user').then((response) => {
                this.corruentUser = response.data
            }).catch((error) => {
                this.emitter.emit('isLoggedIn', false)
                this.$router.push('/login')
                console.error(error)
            })
        }
    }

}
</script>

<style>

</style>
