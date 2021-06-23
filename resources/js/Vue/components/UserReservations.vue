<template>
    <div>
        <div id="UserListReservations">
            <UserListReservations v-bind:userReservations="userReservations"/>
        </div>
        <span style="background-attachment: fixed;"></span>
        <div id="ListBooks">

        </div>

    </div>

</template>

<script>
import UserListReservations from './UserListReservations.vue'
import ListBooks from './ListBooks.vue'
export default {
    components: {UserListReservations, ListBooks},
    data(){
        return{
            userReservations:[],
            availableBooks:[]
        }
    },
    created(){
        const id = localStorage.getItem('userId')
        axios
            .get("/sanctum/csrf-cookie")
            .then((response) => {
            axios
                .get(`/api/userReservations/${id}`)
                .then((response) => {
                    console.log(response.data);
                    this.userReservations = response.data;
                });
            })
            .catch(function (error) {
                console.error(error);
            });
        
    }

}
</script>

<style>

</style>
