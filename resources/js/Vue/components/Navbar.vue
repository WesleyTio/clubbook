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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            <span class="material-icons align-middle">person</span>
                            <span>{{name}}</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><a class="dropdown-item " href="#"> Alterar dados</a></li>
                            <li><a class="dropdown-item" href="#"> Sair </a> </li>
                        </ul>
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
        <nav  class="navbar navbar-expand-lg navbar-dark" style="background-color: #3CB371">
            <router-link class="navbar-brand" to="/">Club do Livro</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0" v-if="isLoggedIn">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/books">Livros</router-link>
                    </li>

                </ul>
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0" v-else>

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
            isLoggedIn: false,

        }
    },
    created() {
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name
            this.isLoggedIn = true
        }
    },

}
</script>

<style>

</style>
