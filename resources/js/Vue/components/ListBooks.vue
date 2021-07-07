<template>
  <div id="list" class="row">
    <div class="table-responsive col-md-12">
        <table id="tabela_books" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" >Nome</th>
                    <th scope="col" >Autor</th>
                    <th scope="col" >Descrição</th>
                    <th scope="col" >Ação</th>
            </tr>
            </thead>
            <tbody>
                    <tr v-for="book in books" :key="book.id">
                        <td>{{book.name}}</td>
                        <td>{{book.author}}</td>
                        <td>{{book.description}}</td>
                        <td>
                            <div>
                                <router-link :to="`/myreservations/${book.id}`">
                                    <a class="btn btn-outline-warning mr-1" tabindex="-1" role="button" aria-disabled="true">Detalhes</a>
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
    props:{
        books: Array
    },
    data(){
        return{

        }
    },
    created(){

    },

    methods: {

    }

}
</script>

<style>

</style>
