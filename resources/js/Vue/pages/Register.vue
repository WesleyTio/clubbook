<template>
    <div>
        <UserForm></UserForm>
    </div>
</template>

<script>
import UserForm from '../components/UserForm'
export default {
    components: { UserForm },
    data(){
        return {
            user: {
                name: '',
                email: '',
                password: '',
                error: null
            }
        }
    },
    methods: {
        register(e){
            e.preventDefault()
            this.$http.get('/sanctum/csrf-cookie').then(response =>{
                this.$http.post('api/register', {
                    name: this.user.name,
                    email: this.user.email,
                    password: this.user.password
                })
                .then(response => {
                    console.log(response.data);
                    if (response.data.success) {
                        //this.$router.go('/dashboard')
                    } else {
                        this.user.error = response.data.message
                    }

                })
                .catch(function (error) {
                    console.error(error);
                });
            })

        }
    }

}
</script>

<style>

</style>
