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
         description: ''
      }
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
        }

   }

};
</script>

<style>
</style>
