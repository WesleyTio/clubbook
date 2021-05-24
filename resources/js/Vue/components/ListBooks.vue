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
        this.$http.get('/sanctum/csrf-cookie')
            .then(response =>{
                this.$http.get('/api/lastadd')
                .then(response =>{
                    console.log(response.data)
                    this.books = response.data
                })
            })
            .catch(function (error) {
                console.error(error);
            });
    }

}
</script>

<style>

</style>
