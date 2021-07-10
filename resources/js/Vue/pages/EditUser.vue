<template>
    <div class="container-fluid d-flex justify-content-center h-100" style="margin-top: 10%" >
      <div class="card-body d-flex justify-content-center">
        <div class="alert alert-danger" role="alert" v-if="errors != null" style="align-self: center;">
                {{ errors }}
        </div>
        <p>{{ validatePassword }}</p>
        <form  method="POST" autocomplete="on" >
            <div class="form-group">
                <label >Nome:</label>
                <input type="text" name="user_name" class="form-control"
                v-model="user.name"
                placeholder="Nome">
            </div>
            <div class="form-group">
                <label> Senha: </label>
                <input type="password" name="new_password"  class="form-control"
                    id="inputEmail" aria-describedby="emailHelp"
                    v-model="user.password"
                    placeholder="Senha">
                <small id="msgemail" class="form-text text-muted"></small>
            </div>
            <div class="form-group">
                <label> Confirmar senha: </label>
                <input type="password" name="confirm_password" class="form-control"
                v-model="user.confirmPassword"
                placeholder="confirmação da senha">
            </div>
            <button type="submit" class="btn btn-info " style="width: 100%;" @click="update"> Salvar Alterações </button>
        </form>
    </div>
  </div>
</template>

<script>
export default {

    data(){
        return {
            user: {
                name: '',
                confirmPassword: '',
                password: '',
            },
            errors: null
        }
    },
    created(){
        this.user.name = localStorage.getItem('user')
    },
    methods: {
        update(e){
            e.preventDefault()
            axios.get('/sanctum/csrf-cookie').then(response =>{
                axios.put('api/updateUser', {
                    name: this.user.name,
                    password: this.user.password
                })
                .then(response => {
                    console.log(response.data);
                    if (response.data.success) {
                        this.emitter.emit('isLoggedIn', false)
                        this.$router.push('/login')
                    }else{
                        this.errors = response.data.message
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
            })

        }
    },
    computed:{
        validatePassword(){
            if((this.user.password !=="") && (this.user.confirmPassword !=="")){
                if((this.user.password !== this.user.confirmPassword)){
                    this.errors = 'Senhas não são as mesmas'
                }else{
                    this.errors = null
                }
            }else{
                this.errors = null
            }

        }
    }

}
</script>

<style>

</style>
