<template>
  <div id="list" class="row">
    <div class="table-responsive col-md-12">
        <table id="tabela_user" class="table table-striped">
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
                                <a class="btn btn-outline-warning mr-1" tabindex="-1" role="button" aria-disabled="true">Detalhes</a>
                                <a class="btn btn-outline-primary ml-1 mr-1" tabindex="-1" role="button" aria-disabled="true">Editar</a>
                                <a class="btn btn-outline-danger ml-1" tabindex="-1" role="button" aria-disabled="true">Deletar</a>

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
    }

}
</script>

<style>

</style>
