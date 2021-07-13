<template>
    <div>
        <div class="row">
            <div
                id="img"
                class="m-1 col-3"
                style="height: 230px; background-color: #000"
            ></div>
            <div id="formulario" class="col-8" v-if="editing">
                <form method="POST" autocomplete="on">
                    <div class="form-group">
                        <label>Titulo:</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="book.name"
                        />
                    </div>

                    <div class="form-group">
                        <label>Autor:</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="book.author"
                        />
                    </div>
                    <div class="form-group">
                        <label>Descrição:</label>
                        <textarea
                            type="text"
                            class="form-control"
                            v-model="book.description"
                        />
                    </div>
                    <button
                        type="submit"
                        class="btn btn-success"
                        style="width: 20%"
                        @click="update"
                    >
                        Salvar
                    </button>
                </form>
            </div>
            <div id="detalhes" class="col-8" v-else>
                <div class="form-group">
                    <label>Titulo:</label>
                    <label type="text" class="form-control">{{
                        book.name
                    }}</label>
                </div>

                <div class="form-group">
                    <label>Autor:</label>
                    <label type="text" class="form-control">{{
                        book.author
                    }}</label>
                </div>
                <div class="form-group">
                    <label>Descrição:</label>
                    <label type="text" class="form-control">{{
                        book.description
                    }}</label>
                </div>
            </div>
        </div>
        <div id="reservation" class="m-2" v-if="!editing">
            <button
                class="btn btn-outline-info"
                v-if="!reservation"
                @click="reservation = !reservation"
            >
                Reservar livro
            </button>
            <div class="row" v-if="reservation">
                <form method="POST"  class="form-inline">
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

                    <button class="btn btn-outline-success m-1"
                            type="submit"
                            @click="saveReservation"
                    >
                        Salvar reserva
                    </button>
                    <button
                        class="btn btn-outline-danger m-1"
                        @click="reservation = !reservation"
                    >
                        Canlelar
                    </button>
                    <p>{{ period }}</p>
                </form>
            </div>
            <div id="menssage" v-show="menssage">
                <label>Reservdo com sucesso</label>
                <label>Livro não pode ser reservado</label>
            </div>
        </div>
        <div id="list_reservation" v-if="!editing">
            <ListReservations v-bind:reservations="reservations" />
        </div>
    </div>
</template>

<script>
import ListReservations from "./ListReservations.vue";
export default {
    props: ["id", "edit"],
    components: { ListReservations },
    data() {
        return {
            editing: false,
            reservation: false,
            menssage: false,
            book: [],
            reservations: [],
            reservationDate: "",
            devolutionDate: "",
            toDay: 0
        };
    },
    created() {

        if (this.edit === "true") {
            this.editing = true;
        }
        axios
            .get("/sanctum/csrf-cookie")
            .then((response) => {
                axios.get(`/api/edit/${this.id}`).then((response) => {
                    console.log(response.data);
                    this.book = response.data;
                    this.toDay = localStorage.getItem('toDay')
                });
            })
            .catch(function (error) {
                console.error(error);
            });
        if (!this.editing) {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    axios
                        .get(`/api/reservations/${this.id}`)
                        .then((response) => {
                            console.log(response.data);
                            this.reservations = response.data;
                        });
                })
                .catch(function (error) {
                    console.error(error);
                });
        }
    },
    methods: {
        update(e) {
            e.preventDefault();
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    axios
                        .put(`/api/update/${this.id}`, {
                            name: this.book.name,
                            author: this.book.author,
                            description: this.book.description,
                        })
                        .then((response) => {
                            console.log(response.data);
                            this.$router.go(-1);
                        });
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        saveReservation(e){
            const userId = localStorage.getItem('userId')
            e.preventDefault(),

            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    axios
                        .post(`/api/reservation`, {
                            fk_user_reservation: userId,
                            fk_book_reservation: this.id,
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
        period() {
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
        },
    },
};
</script>

<style>
</style>
