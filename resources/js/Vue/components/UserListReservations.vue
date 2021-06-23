<template>
    <div id="list" class="row">
        <div class="table-responsive col-md-12">
            <table id="tabela_reservation" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" >Nome</th>
                        <th scope="col" >Reservado</th>
                        <th scope="col" >Devolução</th>
                </tr>
                </thead>
                <tbody>
                        <tr v-for="reservation in userReservations" :key="reservation.id">
                            <td>{{reservation.name}}</td>
                            <td>{{reservation.date_reservation}}</td>
                            <td>{{reservation.date_devolution}}</td>
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
    }
}
</script>

<style>

</style>
