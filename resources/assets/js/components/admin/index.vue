<template>
    <div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">


                <el-menu class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose">
                    <h3 class="text-center"><b>Dimensiones</b></h3>
                    <hr>
                    <div v-for="dimensiones in data">
                        <el-submenu :index="(dimensiones.ordenDimension).toString()">
                            <template slot="title">{{dimensiones.dimension | truncate }}</template>
                            <h4 class="text-center"><b>Requisitos</b></h4>
                            <hr>
                            <div v-for="requisitos in dimensiones.get_requisitos">
                                <el-submenu
                                        :index="(((dimensiones.ordenDimension).toString())-((requisitos.ordenRequisito).toString())).toString()">
                                    <template slot="title">{{requisitos.nombreRequisito | truncate}}</template>
                                    <h5 class="text-center"><b>Preguntas</b></h5>
                                    <hr>
                                    <div v-for="preguntas in requisitos.get_preguntas">

                                        <el-menu-item
                                                :index="(((dimensiones.ordenDimension).toString())-((requisitos.ordenRequisito).toString())-((preguntas.ordenPreguntas).toString())).toString()">
                                            {{preguntas.pregunta | truncate}}
                                        </el-menu-item>
                                    </div>

                                </el-submenu>
                            </div>


                        </el-submenu>
                    </div>


                </el-menu>
                <!--
                 <div v-for="dimensiones in data">
                    <h1 style="color : purple">{{dimensiones.dimension}}</h1>


                    <ul v-for="requisitos in dimensiones.get_requisitos">
                        <li style="color : red">
                            {{requisitos.nombreRequisito}}
                        </li>

                        <ul v-for="preguntas in requisitos.get_preguntas">
                            <li style="color : green">
                                {{preguntas.pregunta}}
                            </li>
                        </ul>

                    </ul>

                </div>
                -->


            </div>
        </div>

        <el-dialog title="Agregar una nueva dimension" v-model="dimensionDialogVisible"
                   size="small">
            <el-form :model="dimension" class="" :rules="rules" ref="dimension">
                <el-form-item label="Nombre de la dimension" prop="nombreDimension">
                    <el-input v-model="dimension.nombreDimension"></el-input>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="dimensionSubmit('dimension')"
                               class="pull-right">Agregar
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>


        <el-dialog title="Agregar un nuevo requisito" v-model="requisitosDialogVisible"
                   size="small">
            <el-form :model="requisitos" class="" :rules="rules" ref="requisitos">
                <el-form-item label="Nombre del Requisito" prop="nombreRequisito">
                    <el-input v-model="requisitos.nombreRequisito"></el-input>
                </el-form-item>
                <el-form-item label="Dimension del requisito" prop="idDimension">
                    <el-select v-model="requisitos.idDimension" placeholder="Elija una"
                               style="width: 100%">
                        <el-option
                                v-for="item in data"
                                :label="item.dimension"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>


                <el-form-item>
                    <el-button type="primary" @click="requisitoSubmit('requisitos')"
                               class="pull-right">Agregar
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>


        <el-dialog title="Agregar una nueva pregunta" v-model="preguntasDialogVisible" size="large">
            <el-form :model="pregunta" class="" :rules="rules" ref="preguntas">


                <el-form-item label="Nombre de la pregunta" prop="pregunta">
                    <el-input v-model="pregunta.pregunta"></el-input>
                </el-form-item>


                <el-form-item label="Nombre del requisito" prop="idRequisito">
                    <el-select v-model="pregunta.idRequisito" placeholder="Elija una"
                               style="width: 100%">
                        <el-option
                                v-for="item in dataRequisitos"
                                :label="item.nombreRequisito"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-alert
                        title="Informacion"
                        type="info"
                        description="Al elejir una de estas opciones usted otorgara a la pregunta una revision. Elija cuidadosamente"
                        show-icon
                        @close="showDocumentalHeader = true">
                </el-alert>
                <div v-if="showDocumentalHeader">
                    <hr>
                    <h5>
                        <b>Tipos de observacion a agregar</b>
                    </h5>
                </div>

                <br>

                <el-form-item label="Observacion Numeral">
                    <el-switch on-text="SI" off-text="NO"
                               v-model="pregunta.numeral"></el-switch>
                </el-form-item>

                <el-form-item label="Observacion Escrita">
                    <el-switch on-text="SI" off-text="NO"
                               v-model="pregunta.escrita"></el-switch>
                </el-form-item>

                <el-form-item label="Observacion Documental">
                    <el-switch on-text="SI" off-text="NO"
                               v-model="pregunta.documental"></el-switch>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="preguntaSubmit('preguntas')"
                               class="pull-right">Agregar
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>


        <div class="btn-group" id="fixedbutton">
            <button type="button" class="btn btn-success" @click="dimensionDialogVisible = true">
                Dimension
            </button>
            <button type="button" class="btn btn-info" @click="requisitosDialogVisible = true">
                Requisito
            </button>
            <button type="button" class="btn btn-primary" @click="preguntasDialogVisible = true">
                Pregunta
            </button>
        </div>


    </div>
