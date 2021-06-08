<template>
    <div>
        <div class="justify-content-center container-fluid my-4 ">
        <Search></Search>
        <ListBooks></ListBooks>
        </div>
    </div>
</template>

<script>

import Search from '../components/Search'
import ListBooks from '../components/ListBooks'
export default {

    components: { Search, ListBooks },
    data(){
        return{

        }
    },
    mounted(){
        const logado = localStorage.getItem('isLoggedIn')
        if( logado === 'true'){
            axios.get('api/user').then((response) => {
                this.corruentUser = response.data
            }).catch((error) => {
                console.error(error)
            })
        }
    }

}
</script>

<style>

</style>
