<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #3CB371">
            <router-link class="navbar-brand" to="/">Club do Livro</router-link>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0" v-if="isLoggedIn">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/books">Livros</router-link>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            <span class="material-icons align-middle">person</span>
                            <span>{{name}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                      <router-link class="nav-link" to="/books">Alterar dados </router-link>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" type="submit" @click.prevent="logout">Sair </a>
                    </li>
                </ul>
                <ul class="navbar-nav" v-else>
                    <li class="nav-item ">
                        <router-link  to="/login">
                            <a class="nav-link" >Login</a>
                        </router-link>
                    </li>
                    <li class="nav-item ">
                        <router-link class="nav-link" to="/register">Registrar</router-link>
                    </li>
                </ul>

            </div>
        </nav>
    </div>
</template>

<script>
export default {

    data() {
        return {
            name: null,
            isLoggedIn: false
        }
    },
    created() {

    },
    mounted(){
        this.emitter.on('isLoggedIn', isLoggedIn => {
            console.log("foi ouvido")
            this.isLoggedIn = true
            //
        })
        this.name = localStorage.getItem('user')
    },
    methods: {
        logout(){
            axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/api/logout')
                .then(response => {
                    if (response.data.success) {
                        console.log(response)
                        localStorage.removeItem('isLoggedIn')
                        localStorage.removeItem('user')
                        this.isLoggedIn = false
                        this.$router.replace('/')
                    } else {
                        console.log(response)
                    }
                })
                .catch(function (error) {
                        console.error(error);
                });
            })

        }
    },
    beforeRouteEnter(to, from, next) {

    }

}
</script>

<style>

</style>
