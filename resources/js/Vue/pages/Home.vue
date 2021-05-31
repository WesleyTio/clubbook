<template>
    <div>
        <div class="justify-content-center container-fluid my-4 ">
        <Search></Search>
        <ListBooks></ListBooks>
        </div>
    </div>
</template>

<script>
import Navbar from '../components/Navbar'
import Search from '../components/Search'
import ListBooks from '../components/ListBooks'
export default {

    components: { Navbar, Search, ListBooks },
    data(){
        return{
            corruentUser: {},

        }
    },
    mounted(){
       axios.get('api/user').then((response) => {
            this.corruentUser = response.data
        }).catch((error) => {
            console.error(error)
            
        })
    }

}
</script>

<style>

</style>
