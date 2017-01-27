<template>
    <div>

        <div class="row">

            <h4 class="text-center">Oficinas pendientes para revision</h4>
            <hr>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <h4 class="text-center">Oficinas pendientes</h4>
                <ul class="list-group" v-for="oficinas in oficinasPendientes">
                    <li class="btn list-group-item" @click="informacionOficinas(oficinas)">{{oficinas.region}}</li>
                </ul>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

                <div class="panel panel-default" v-if="mostrarInformacion">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <ul class="list-group">
                                    <li class="list-group-item">Zona : <b>{{oficinaSeleccionada.zona}}</b></li>
                                    <li class="list-group-item">N° de llamado interno : <b>{{oficinaSeleccionada.numeroLlamadoInterno}}</b>
                                    </li>
                                    <li class="list-group-item">N° zona licitacion : <b>{{oficinaSeleccionada.numeroZonaLicitacion}}</b>
                                    </li>
                                    <li class="list-group-item">Region : <b>{{oficinaSeleccionada.region}}</b></li>
                                    <li class="list-group-item">Comuna : <b>{{oficinaSeleccionada.comuna}}</b></li>
                                    <li class="list-group-item">Direccion : <b>{{oficinaSeleccionada.direccion}}</b>
                                    </li>
                                    <li class="list-group-item">Fono(s) : <b>{{oficinaSeleccionada.fono}}</b></li>
                                    <li class="list-group-item">Email : <b>{{oficinaSeleccionada.email}}</b></li>
                                </ul>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <h4 class="text-center">Asignar a un revisor.</h4>
                                <br>
                                <el-select class="fullWidth" v-model="asignar.idUsuario" size="large" filterable
                                           placeholder="Escriba o seleccione a un revisor de la lista">
                                    <el-option
                                            v-for="revisor in revisores"
                                            :label="revisor.get_usuario.name"
                                            :value="revisor.get_usuario.id">
                                        <span style="float: left">{{revisor.get_usuario.name }}</span>
                                        <span style="float: right" class="text-capitalize">{{revisor.get_nombre_perfil.perfil}} / + {{revisor.get_usuario.get_asignaciones.length }} </span>
                                    </el-option>
                                </el-select>

                                <br>
                                <br>
                                <button class="btn btn-block btn-md btn-success" @click="crearAsignacion">Asignar
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style>
    .fullWidth {
        width: 100%;
        min-width: 100%;
        max-width: 100%;
    }
</style>
<script>
    import _ from 'lodash';
    export default{

        mounted(){
            this.getRevisores();
            this.getOficinas();
        },
        data(){
            return {
                revisores: '',
                oficinasPendientes: [],
                oficinaSeleccionada: '',
                mostrarInformacion: false,
                asignar: {
                    idUsuario: '',
                    idOficina: ''
                }
            }
        },
        methods: {

            getRevisores(){
                this.$http.get('/api/traer/revisores').then((response) => {
                    this.revisores = response.data
                }, (response) => {
                    this.error(response.status)
                })
            },
            getOficinas(){
                this.$http.get('/api/traer/oficinas/').then((response) => {
                    let oficinas = response.data;
                    _.forEach(oficinas, (item) => {
                        item.get_asignaciones.length == 0 ? this.oficinasPendientes.push(item) : false;
                    });
                }, (response) => {
                    this.error(response.status)
                })
            },

            informacionOficinas(data){
                this.oficinaSeleccionada = data;
                this.asignar.idOficina = data.id;
                this.mostrarInformacion = true;
            },

            crearAsignacion(){
                let data = this.asignar;
                this.$http.post('/api/crear/asignacion', data).then((response) => {
                    this.oficinasPendientes.length = 0;
                    this.mostrarInformacion = false;
                    this.getOficinas();
                    this.getRevisores();
                    this.success();
                }, (response) => {
                    this.error(response.status)
                })
            },


            success(){
                this.$notify.success({
                    title: 'Exito',
                    message: 'La accion concluyo con exito'
                });
            },

            error(error){
                this.$notify.error({
                    title: 'Error',
                    message: 'Un error ocurrio . Codigo error : ' + error
                })
            }
        },
        components: {}
    }
</script>
