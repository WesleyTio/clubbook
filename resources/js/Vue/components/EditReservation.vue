<template>
    <div class="row">
        <div class="m-3">
            <label>{{book}}</label>
        </div>
        <div class="row m-3">
            <form method="POST" class="form-inline">
                <div class="form-group m-2">
                    <label> Reservado: </label>
                    <input
                        type="date"
                        class="form-control ml-1"
                        v-model="reservationDate"
                    />
                </div>
                <div class="form-group m-2">
                    <label>Devolvido: </label>
                    <input
                        type="date"
                        class="form-control ml-1"
                        v-model="devolutionDate"
                    />
                </div>

                <button
                    class="btn btn-outline-success m-1"
                    type="submit"
                    @click.prevent="saveReservation"
                >
                    Alterar reserva
                </button>
                <button
                    class="btn btn-outline-danger m-1"
                    @click="cancel"
                >
                    Canlelar
                </button>
                <p>{{ period }}</p>
            </form>
        </div>
        <div id="list_reservation" class="table-responsive col-md-12">
            <ListReservations v-bind:reservations="reservations" />
        </div>
    </div>
</template>

<script>
import ListReservations from './ListReservations.vue'
export default {
    props: [
        "id", "book"
    ],
    components: { ListReservations },
    data(){
        return{
            bookId: null,
            toDay: '',
            reservationDate: '',
            devolutionDate: '',
            reservations: []


        }
    },
    created(){
        axios
            .get("/sanctum/csrf-cookie")
            .then((response) => {
                axios.get(`/api/editReservation/${this.id}`).then((response) => {
                    console.log(response.data);
                    this.reservationDate = response.data.date_reservation
                    this.devolutionDate = response.data.date_devolution
                    this.bookId = response.data.book_id
                    this.toDay = localStorage.getItem('toDay')
                    axios.get(`/api/reservations/${this.bookId}`).then((response) => {
                        console.log(response.data);
                        let listReservation = response.data
                        this.reservations = listReservation.filter(reservation => reservation.id != this.id);

                    });

                });
            })
            .catch(function (error) {
                console.error(error);
            });
    },
    methods:{
        saveReservation(){
            const userId = localStorage.getItem('userId')
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    axios
                        .put(`/api/updateReservation/${this.id}`, {
                            id_user: userId,
                            date_reservation: this.reservationDate,
                            date_devolution: this.devolutionDate
                        })
                        .then((response) => {
                            console.log(response.data);
                            const msg = response.data.message
                            alert(msg);
                        });
                })
                .catch(function (error) {
                    console.error(error);
                });

        },
        cancel(){
            this.$router.push('/myreservations')
        },
        validateReservation(dateR, dateD){
            let validate = true
            this.reservations.forEach((reservation)=> {
                const devolution = new Date(reservation.date_devolution);
                const reservationDate = new Date(reservation.date_reservation);
                if(dateR  < devolution.getTime()){
                    if(dateD > reservationDate.getTime()){
                        validate = false;
                    }
                }
            })
            return validate;
        }

    },
    computed: {
        period(){
            const dateR = new Date(this.reservationDate);
            const dateD = new Date(this.devolutionDate);
            const timeMilisegundo = dateD - dateR;
            const timeDays = Math.ceil(timeMilisegundo / (1000 * 60 * 60 * 24));
            if (this.toDay > dateR.getTime() || this.toDay > dateD.getTime()) {
                alert('Data inválida!!!')
                this.reservationDate = ''
                this.devolutionDate = ''
            }else if (timeDays > 5) {
                alert('OPS! Não podemos fazer reservas acima de 5 dias ')
                this.reservationDate = ''
            } else {
                let validateDate = this.validateReservation(dateR.getTime(), dateD.getTime())
                if(!validateDate){
                    alert('O livro não pode ser reservado na data informada consulte a lista de reservas!')
                    this.reservationDate = ''
                    this.devolutionDate = ''
                }

            }

        }
    }

};
</script>

<style>
</style>
