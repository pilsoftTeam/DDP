<template>
    <div>
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
                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
                                                     v-if="preguntas.escrita != 0">
                                                    <el-input
                                                            type="textarea"
                                                            :rows="2"
                                                            placeholder="Please input">
                                                    </el-input>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
                                                     v-if="preguntas.numeral != 0">
                                                    <el-input-number size="small"></el-input-number>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
                                                     v-if="preguntas.documental != 0">
                                                    <button class="btn btn-xs btn-info"
                                                            @click="addObservaciones()">
                                                        Añadir observaciones
                                                    </button>
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
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <el-upload
                            style="margin: 0 auto"
                            class="center center-block"
                            action="http://localhost/api/recibir/archivos"
                            type="drag"
                            :headers="headers"
                            :multiple="true"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-success="handleSuccess"
                            :on-error="handleError">
                        <i class="el-icon-upload"></i>
                        <div class="el-dragger__text">Arrastre aqui o <em>haga click para subir archivos</em></div>
                        <div class="el-upload__tip" slot="tip">Considerar que sean menor a 500kb</div>
                    </el-upload>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <h5>Previsualización</h5>
                    <img :src="selectedImg" class="img img-rounded img-responsive"
                         style="margin: 0 auto; max-height: 400px;max-width: 400px">
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="observacionDialogVisible = false">Cancelar</el-button>
                <el-button type="primary" @click="observacionDialogVisible = false">Confirmar</el-button>
              </span>
        </el-dialog>
    </div>
</template>
<style>
    .selectable:hover {
        cursor: pointer;
    }

    input.el-upload__input {
        display: none;
    }

</style>
<script>
    export default{

        mounted(){
            this.init();
        },
        data(){
            return {
                initialization: '',
                dimensionLayer: [],
                preguntasLayer: {
                    nombreRequisito: '',
                    preguntas: ''
                },
                archivos: [],
                final: [],
                active: 1,
                radio: '',
                headers: {
                    'X-CSRF-TOKEN': Laravel.csrfToken
                },
                observacionDialogVisible: false,
                selectedImg: ''
            }
        },

        props: {
            data: Object
        },

        methods: {

            init(){
                this.$http.get('api/carga/inicial').then((response) => {

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
            addObservaciones(){
                this.observacionDialogVisible = true;
            },


            next() {
                if (this.active++ > 2) this.active = 0;
            },
            crearRespuesta(res){
                console.log(res);
            },


            sendDocs(){
                let fileList = this.archivos;
                this.$http.post('/api/receive/docs', fileList).then((response) => {
                    console.log(response.data)
                }, (response) => {
                    console.log(response)
                })
            },


            handlePreview(file){
                //this.selectedImg = file.url;


                this.$http.get(file.url).then((response) => {

                })

            },

            handleRemove(a, file){

            },
            handleSuccess(res, file){
                let self = this;
                let obj = {
                    name: '',
                    file: ''
                };
                Object.keys(file).forEach(function (item, index) {
                    console.log(item + ':' + file[item]);
                });
                //self.archivos.push(obj);


            },
            handleError(res, file){

            },

        },

        components: {}
    }
</script>
