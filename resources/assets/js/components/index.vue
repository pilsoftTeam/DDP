<template>
    <div>
        <div class="container">
            <div class="row">


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <transition name="custom" enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOut">

                        <div v-if="init">

                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <h4>A continuacion se muestran las revisiones que debera hacer :</h4>


                                        <hr>
                                        <div v-for="item in data">

                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Region :
                                                        {{item.get_oficinas_asignadas.region}}</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <h5>Tips y observaciones : </h5>
                                                    <hr>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab
                                                        minus
                                                        obcaecati
                                                        perferendis sed. Ad at dignissimos eligendi fuga id maiores nam
                                                        provident.
                                                        Atque, blanditiis dolorum facere impedit quas quia ullam?</p>

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
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>

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
                    this.data = response.data
                    console.log(response.data);
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
