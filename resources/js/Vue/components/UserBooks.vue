<template>
  <div id="list" class="row">
    <div class="col-12 m-2 ">
        <router-link to="/mybooks/add">
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
                                <router-link :to="`/mybooks/${book.id}`">
                                    <a class="btn btn-outline-warning mr-1" tabindex="-1" role="button" aria-disabled="true">Detalhes</a>
                                </router-link>
                                <router-link :to="`/mybooks/${book.id}/editar/true`">
                                    <a class="btn btn-outline-primary ml-1 mr-1" tabindex="-1" role="button" aria-disabled="true">Editar</a>
                                </router-link>
                                <a class="btn btn-outline-danger ml-1" tabindex="-1" role="button" aria-disabled="true" @click="deletar(book.id)">Deletar</a>

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
        const id = localStorage.getItem('userId')
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.get(`/api/userbooks/${id}`)
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
        deletar(id){

            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.delete(`/api/delete/${id}`)
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
