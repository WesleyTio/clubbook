<template>
    <div>
        <Navbar></Navbar>
        <div class="justify-content-center container-fluid my-4 ">
        <Search></Search>
        <ListBooks></ListBooks>
        </div>
    </div>
</template>

<script>
import Navbar from '../components/Navbar'
import Search from '../components/Search'
import ListBooks from '../components/ListBooks'
export default {

    components: { Navbar, Search, ListBooks }

}
</script>

<style>

</style>
