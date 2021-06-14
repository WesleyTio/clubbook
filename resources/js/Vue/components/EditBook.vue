<template>
    <div>
        <div class="row">

            <div id="img" class="m-1 col-3" style="height: 230px; background-color: #000 ">

            </div>
            <div id="formulario" class="col-8" v-if="editing">
                <form  method="POST" autocomplete="on" >
                    <div class="form-group">
                        <label>Titulo:</label>
                        <input type="text" class="form-control"  v-model="book.name"/>
                    </div>

                    <div class="form-group">
                        <label>Autor:</label>
                        <input type="text"  class="form-control" v-model="book.author"/>
                    </div>
                    <div class="form-group">
                        <label>Descrição:</label>
                        <textarea type="text"  class="form-control" v-model="book.description"/>
                    </div>
                    <button type="submit" class="btn btn-success " style="width: 20%;" @click="update"> Salvar </button>
                </form>
            </div>
            <div id="detalhes" class="col-8" v-else>
                <div class="form-group">
                    <label>Titulo:</label>
                    <label type="text" class="form-control">{{book.name}}</label>
                </div>

                <div class="form-group">
                    <label>Autor:</label>
                    <label type="text"  class="form-control" >{{book.author}}</label>
                </div>
                <div class="form-group">
                    <label>Descrição:</label>
                    <label type="text"  class="form-control">{{book.description}}</label>
                </div>

            </div>
        </div>
        <div id="reservation" v-if="!editing">
            <ListBookReservation v-bind:reservations="reservations" />
        </div>
    </div>
</template>

<script>
import ListBookReservation from './ListBookReservation.vue'
export default {
    props: ["id", "edit"],
    components: { ListBookReservation },
    data() {
        return {
            editing: false,
            book: [],
            reservations: []
        };
    },
    created() {
        if (this.edit === "true") {
            this.editing = true;
        }
        axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.get(`/api/edit/${this.id}`).then((response) => {
                    console.log(response.data);

                    this.book = response.data;
                });
            })
            .catch(function (error) {
                console.error(error);
            });
        if (!this.editing) {
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.get(`/api/reservations/${this.id}`).then((response) => {
                    console.log(response.data);
                    this.reservations = response.data;
                });
            })
            .catch(function (error) {
                console.error(error);
            });
        }
    },
    methods:{
        update(e){
            e.preventDefault()
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.post(`/api/update/${this.id}` , {
                    name: this.book.name,
                    author: this.book.author,
                    description: this.book.description
                })
                .then((response) => {
                    console.log(response.data);
                    this.$router.go(-1)
                });
            })
            .catch(function (error) {
                console.error(error);
            });

        }
    }
};
</script>

<style>
</style>
