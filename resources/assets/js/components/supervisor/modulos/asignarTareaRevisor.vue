<template>
    <div>

        <div class="row">

            <h4 class="text-center">Oficinas pendientes para revision</h4>
            <hr>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <h4 class="text-center">Regiones</h4>
                <el-menu class="el-menu-vertical-demo" v-for="regiones in oficinasPendientes">
                    <el-submenu index="1">
                        <template slot="title">{{regiones.nombreRegion}}</template>
                        <el-menu-item-group title="Comunas">
                            <div v-for="(comunas, index) in regiones.get_comunas">
                                <el-menu-item index="1-index">
                                    <div @click="informacionOficinas(comunas.get_oficinas)">
                                        {{comunas.nombreComuna}}
                                    </div>
                                </el-menu-item>
                            </div>
                        </el-menu-item-group>
                    </el-submenu>
                </el-menu>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <div class="panel panel-default" v-if="mostrarInformacion">
                    <div class="panel-body dialogRow">
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>

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
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
                        </div>
                        <hr>
                        <h4 class="text-center">Datos de oficina</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <table class="table table-hover well">
                                    <thead>
                                    <tr>
                                        <th v-for="(item , index, key ) in  oficinaSeleccionada">{{index}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td v-for="(item , index, key ) in  oficinaSeleccionada"> {{item}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div v-if="mostrarAsignado">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body dialogRow">
                                    <h4 class="text-center">Tarea ya asignada</h4>
                                    <h6 class="text-center">Detalles</h6>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                            <div class="list-group">
                                                <a href="#" class="list-group-item">
                                                    <h4 class="list-group-item-heading">Informacion Oficina</h4>
                                                    <hr>
                                                    <div class="list-group-item-text">

                                                        <h5>Zona :
                                                            <span class="label label-success">{{oficinaSeleccionada.zona}}</span>
                                                        </h5>
                                                        <h5>N° zona licitación :
                                                            <span class="label label-success">{{oficinaSeleccionada.numeroZonaLicitacion}}</span>
                                                        </h5>
                                                        <h5>N° llamado interno :
                                                            <span class="label label-success">{{oficinaSeleccionada.numeroLlamadoInterno}}</span>
                                                        </h5>
                                                        <h5>Direccion :
                                                            <span class="label label-success">{{oficinaSeleccionada.direccion}}</span>
                                                        </h5>
                                                        <h5>Email :
                                                            <span class="label label-success">{{oficinaSeleccionada.email}}</span>
                                                        </h5>
                                                        <h5>Fono :
                                                            <span class="label label-success">{{oficinaSeleccionada.fono}}</span>
                                                        </h5>

                                                    </div>
                                                </a>
                                            </div>

                                        </div>


                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                            <div class="list-group">
                                                <a href="#" class="list-group-item">
                                                    <h4 class="list-group-item-heading">Informacion Asignacion</h4>
                                                    <hr>
                                                    <div class="list-group-item-text"
                                                         v-for="a in oficinaSeleccionada.get_asignaciones">
                                                        <h5>Creador :
                                                            <span class="label label-success">{{a.get_creador.name}}</span>
                                                        </h5>
                                                        <h5>Usuario asignado :
                                                            <span class="label label-success">{{a.get_realizador.name}}</span>
                                                        </h5>
                                                        <h5>Fecha asignacion :
                                                            <span class="label label-success">{{a.created_at}}</span>
                                                        </h5>
                                                        <h5>Estado :
                                                            <span class="label label-info">{{a.estado}}</span>
                                                        </h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>


                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
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
<style>
    .fullWidth {
        width: 100%;
        min-width: 100%;
        max-width: 100%;
    }

    .dialogRow {
        min-height: 75vh;
        max-height: 100%;
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
                oficinasPendientes: '',
                oficinaSeleccionada: '',
                mostrarInformacion: false,
                mostrarAsignado: false,
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
                this.$http.get('/api/traer/oficinas').then((response) => {
                    this.oficinasPendientes = response.data;
                    let oficinas = response.data;
                    //_.forEach(oficinas, (item) => {
                    //    console.log(item);
                    //    //item.get_asignaciones.length == 0 ? this.oficinasPendientes.push(item) : false;
                    //});
                }, (response) => {
                    this.error(response.status)
                })
            },

            informacionOficinas(data){


                if (data[0].get_asignaciones.length > 0) {
                    this.mostrarInformacion = false;
                    this.mostrarAsignado = true;
                    this.oficinaSeleccionada = _.omit(data[0], 'id', 'created_at', 'updated_at', 'idComuna');
                } else {
                    this.mostrarAsignado = false;
                    this.mostrarInformacion = true;
                    this.asignar.idOficina = data[0].id;
                    this.oficinaSeleccionada = _.omit(data[0], 'id', 'created_at', 'updated_at', 'idComuna', 'get_asignaciones');

                }

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
