<template>
    <div>

        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" v-for="item in dataRevisiones">
                <el-card>
                    <div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h4 class="text-center">Comuna :
                                    {{item.get_oficinas_asignadas.get_comuna.nombreComuna}}</h4>
                                <p class="text-center">
                                    <small>Region : {{item.get_oficinas_asignadas.get_comuna.get_region.nombreRegion}}
                                    </small>
                                </p>
                                <hr>
                                <p class="text-center">Asignante :
                                    <b class="text-capitalize">{{item.get_creador.name}}</b></p>
                                <p class="text-center">Revisor :
                                    <b class="text-capitalize">{{item.get_realizador.name}}</b></p>

                            </div>
                        </div>
                        <div class="bottom clearfix">
                            <button class="btn btn-success btn-block"
                                    @click="revisarAsignacion(item.get_cuestionario_realizado)">Revisar
                            </button>
                        </div>
                    </div>
                </el-card>
            </div>

        </div>

        <el-dialog title="Revision" v-model="revisionDialogVisible" size="full">
            <div class="row">
                <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">
                    <h4 class="text-center">Dimensiones</h4>
                    <el-menu class="el-menu-vertical-demo" v-for="item in dataDimensiones">
                        <el-submenu index="1">
                            <template slot="title">
                                {{item.dimension | truncate}}
                            </template>
                            <el-menu-item-group title="Requisitos">
                                <div v-for="(requisito, index) in item.get_requisitos">
                                    <el-menu-item index="1-index">
                                        <div @click="preguntaSeleccionada(requisito.id)">
                                            {{requisito.nombreRequisito}}
                                        </div>
                                    </el-menu-item>
                                </div>
                            </el-menu-item-group>
                        </el-submenu>
                    </el-menu>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <table class="table table-hover table-condensed table-responsive">
                        <thead>
                        <tr class="text-center">
                            <th>Pregunta</th>
                            <th>Cumplimiento</th>
                            <th>Observacion de Cantidad</th>
                            <th>Observacion Escrita</th>
                            <th>Observacion documental</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in pregunta">
                            <td>{{item.pregunta}}</td>
                            <td>{{item.cumplimiento == 0 ? 'No cumple' : 'Cumple'}}</td>
                            <td>{{item.observacionNumeral === null ? 'No hay observaciones' :
                                item.observacionNumeral}}
                            </td>
                            <td>{{item.observacionEscrita === null ? 'No hay observaciones' :
                                item.observacionEscrita}}
                            </td>
                            <td>
                                <button class="btn btn-success btn-block"
                                        @click="getDocs(item.rutaObservacionDocumental)">
                                    <icon name="folder-open-o"></icon>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="revisionDialogVisible = false" class="pull-left" size="large">Cerrar</el-button>
                <el-button type="danger" @click="openOpciones('rechazado')" size="large">Rechazar</el-button>
                <el-button type="success" @click="openOpciones('aprobado')" size="large">Aprobar</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Archivos" v-model="obsDialogVisible" size="large">

            <div class="row">


                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <el-upload
                            action="//jsonplaceholder.typicode.com/posts/"
                            :on-preview="handlePreview"
                            :default-file-list="fileList">
                    </el-upload>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                <div class="col-xs-7s col-sm-7s col-md-7s col-lg-7s">

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4 class="text-center">{{selected.name}}</h4>
                            <hr>
                            <img :src="selected.file" alt="" class="img img-rounded img-responsive"
                                 style="margin: 0 auto; max-height: 400px; max-width:400px">

                            <button class="btn btn-success pull-right">Descargar este archivo</button>
                        </div>
                    </div>

                </div>
            </div>


            <span slot="footer" class="dialog-footer">
            <el-button @click="obsDialogVisible = false" type="">Cerrar</el-button>
            <el-button type="primary">Descargar todo como ZIP</el-button>
          </span>
        </el-dialog>


        <el-dialog title="Opciones" v-model="opcionesDialogVisible" size="small">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4 class="text-center">Usted ha <b>{{opcion}}</b> esta revision</h4>

                    <label> Deje su observacion </label>
                    <el-input
                            type="textarea"
                            :rows="4"
                            placeholder="Escriba aca"
                            v-model="observaciones">
                    </el-input>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="opcionesDialogVisible = false" class="pull-left">Cancelar</el-button>
                <el-button @click="end" type="success">Enviar</el-button>
              </span>
        </el-dialog>


    </div>
</template>
<style>
    span.el-upload__btn-delete {
        display: none;
    }
