<template>
    <div>

        <div class="row">

        </div>

    </div>
</template>
<style>

</style>
<script>
    export default {

        mounted(){
            this.getRevisadas();
        },
        data () {
            return {

                data: ''
            }
        },

        methods: {
            getRevisadas(){
                this.$http.get('/api/asignaciones/revisadas').then((response) => {
                    console.log(response.data)
                }, (response) => {
                    console.log(response.statuss)
                })
            }
        }
    }
</script>
