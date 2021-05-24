<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #3CB371">
            <a class="navbar-brand" href="#">Club do Livro</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="#">Associados</a>
                    </li>

                </ul>
                <ul class="navbar-nav">
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
