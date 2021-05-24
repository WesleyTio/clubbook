<template>
  <div id="list" class="row">
    <div class="table-responsive col-md-12">
        <table id="tabela_user" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" >Nome</th>
                    <th scope="col" >Autor</th>
                    <th scope="col" >Alterar</th>
            </tr>
            </thead>
            <tbody>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <!-- desbilita os botoes caso o usuario listado seja Admin-->
                            <div>

                                <a class="btn btn-outline-primary" tabindex="-1" role="button" aria-disabled="true"
                                    href="#">Editar</a>
                                <a class="btn btn-outline-danger" tabindex="-1" role="button" aria-disabled="true" href="#">Deletar</a>

                            </div>
                        </td>
                    </tr>

            </tbody>
        </table>
    </div>

</div>
</template>

<script>
export default {

}
</script>

<style>

</style>
