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
                                                <hr>
                                                <small class="label label-default">Tecnica auditoria : <b>{{pregunta.tecnicaAuditoria}}</b>
                                                </small>
                                                <br>
                                                <br>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <el-radio-group v-model="pregunta.opcion" class="pull-right">
                                                    <el-radio :label="1">Cumple</el-radio>
                                                    <el-radio :label="0">No Cumple</el-radio>
                                                </el-radio-group>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <el-collapse v-model="collapse"
                                                                     @change="handleChange(pregunta.idPregunta)">
                                                            <el-collapse-item title="Observaciones"
                                                                              :name="pregunta.idPregunta">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
                                                                             v-if="pregunta.numeral">
                                                                            <h5 class="text-center">Cantidad</h5>
                                                                            <el-input-number
                                                                                    class="fullWidth pull-left"
                                                                                    v-model="pregunta.inputNumeral"
                                                                                    size="small">
                                                                            </el-input-number>
                                                                        </div>
                                                                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"
                                                                             v-if="pregunta.documental">
                                                                            <h5 class="text-center">Añadir
                                                                                evidencia</h5>

                                                                            <el-upload
                                                                                    class="centerable center center-block"
                                                                                    action="//localhost/DDP/public/api/recibir/archivos"
                                                                                    name="documentos"
                                                                                    type="drag"
                                                                                    :data="subirArchivo"
                                                                                    :multiple="false"
                                                                                    :headers="headers"
                                                                                    :before-upload="beforeUpload"
                                                                                    :on-preview="handlePreview"
                                                                                    :on-remove="handleRemove"
                                                                                    :on-success="handleSuccess"
                                                                                    :on-error="handleError"
                                                                                    :default-file-list="pregunta.fileList">
                                                                                <el-button size="small" type="primary">
                                                                                    Click aqui para subir
                                                                                </el-button>
                                                                                <div class="el-upload__tip" slot="tip">
                                                                                    o puede arrastrar archivos aca
                                                                                </div>
                                                                            </el-upload>
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
                                                <br>
                                                <br>
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


            if (this.datosRevision.estado === 'rechazado') {
                this.rejectedInitialization();
            }

        },

        data () {
            return {
                data: '',
                rejectedData: '',
                dimensiones: [],
                preguntas: [],
                filelist: [],
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
                    idRequisito: '',
                    idComuna: '',
                    idRegion: '',
                },
                divisionLoaded: false,
                observacionDialogVisible: false,
                showTerminarButton: false,
                rejectedCondition: false,
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

            rejectedInitialization(){
                let id = this.datosRevision.id;

                this.$http.get('api/carga/rechazada/inicial/' + id + '').then((response) => {
                    this.rejectedData = response.data;
                    this.rejectedCondition = true;
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
                        opcion: 0,
                        inputNumeral: '',
                        inputEscrito: '',
                        rutaObservaciones: '',
                        fileList: []
                    };

                    if (this.rejectedCondition === true) {
                        _.forEach(self.rejectedData, (r) => {
                            pregunta.opcion = r.cumplimiento;
                            pregunta.idPregunta = r.idPregunta;
                            pregunta.idRequisito = r.traer_preguntas.idRequisito;
                            pregunta.pregunta = r.traer_preguntas.pregunta;
                            pregunta.numeral = r.traer_preguntas.numeral == 1;
                            pregunta.escrita = r.traer_preguntas.escrita == 1;
                            pregunta.documental = r.traer_preguntas.documental == 1;
                            pregunta.inputNumeral = r.observacionNumeral == null ? 0 : r.observacionNumeral;
                            pregunta.inputEscrito = r.observacionEscrita == null ? '' : r.observacionEscrita;
                            pregunta.rutaObservaciones = r.rutaObservacionDocumental == null ? '' : r.rutaObservacionDocumental;
                            pregunta.tecnicaAuditoria = r.traer_preguntas.tecnicaAuditoria;
                            self.preguntas.push(pregunta);
                        })
                    } else {
                        pregunta.idPregunta = i.id;
                        pregunta.idRequisito = i.idRequisito;
                        pregunta.pregunta = i.pregunta;
                        pregunta.numeral = i.numeral == 1;
                        pregunta.escrita = i.escrita == 1;
                        pregunta.documental = i.documental == 1;
                        pregunta.tecnicaAuditoria = i.tecnicaAuditoria;
                        self.preguntas.push(pregunta);
                    }


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
                let active = _.findIndex(dimensiones, {'estado': true});
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

                this.subirArchivo.idRegion = this.datosRevision.get_oficinas_asignadas.get_comuna.idRegion;
                this.subirArchivo.idComuna = this.datosRevision.get_oficinas_asignadas.get_comuna.id;
            },
            handleSuccess(response, fileList){
                let preguntas = this.preguntas;
                let findPreguntaObj = _.find(preguntas, (i) => {
                    return i.idPregunta == response[0];
                });
                findPreguntaObj.rutaObservaciones = response[1];
                findPreguntaObj.fileList.push(fileList);
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

            handleChange(id){
                this.subirArchivo.idPregunta = id;
                this.subirArchivo.idRequisito = this.initPreguntas.idRequisito;
            },

            terminar(){
                let data = {
                    preguntas: this.preguntas,
                    oficina: this.datosRevision,
                };

                this.$http.post('api/terminar/checklist', data).then((response) => {
                    this.success();
                }, (response) => {
                    console.log(response)
                });
            },

            success(){
                this.$alert('Revision terminada con exito. Ahora se la pagina se recargara para obtener la informacion', 'Exito', {
                    confirmButtonText: 'OK',
                    callback: action => {
                        location.reload();
                    }
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
