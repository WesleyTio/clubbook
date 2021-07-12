<template>
    <div>
        <div class="col-8">
            <form>
                <div class="input-group h2">
                    <input
                        name="data[search]"
                        class="form-control"
                        id="busca_user"
                        type="text"
                        placeholder="Titulos, autores e descrição"
                        v-model="search"
                    />
                    <p>{{ emptySearch }}</p>
                    <div class="input-group-append">
                        <button
                            type="submit"
                            class="input-group-text text-light"
                            style="background-color: #3cb371"
                            @click="searchBook"
                        >
                            <i class="material-icons">search</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div id="list" class="row" v-if="viewTable">
            <div class="table-responsive col-md-12">
                <table id="tabela_user" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="book in books" :key="book.id">
                            <td>{{ book.name }}</td>
                            <td>{{ book.author }}</td>
                            <td>{{ book.description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            viewTable: false,
            books: [],
            search: ''
        };
    },
    computed: {
        emptySearch(){
            if(this.search === ""){
                this.viewTable = false
                this.emitter.emit('viewTable', true)
            }
        }
    },
    methods: {
        searchBook(e){
            e.preventDefault(),
            axios.get(`api/searchBook/${this.search}`).then((response) => {
                if(response.data.success){
                    this.emitter.emit('viewTable', false)
                    this.books = response.data.table
                    this.viewTable = true
                }
            }).catch((error) => {
               // this.emitter.emit('isLoggedOff', false)
                //this.$router.push('/login')
                console.error(error)
            })

        }
    }
};
</script>

<style>
</style>
