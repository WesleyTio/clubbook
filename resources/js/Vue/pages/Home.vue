<template>
    <div>
        <div class="justify-content-center container-fluid my-4 ">
        <Search></Search>
        <ListLastBooks v-if="viewTable"></ListLastBooks>
        </div>
    </div>
</template>

<script>

import Search from '../components/Search.vue'
import ListLastBooks from '../components/ListLastBooks.vue'
export default {
    components: { Search, ListLastBooks },
    data(){
        return{
            viewTable: true
        }
    },
    mounted(){
        const logado = localStorage.getItem('isLoggedIn')
        if( logado === 'true'){
            axios.get('api/user').then((response) => {
                this.corruentUser = response.data
            }).catch((error) => {
                this.emitter.emit('isLoggedOff', false)
                this.$router.push('/login')
                console.error(error)
            })
        }
        this.emitter.on('viewTable', viewTable => {
            console.log(viewTable);
            this.viewTable = viewTable

            //
        })
    }

}
</script>

<style>

</style>