</template>

<style>
    #fixedbutton {
        position: fixed;
        bottom: 5px;
        right: 5px;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */
    {
        opacity: 0
    }
</style>
<script>


    export default{
        name: 'admin',
        mounted(){
            this.initLoad();
        },
        data(){
            return {
                data: [],
                dimensionTree: [],
                defaultProps: {
                    dimension: 'dimension',
                    id: 'id'
                },

                dataRequisitos: '',
                dimension: {
                    nombreDimension: ''
                },
                requisitos: {
                    idDimension: '',
                    nombreRequisito: ''
                },
                pregunta: {
                    pregunta: '',
                    idRequisito: '',
                    numeral: false,
                    escrita: false,
                    documental: false,

                },
                rules: {
                    nombreDimension: [
                        {required: true, message: 'Por favor escriba algo', trigger: 'blur'},
                        {
                            min: 10,
                            max: 500,
                            message: 'Min. de caracteres : 10. MAx. de caracteres 500',
                            trigger: 'blur'
                        }
                    ],
                    nombreRequisito: [
                        {required: true, message: 'Por favor escriba algo', trigger: 'blur'},
                        {
                            min: 10,
                            max: 500,
                            message: 'Min. de caracteres : 10. MAx. de caracteres 500',
                            trigger: 'blur'
                        }
                    ],
                    idDimension: [
                        {
                            required: true,
                            message: 'Por favor seleccione una dimension',
                            trigger: 'change',
                            type: 'integer'
                        }
                    ],
                    pregunta: [
                        {required: true, message: 'Por favor escriba algo', trigger: 'blur'},
                        {
                            min: 10,
                            max: 500,
                            message: 'Min. de caracteres : 10. MAx. de caracteres 500',
                            trigger: 'blur'
                        }
                    ],
                    idRequisito: [
                        {
                            required: true,
                            message: 'Por favor seleccione un requisito',
                            trigger: 'change',
                            type: 'integer'
                        }
                    ]


                },
                dimensionDialogVisible: false,
                requisitosDialogVisible: false,
                preguntasDialogVisible: false,
                showDocumentalHeader: false
            }
        },

        methods: {

            initLoad(){
                this.$http.get('/api/carga/inicial').then((response) => {
                    let data = response.data;
                    this.data = data;

                    let arr = [];
                    Object.keys(data).forEach((item) => {
                        data[item].get_requisitos.forEach((item, index) => {
                            arr.push(item);
                        })
                    });
                    this.dataRequisitos = arr;
                }, (response) => {

                })
            },


            dimensionSubmit(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.dimension;
                        this.$http.post('/api/crear/dimension', data).then((response) => {
                            this.success();
                            this.dimension.nombreDimension = '';
                            this.dimensionDialogVisible = false;
                            this.initLoad();
                        }, (response) => {
                            this.error(response);
                        });
                    } else {
                        return false;
                    }
                })
            },


            requisitoSubmit(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.requisitos;
                        this.$http.post('/api/crear/requisito', data).then((response) => {
                            this.success();
                            this.requisitos.idDimension = '';
                            this.requisitos.nombreRequisito = '';
                            this.requisitosDialogVisible = false;
                            this.initLoad();
                        }, (response) => {
                            this.error(response);
                        });
                    } else {
                        return false;
                    }
                })
            },
            preguntaSubmit(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.pregunta;
                        this.$http.post('/api/crear/pregunta', data).then((response) => {

                            console.log(response.data)

                            this.pregunta.pregunta = '';
                            this.pregunta.idRequisito = '';
                            this.pregunta.escrita = false;
                            this.pregunta.numeral = false;
                            this.pregunta.documental = false;
                            this.preguntasDialogVisible = false;
                            this.initLoad();
                            this.success();
                        }, (response) => {
                            this.error(response);
                        });
                    } else {
                        return false;
                    }
                })
            },
            create(){

            },

            handleOpen(){

            },
            handleClose(){

            },

            success(){
                this.$notify.success({
                    title: 'Exito',
                    message: 'La operacion se ha completado con exito'
                });
            },
            error(error){
                this.$notify.error({
                    title: 'Error',
                    message: 'Ha ocurrido un error :' + error
                });
            },


        },

        filters: {
            truncate: function (value) {
                return value.substring(0, 30) + '...';
            }
        }


    }

</script>
