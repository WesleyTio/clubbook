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
                         <router-link class="nav-link" to="/livros">Livros</router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <span class="material-icons align-middle">person</span>
                            <span>{{name}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item " href="#"> Alterar dados</a>
                            <a class="dropdown-item" href="#"> Sair </a>
                        </div>
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
