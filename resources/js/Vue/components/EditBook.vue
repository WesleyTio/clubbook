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
                @click="busyReservation"
            >
                Reservar livro
            </button>
            <div class="row" v-if="reservation">
                <form class="form-inline">
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

                    <button class="btn btn-outline-success m-1">
                        Salvar reserva
                    </button>
                    <button
                        class="btn btn-outline-danger m-1"
                        @click="reservation = !reservation"
                    >
                        Canlelar
                    </button>
                    <p>resultado: {{ period }}</p>
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
            busyReservations: [],
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
                    this.getToDay()
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
                        .post(`/api/update/${this.id}`, {
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
        getToDay() {
            const data = new Date();
            /*var dia = String(data.getDate())
            const diaF = (dia.length == 1) ? '0'+dia : dia
            var mes = String(data.getMonth() + 1)
            const mesF = (mes.length == 1) ? '0'+mes : mes
            var ano = data.getFullYear();
            this.toDay = diaF + "/" + mesF + "/" + ano;*/
            this.toDay = data.getTime()
        },
        busyReservation(){
            this.reservation = !this.reservation
            const listBusyReservation = this.reservations.filter(reservation =>{
                const devolution = new Date(reservation.date_devolution);
                return devolution.getTime() >= this.toDay
            });
            this.busyReservations = listBusyReservation
            console.log(this.busyReservations)
        },
        validateReservation(dateR, dateD){
            let validate = true
            this.busyReservations.forEach((reservation)=> {
                const devolution = new Date(reservation.date_devolution);
                const reservationDate = new Date(reservation.date_reservation);
                if(dateR  < devolution.getTime()){
                    if(dateD > reservationDate.getTime()){
                        console.log('segund0 if')
                        validate = false;
                    }else{
                        console.log('else')
                        validate = true
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
            console.log(timeDays);
            if (timeDays > 5) {
                alert('OPS! Não podemos fazer reservas acima de 5 dias ')
            } else if (this.toDay > dateR.getTime() || this.toDay > dateD.getTime()) {
                alert('Data inválida!!!')
            } else {
                let validateDate = this.validateReservation(dateR.getTime(), dateD.getTime())
                if(!validateDate){
                    alert('O livro não pode ser reservado na data informada consulte a lista de reservas!')
                }
                
            }
        },
    },
};
</script>

<style>
</style>
