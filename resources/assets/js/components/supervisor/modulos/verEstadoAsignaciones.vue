<template>
    <div>
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <ul class="list-group" v-for="item in asignados">
                    <li class="btn list-group-item text-capitalize" @click="mostrarAsignaciones(item)">
                        {{item.get_oficinas_asignadas.region}}&nbsp;
                        <label class="label label-info text-capitalize"> Estado :
                            {{item.estado}} </label>
                    </li>
                </ul>
            </div>

            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" v-if="showAsignaciones">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div>
                                    <h5>Datos del revisor</h5>
                                    <hr>
                                    <p>Nombre: <b>{{asignacionesData.get_realizador.name}}</b></p>
                                    <br>
                                    <h5>Datos de la asignacion</h5>
                                    <hr>
                                    <p>Fecha asignación: :
                                        <br> <b>{{asignacionesData.created_at}}</b></p>
                                    <p>Usuario creador
                                        <br>:<b>{{asignacionesData.get_creador.name}}</b></p>
                                </div>
                            </div>


                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"
                                 v-if="asignacionesData.estado === 'asignado'">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="text-center">
                                                    <icon name="info-circle" scale="5"></icon>
                                                </div>
                                                <h4 class="text-center">
                                                    Esta revision aun se encuentra en
                                                    proceso. Cuando este lista los resultados
                                                    se reflejaran en esta pantalla
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" v-else>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        ESTA REVISADO.

                                                        <button class="btn btn-block btn-lg btn-danger">
                                                            Rechazar esta revisión
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import _ from 'lodash'
    import Icon from 'vue-awesome/components/Icon.vue'
    import 'vue-awesome/icons/'
    export default{
        mounted(){
            this.getAsignados();
        },
        data(){
            return {
                asignados: '',
                asignacionesData: '',
                asignacionesRevisadas: '',
                showAsignaciones: false
            }
        },

        methods: {
            getAsignados(){
                this.$http.get('/api/traer/asignaciones').then((response) => {
                    this.asignados = response.data;
                    let data = response.data;
                    //_.forEach(data, (value) => {
                    //
                    //})

                    console.log(data.sort().reverse());

                }, (response) => {
                    console.log(response.status)
                })
            },

            mostrarAsignaciones(data){
                this.asignacionesData = data;
                this.showAsignaciones = true
            }
        },
        components: {
            'icon': Icon
        }
    }
</script>
