<template>
    <div>
        <div class="container">
            <div class="row">


                <div class="col-xs-18 col-sm-12 col-md-12 col-lg-12">
                    <transition name="custom" enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOut">

                        <div v-if="init">
                            <div class="col-xs-18 col-sm-12 col-md-12 col-lg-12">

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <h4>A continuacion se muestran las revisiones que debera hacer :</h4>


                                        <hr>
                                        <div class="row">
                                            <div v-for="item in data">
                                                <div class="col-xs-18 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <h4 class="text-center">
                                                                {{item.get_oficinas_asignadas.get_comuna.nombreComuna}}</h4>
                                                            <p class="text-center">
                                                                <label class="label label-default">{{item.get_oficinas_asignadas.get_comuna.get_region.nombreRegion}}</label>
                                                            </p>
                                                            <hr>
                                                            <div class="well">
                                                                <p>Direccion :
                                                                    {{item.get_oficinas_asignadas.direccion}}</p>
                                                                <p>Fono : {{item.get_oficinas_asignadas.fono}}</p>
                                                                <p>Zona : {{item.get_oficinas_asignadas.zona}}</p>
                                                                <p>N° Llamado Zona interno :
                                                                    {{item.get_oficinas_asignadas.numeroLlamadoInterno}}</p>
                                                                <p>N° Zona licitación :
                                                                    {{item.get_oficinas_asignadas.numeroZonaLicitacion}}</p>
                                                            </div>


                                                            <button class="btn btn-success pull-right"
                                                                    @click="startRevision(item)">
                                                                Empezar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </transition>


                    <transition name="custom" enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div class="row" v-if="start">
                            <cuestionario :datosRevision="dataRevision"></cuestionario>
                        </div>
                    </transition>
                </div>


            </div>


        </div>

    </div>
</template>
<style>

</style>

<script>
    import cuestionario from './revisor/cuestionario.vue'
    export default {

        mounted(){
            this.getAsignaciones();
        },
        data() {
            return {

                data: '',
                dataRevision: '',
                init: true,
                start: false
            }
        },

        methods: {

            getAsignaciones(){
                this.$http.get('/api/traer/revisor/asignaciones').then((response) => {
                    this.data = response.data;
                }, (response) => {
                    console.log('Error : ' + response.status)
                })
            },

            startRevision(data){
                this.dataRevision = data;
                this.init = false;
                setTimeout(() => {
                    this.start = true;
                }, 1000)
            }
        },
        components: {
            'cuestionario': cuestionario
        }
    }
</script>
