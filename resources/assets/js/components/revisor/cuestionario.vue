<template>
    <div>
        <div class="container">
            <div class="row" v-for="item in dimensiones">
                <div v-if="item.estado">
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <h4 class="lead text-info">Dimension : {{item.dimension.dimension}}</h4>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

                            <div class="btn-group inline">
                                <button type="button" class="btn btn-warning"
                                        @click="changeDimensionBackWard" :disabled="dimensionActual.disabled">
                                    {{dimensionActual.atras}}
                                </button>
                                <button type="button" class="btn btn-info"
                                        @click="changeDimensionForward">{{dimensionActual.adelante}}
                                </button>
                            </div>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            <button class="btn btn-success" @click="terminar" v-if="showTerminarButton">
                                Terminar
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h4 class="text-center">Requisitos</h4>
                                    <hr>
                                    <ul class="list-group" v-for="requisito in item.dimension.get_requisitos">
                                        <li class=" btn-default list-group-item selectable"
                                            @click="showPreguntas(requisito.id, requisito.nombreRequisito)">
                                            {{requisito.nombreRequisito}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p>Requisito a Evaluar : {{initPreguntas.nombreRequisito}}
                                        <span class="text-success"></span>
                                    </p>
                                    <hr>
                                    <div class="row" v-for="pregunta in preguntas">
                                        <div v-if="initPreguntas.idRequisito == pregunta.idRequisito">
                                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                <p class="pull-left">{{pregunta.pregunta}}</p>
                                                <br>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <el-collapse v-model="collapse" @change="handleChange">
                                                            <el-collapse-item title="Observaciones"
                                                                              :name="pregunta.idPregunta">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                                             v-if="pregunta.numeral">
                                                                            <h5 class="text-center">Cantidad</h5>
                                                                            <el-input-number
                                                                                    class="fullWidth pull-left"
                                                                                    v-model="pregunta.inputNumeral"
                                                                                    size="small">
                                                                            </el-input-number>
                                                                        </div>
                                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                                             v-if="pregunta.documental">
                                                                            <h5 class="text-center">Añadir
                                                                                evidencia</h5>
                                                                            <button class="btn btn-sm btn-success btn-block"
                                                                                    @click="addObservaciones(pregunta.id)">
                                                                                <icon name="plus-circle"
                                                                                      scale="1"></icon>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                             v-if="pregunta.escrita">
                                                                            <h5 class="text-center"> Observacion </h5>
                                                                            <el-input
                                                                                    v-model="pregunta.inputEscrito"
                                                                                    type="textarea"
                                                                                    :rows="2"
                                                                                    placeholder="Agregue una observacion">
                                                                            </el-input>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </el-collapse-item>
                                                        </el-collapse>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <el-radio-group v-model="pregunta.opcion" class="pull-right">
                                                    <el-radio :label="1">Cumple</el-radio>
                                                    <el-radio :label="0">No Cumple</el-radio>
                                                </el-radio-group>
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
        <el-dialog title="Observaciones" v-model="observacionDialogVisible" size="large">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                    <el-upload
                            class="centerable center center-block"
                            action="//localhost/api/recibir/archivos"
                            name="documentos"
                            type="drag"
                            :data="subirArchivo"
                            :multiple="true"
                            :headers="headers"
                            :before-upload="beforeUpload"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :default-file-list="fileList">
                        <i class="el-icon-upload"></i>
                        <div class="el-dragger__text">Arrastre archivos hasta aca o , <em>Toque aqui para subir</em>
                        </div>
                        <div class="el-upload__tip" slot="tip"></div>
                    </el-upload>
                </div>
                <h5>Previsualización</h5>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 borderRight">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <img :src="selectedImg.img" class="img img-rounded img-responsive"
                                 style="margin: 0 auto; max-height: 200px;max-width: 200px">
                            <hr>
                            <br>
                            <h4 class="text-center">{{selectedImg.name}}</h4>
                        </div>
                    </div>

                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="observacionDialogVisible = false">Cancelar</el-button>
                <el-button type="primary" @click="hideUpload">Confirmar</el-button>
              </span>
        </el-dialog>


    </div>
</template>
<style>
    .centerable {
        margin: 0 auto;
    }

    .borderLeft {
        border-left: 1px solid black;
    }

    .borderRight {
        border-left: 1px solid #F5F8FA;
        height: 300px;
    }

    .selectable:hover {
        cursor: pointer;
    }

    input.el-upload__input {
        display: none;
    }

    .fullWidth {
        width: 100%;
    }
</style>
<script>

    import _ from 'lodash';
    import Icon from 'vue-awesome/components/Icon.vue'
    import 'vue-awesome/icons'
    export default {

        mounted(){
            this.initialization();
        },

        data () {
            return {
                data: '',
                dimensiones: [],
                preguntas: [],
                dimensionActual: {
                    adelante: 'Siguiente',
                    atras: 'Atras',
                    disabled: false,
                },
                initPreguntas: {
                    idRequisito: '',
                    nombreRequisito: '',
                },
                headers: {
                    'X-CSRF-TOKEN': Laravel.csrfToken
                },
                selectedImg: {
                    img: '',
                    name: ''
                },
                subirArchivo: {
                    idPregunta: '',
                    data: '',
                },
                divisionLoaded: false,
                observacionDialogVisible: false,
                showTerminarButton: false,
                collapse: ''
            }
        },

        methods: {

            initialization(){
                this.$http.get('api/carga/inicial').then((response) => {
                    this.data = response.data;
                    let data = response.data;
                    let self = this;
                    Object.keys(data).forEach((key, index) => {
                        let obj = {
                            dimension: data[key],
                            estado: index == 0
                        };
                        self.dimensiones.push(obj);
                    })
                }, (response) => {
                    console.log(response.status)
                });
            },

            showPreguntas(idRequisito, nombreRequisito){

                this.initPreguntas.idRequisito = idRequisito;
                this.initPreguntas.nombreRequisito = nombreRequisito;

                if (this.divisionLoaded === false) {
                    this.division();
                }
                this.divisionLoaded = true;
            },


            addObservaciones(id){
                console.log(id);
            },


            division(){
                let self = this;
                let data = this.data;
                let requisitos = [];
                let preguntas = [];

                Object.keys(data).forEach((item, index) => {
                    requisitos.push(data[item].get_requisitos);
                });


                let mergeRequisitos = [].concat.apply([], requisitos);
                mergeRequisitos.forEach((f) => {
                    preguntas.push(f.get_preguntas);
                });
                let mergePreguntas = [].concat.apply([], preguntas);

                mergePreguntas.forEach((i) => {
                    let pregunta = {
                        idPregunta: '',
                        idRequisito: '',
                        pregunta: '',
                        numeral: '',
                        escrita: '',
                        documental: '',
                        tecnicaAuditoria: '',
                        opcion: '',
                        inputNumeral: '',
                        inputEscrito: '',
                    };


                    pregunta.idPregunta = i.id;
                    pregunta.idRequisito = i.idRequisito;
                    pregunta.pregunta = i.pregunta;
                    pregunta.numeral = i.numeral == 1;
                    pregunta.escrita = i.escrita == 1;
                    pregunta.documental = i.documental == 1;
                    pregunta.tecnicaAuditoria = i.tecnicaAuditoria;
                    self.preguntas.push(pregunta);
                });


            },

            changeDimensionForward(){
                let dimensiones = this.dimensiones;
                let dimLenght = dimensiones.length;
                let active = _.findIndex(dimensiones, {'estado': true});

                if (active < dimLenght - 1) {
                    dimensiones[active].estado = false;
                    dimensiones[active + 1].estado = true;
                } else {
                    this.showTerminarButton = true;
                }


            },

            changeDimensionBackWard(){
                let dimensiones = this.dimensiones;
                let dimLenght = dimensiones.length;
                let active = _.findIndex(dimensiones, {'estado': true});
                let self = this;
                if (active > 0) {
                    dimensiones[active].estado = false;
                    dimensiones[active - 1].estado = true;
                } else {
                    console.log('Te pasaste papa');
                }


            },

            addObservaciones(id){
                this.subirArchivo.idPregunta = id;
                this.observacionDialogVisible = true;
            },
            beforeUpload(file){
                this.subirArchivo.data = this.datosRevision.idOficinaAsignada;
            },
            handleSuccess(){

            },
            handleError(){

            },
            handlePreview(file, fileList){
                this.selectedImg.img = file.url;
                this.selectedImg.name = file.name;
            },
            handleRemove(file, fileList) {
                console.log(file);
                console.log(fileList)
            },
            hideUpload(){
                this.observacionDialogVisible = false;
                this.fileList = [];

            },

            handleChange(){

            },

            terminar(){
                let data = {
                    preguntas: this.preguntas,
                    oficina: this.datosRevision,
                };

                this.$http.post('/api/terminar/checklist', data).then((response) => {
                    console.log(response.data)
                }, (response) => {
                    console.log(response)
                });
            }


        },

        props: {
            datosRevision: Object
        },

        components: {
            'icon': Icon
        }
    }
</script>
