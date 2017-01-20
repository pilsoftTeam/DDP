<template>
    <div>





    </div>
</template>
<style>

</style>
<script>
    export default{
        data(){
            return {


            }
        },

        methods: {


            error(errorDescription) {
                this.$notify.error({
                    title: 'Error',
                    message: 'Ha ocurrido un error. Por favor intentelo mas tarde. Error :' + errorDescription + ''
                });
            },

            success(){
                this.$notify.success({
                    title: 'Exito',
                    message: 'La accion ha sido completada de manera exitosa',
                });
            }
        },
        components: {}
    }
</script>
