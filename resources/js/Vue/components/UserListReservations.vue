<template>
    <div id="list" class="row">
        <div class="table-responsive col-md-12">
            <table id="tabela_reservation" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" >Nome</th>
                        <th scope="col" >Reservado</th>
                        <th scope="col" >Devolução</th>
                        <th scope="col" >Ação</th>
                </tr>
                </thead>
                <tbody>
                        <tr v-for="reservation in userReservations" :key="reservation.id">
                            <td>{{reservation.name}}</td>
                            <td>{{reservation.date_reservation}}</td>
                            <td>{{reservation.date_devolution}}</td>
                            <td>
                            <div>
                                <router-link :to="`/myreservations/${reservation.id}/editar/${reservation.name}`">
                                    <a class="btn btn-outline-primary mr-1" tabindex="-1" role="button" aria-disabled="true">Editar</a>
                                </router-link>
                                 <a class="btn btn-outline-danger ml-1" tabindex="-1" role="button" aria-disabled="true" @click="deletar(reservation.id)">Excluir</a>
                            </div>
                        </td>
                        </tr>


                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        userReservations: Array
    },
    data(){
        return {

        }
    },
    methods:{
        deletar(id){
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.delete(`/api/reservationdelete/${id}`)
                .then((response) => {
                    console.log(response.data);
                    if(response.data.success){
                        const result = this.books.find(book => book.id === id);
                        this.books.splice(this.books.indexOf(result), 1)
                    }else{
                        alert(response.data.message)
                    }
                })
                .catch(function (error){
                    console.log(error)
                });
            })
            .catch(function (error) {
                console.error(error);
            });
        }
    }
}
</script>

<style>

</style>
