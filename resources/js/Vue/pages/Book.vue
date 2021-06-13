<template>
    <div>
        <div class="col-12 m-2 ">
            <button type="button" class="btn btn-outline-success" >Adcionar Livro</button>
        </div>
        <UserBooks/>

    </div>

</template>

<script>
import UserBooks from './../components/UserBooks.vue'
export default {
    components: { UserBooks}

}
</script>

<style>

</style>
