<template>
  <div id="list" class="row">
    <div class="col-12 m-2 ">
        <router-link to="/books/add">
            <a class="btn btn-outline-success">Adcionar Livro</a>
        </router-link>
    </div>
    <div class="table-responsive col-md-12">
        <table id="tabela_books" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" >Nome</th>
                    <th scope="col" >Autor</th>
                    <th scope="col" >Descrição</th>
            </tr>
            </thead>
            <tbody>
                    <tr v-for="book in books" :key="book.id">
                        <td>{{book.name}}</td>
                        <td>{{book.author}}</td>
                        <td>{{book.description}}</td>
                        <td>
                            <div>
                                <router-link :to="`/books/${book.id}`">
                                    <a class="btn btn-outline-warning mr-1" tabindex="-1" role="button" aria-disabled="true">Reservar livro</a>
                                </router-link>
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
    data(){
        return{
            books:[]
        }
    },
    created(){
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.get(`/api/`)
                .then(response =>{
                    console.log(response.data)
                    this.books = response.data
                })
            })
            .catch(function (error) {
                console.error(error)
            });
    },

    methods: {

    }

}
</script>

<style>

</style>
