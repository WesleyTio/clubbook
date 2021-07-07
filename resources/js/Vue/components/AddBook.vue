<template>
    <div>
         <div class="row">
            <div id="img" class="m-1 col-3" style="height: 230px; background-color: #000 ">
            </div>
            <div id="formulario" class="col-8">
                <form  method="POST" autocomplete="on" >
                    <div class="form-group">
                        <label>Titulo:</label>
                        <input type="text" class="form-control"  v-model="name" placeholder="A divina..."/>
                        <p>{{validateName}}</p>
                    </div>

                    <div class="form-group">
                        <label>Autor:</label>
                        <input type="text"  class="form-control" v-model="author" placeholder="Dante "/>
                    </div>
                    <div class="form-group">
                        <label>Descrição:</label>
                        <textarea type="text"  class="form-control" v-model="description" placeholder="Este livro conta..."/>
                    </div>
                    <button type="submit" class="btn btn-success " style="width: 20%;" @click="save"> Salvar </button>
                </form>
            </div>
         </div>
    </div>
</template>

<script>
export default {
   data(){
      return{
        name: '',
        author: '',
        description: '',
        booksName: []
      }
   },
   beforeCreate(){
       axios.get('/sanctum/csrf-cookie').then(response =>{
           axios.get('api/books').then(response =>{
               console.log(response.data);
                if(response.data.success){
                    this.booksName = response.data.message;

                }
           })
       })
   },
   methods:{
        save(e){
            e.preventDefault()
            const id = localStorage.getItem('userId')
            axios.get('/sanctum/csrf-cookie').then(response =>{
               axios.post('api/add', {
                    name: this.name,
                    author: this.author,
                    description: this.description,
                    user_id: id
                })
                .then(response => {
                    console.log(response.data);
                    this.$router.go(-1)


                })
                .catch(function (error) {
                    console.error(error.data);
                });
            })
        },


   },
   computed: {
        validateName(){
            const item = this.booksName.filter(element => element.name.toLowerCase().trim() === this.name.toLowerCase().trim());
            if(item.length){
                this.name = ''
                alert("Já existe um livro cadastrado com esse titulo!")
            }
                //verifica se o nome do livro já não existe na base de dados
        }
   }

};
</script>

<style>
</style>
