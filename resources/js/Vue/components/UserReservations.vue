<template>
    <div>
        <div id="UserListReservations">
            <UserListReservations v-bind:userReservations="userReservations" />
        </div>
        <span style="background-attachment: fixed"></span>
        <div id="ListBooks">
            <ListBooks v-bind:books="availableBooks" />
        </div>
    </div>
</template>

<script>
import UserListReservations from "./UserListReservations.vue";
import ListBooks from "./ListBooks.vue";
export default {
    components: { UserListReservations, ListBooks },
    data() {
        return {
            userId: '',
            updateList: false,
            userReservations: [],
            availableBooks: [],
        };
    },
    created() {
        this.userId = localStorage.getItem("userId");
        axios
            .get("/sanctum/csrf-cookie")
            .then((response) => {
                axios.get(`/api/userReservations/${this.userId}`).then((response) => {
                    console.log(response.data);
                    this.userReservations = response.data;
                });
            })
            .catch(function (error) {
                console.error(error);
            });
        axios
            .get("/sanctum/csrf-cookie")
            .then((response) => {
                axios.get(`/api/availableBooks/${this.userId}`).then((response) => {
                    //console.log(response.data);
                    this.availableBooks = response.data;
                });
            })
            .catch(function (error) {
                console.error(error);
            });
    },
    mounted() {
        this.emitter.on("updateList", (updateList) => {
            if(updateList){
                axios
                    .get("/sanctum/csrf-cookie")
                    .then((response) => {
                        axios.get(`/api/availableBooks/${ this.userId}`).then((response) => {
                            //console.log(response.data);
                            this.availableBooks = response.data;
                        });
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
        });
    },
};
</script>

<style></style>