</style>
<script>

    import _ from 'lodash'
    import jszip from 'jszip'
    import Icon from 'vue-awesome/components/Icon.vue'
    import 'vue-awesome/icons'
    export default {
        mounted(){
            this.getRevisadas();
        },
        data () {
            return {
                dataRevisiones: [],
                dataDimensiones: [],
                dataSelected: [],
                pregunta: [],
                docs: '',
                revisionDialogVisible: false,
                obsDialogVisible: false,
                opcionesDialogVisible: false,
                selected: {
                    file: '',
                    name: '',
                    url: ''
                },
                fileList: [],
                observaciones: '',
                opcion: ''

            }
        },

        methods: {
            getRevisadas(){
                this.$http.get('/api/asignaciones/revisadas').then((response) => {
                    this.dataRevisiones = response.data[0];
                    this.dataDimensiones = response.data[1];
                }, (response) => {
                    console.log(response.status)
                })
            },

            revisarAsignacion(item){
                this.dataSelected = item;
                this.revisionDialogVisible = true;
            },
            preguntaSeleccionada(id){

                let self = this;
                let dimensiones = self.dataDimensiones;
                let revision = self.dataRevisiones;


                let preguntas = [];
                let observaciones = [];

                self.pregunta.length = 0;
                _.forEach(dimensiones, (f) => {
                    _.forEach(f.get_requisitos, (a) => {
                        _.forEach(a.get_preguntas, (e) => {
                            e.idRequisito == id ? preguntas.push(e) : false
                        })
                    })
                });


                _.forEach(preguntas, (o) => {
                    _.forEach(revision, (r) => {
                        _.forEach(r.get_cuestionario_realizado, (c) => {
                            c.idPregunta == o.id ? observaciones.push(c) : false;
                        })
                    })
                });


                _.forEach(preguntas, (p) => {
                    let collection = {
                        pregunta: '',
                        cumplimiento: '',
                        observacionNumeral: '',
                        observacionEscrita: '',
                        rutaObservacionDocumental: ''
                    };

                    collection.pregunta = p.pregunta;

                    _.forEach(observaciones, (o) => {
                        collection.cumplimiento = o.cumplimiento;
                        collection.observacionNumeral = o.observacionNumeral;
                        collection.observacionEscrita = o.observacionEscrita;
                        collection.rutaObservacionDocumental = o.rutaObservacionDocumental
                    });
                    self.pregunta.push(collection);
                });
            },

            getDocs(ruta){

                this.fileList.length = 0;
                let rutaDocs = {
                    ruta: ruta
                };

                this.$http.post('/api/traer/docs', rutaDocs).then((response) => {
                    jszip.loadAsync(response.data).then((zip) => {
                        _.forEach(zip, (item) => {
                            _.forEach(item, (a) => {
                                jszip.loadAsync(response.data).then((zip) => {
                                    return zip.file(a.name).async("Uint8Array")
                                }).then((i) => {
                                    let blob = new Blob([i], {type: "application/octet-stream"});
                                    let urlCreator = window.URL || window.webkitURL;
                                    let imageUrl = urlCreator.createObjectURL(blob);
                                    this.fileList.push({
                                        name: a.name,
                                        url: imageUrl,
                                        type: a.name.split('.').pop()
                                    });
                                });
                            })
                        });
                    });
                });
                this.obsDialogVisible = true;
            },
            handlePreview(file){
                this.selected.file = file.url;
                this.selected.name = file.name;
                this.selected.url = file.url + '.' + file.type;
            },

            openOpciones(opcion){
                this.opcion = opcion;
                this.opcionesDialogVisible = true;
            },

            end(){
                let data = {
                    observacion: this.observaciones,
                    opcion: this.opcion,
                    idAsignacion: this.dataSelected[0].idAsignacion
                };


                this.$http.post('/api/terminar/revision', data).then((response) => {
                    this.opcionesDialogVisible = false;
                    this.success();
                }, (response) => {
                    this.opcionesDialogVisible = false;
                    this.error(response.status)
                })


            },
            success(){
                this.$notify.success({
                    title: 'Exito',
                    message: 'La accion ha culminado con exito.'
                })
            },
            error(error){
                this.$notify.error({
                    title: 'Error',
                    message: 'La accion ha terminado con un error : ' + error
                })
            }


        },
        filters: {
            truncate: function (value) {
                return value.substring(0, 35) + '...';
            }

        },
        components: {
            'icon': Icon
        }
    }
</script>
