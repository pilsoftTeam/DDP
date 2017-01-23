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
                                            <button class="btn btn-xs btn-info"
                                                    @click="addObservaciones(preguntas.escrita, preguntas.numeral, preguntas.documental)">
                                                Añadir observaciones
                                            </button>
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
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div v-if="showObs.documental">
                        <el-upload
                                style="margin: 0 auto"
                                class="center center-block"
                                action="//jsonplaceholder.typicode.com/posts/"
                                type="drag"
                                :multiple="true"
                                :on-preview="handlePreview"
                                :on-remove="handleRemove"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :default-file-list="fileList">
                            <i class="el-icon-upload"></i>
                            <div class="el-dragger__text">Arrastre aqui o <em>haga click para subir archivos</em></div>
                            <div class="el-upload__tip" slot="tip">Considerar que sean menor a 500kb</div>
                        </el-upload>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div v-if="showObs.escrita">
                                <el-input
                                        type="textarea"
                                        :rows="2"
                                        placeholder="Please input"
                                >
                                </el-input>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div v-if="showObs.numeral">
                                <el-input-number size="large"></el-input-number>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="observacionDialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="observacionDialogVisible = false">Confirm</el-button>
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
                fileList: [],

                final: [],

                active: 1,
                radio: '',


                showObs: {
                    numeral: false,
                    escrita: false,
                    documental: false

                },
                observacionDialogVisible: false
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
            addObservaciones(escrita, numeral, documental){
                console.log(escrita);
                console.log(numeral);
                console.log(documental);

                this.showObs.escrita = escrita == 1;
                this.showObs.numeral = numeral == 1;
                this.showObs.documental = documental == 1;
                this.observacionDialogVisible = true;
            },


            next() {
                if (this.active++ > 2) this.active = 0;
            },
            crearRespuesta(res){
                console.log(res);
            },

            handleSuccess(file){
                console.log(file)
            },
            handleError(file){
                console.log(file)
            },

        },

        components: {}
    }
</script>
