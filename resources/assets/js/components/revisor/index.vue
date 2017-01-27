<template>
    <div>
        <button @click="assignForms">ASS</button>
        <div class="row" v-for="item in dimensionLayer">

            <div v-if="item.estado">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4 class="lead text-info">Dimension : {{item.dimension.dimension}}</h4>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4 class="text-center">Requisitos</h4>
                                <hr>
                                <ul class="list-group" v-for="requisito in item.dimension.get_requisitos">
                                    <li class=" btn-default list-group-item selectable"
                                        @click="showPreguntas(requisito.nombreRequisito, requisito.get_preguntas)">
                                        {{requisito.nombreRequisito}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p>Requisito a Evaluar : {{preguntasLayer.nombreRequisito}}
                                    <span class="text-success"></span>
                                </p>
                                <hr>
                                <div>
                                    <div class="row" v-for="preguntas in preguntasLayer.preguntas">
                                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                            <h4>{{preguntas.pregunta}}</h4>

                                            <small class="text-info">Técnica de Auditoría
                                                :{{preguntas.tecnicaAuditoria}}
                                            </small>
                                            <br>
                                            <br>

                                            <div class="row">

                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                     v-if="preguntas.numeral != 0">
                                                    <el-input-number
                                                            class="fullWidth"
                                                            :model="final.num[preguntas.id]"
                                                            size="small"
                                                    ></el-input-number>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                     v-if="preguntas.documental != 0">
                                                    <button class="btn btn-xs btn-info btn-block"
                                                            @click="addObservaciones(preguntas.idPregunta)">
                                                        Añadir observaciones
                                                    </button>
                                                </div>


                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                     v-if="preguntas.escrita != 0">
                                                    <el-input
                                                            v-model="final.esc"
                                                            type="textarea"
                                                            :rows="2"
                                                            placeholder="Agregue una observacion">
                                                    </el-input>
                                                </div>


                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <el-radio-group v-model="radio" @change="crearRespuesta">
                                                <el-radio class="radio" label="true">
                                                    Cumple
                                                </el-radio>
                                                <el-radio class="radio" label="false">
                                                    No cumple
                                                </el-radio>
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
        <hr>
        <el-steps :space="100" :active="active" finish-status="success" class="pull-left">
            <el-step title="Dimension 1 "></el-step>
            <el-step title="Dimension 2"></el-step>
            <el-step title="Dimension 3"></el-step>
        </el-steps>
        <el-button class="pull-right" type="success" @click="next">Siguiente dimension</el-button>

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
    import _ from 'lodash'
    export default{

        mounted(){
            this.init();

        },
        data(){
            return {
                initialization: '',
                dimensionLayer: [],
                active: 1,
                radio: '',
                observacionDialogVisible: false,
                fileList: [],
                preguntasLayer: {
                    nombreRequisito: '',
                    preguntas: ''
                },
                selectedImg: {
                    img: '',
                    name: ''
                },
                subirArchivo: {
                    idPregunta: '',
                    data: '',
                },
                headers: {
                    'X-CSRF-TOKEN': Laravel.csrfToken
                },

                final: {
                    num: '',
                    esc: ''
                },
            }
        },

        props: {
            data: Object
        },

        methods: {
            init(){
                this.$http.get('api/carga/inicial').then((response) => {
                    this.initialization = response.data;
                    let data = response.data;
                    let self = this;
                    Object.keys(data).forEach((key, index) => {
                        let obj = {
                            dimension: data[key],
                            estado: index == 0
                        };
                        self.dimensionLayer.push(obj);
                    })
                }, (response) => {
                    console.log(response.data);
                })
            },
            showPreguntas(nombreRequisito, preguntas){

                this.preguntasLayer.nombreRequisito = nombreRequisito;
                this.preguntasLayer.preguntas = preguntas;
            },
            addObservaciones(id){
                this.subirArchivo.idPregunta = id;
                this.observacionDialogVisible = true;
            },

            next() {
                if (this.active++ > 2) this.active = 0;
            },
            crearRespuesta(res){
                console.log(this);
            },

            beforeUpload(file){
                this.subirArchivo.data = this.data.idOficinaAsignada;
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

            assignForms(){
                let item = this.initialization;
                let self = this;
                let requisitosArray = [];
                let preguntasArray = [];

                Object.keys(item).forEach((value, index) => {
                    let items = {
                        idDimension: '',
                        nombreDimension: '',
                        requisito: [],
                        pregunta: [],
                    };
                    items.idDimension = item[value].id;
                    items.nombreDimension = item[value].dimension;
                    requisitosArray.push(item[value].get_requisitos);
                    self.final.push(items);
                });
                console.log(preguntasArray);
                requisitosArray.forEach((item, index) => {
                    Object.keys(item).forEach((value, key) => {
                        let findDimension = _.find(self.final, (f) => {
                            return f.idDimension == item[value].idDimension
                        });
                        let objRequisitos = {
                            idRequisito: '',
                            nombreRequisito: ''
                        };
                        objRequisitos.idRequisito = item[value].id;
                        objRequisitos.nombreRequisito = item[value].nombreRequisito;
                        findDimension.requisito.push(objRequisitos);

                        let preguntas = item[value];

                        Object.keys(preguntas).forEach((v, i) => {
                            //console.log()
                            if (typeof preguntas[v] === 'object') {
                                console.log(preguntas[v]);
                            }

                        });


                    });
                })


            }
        },
    }
</script>
