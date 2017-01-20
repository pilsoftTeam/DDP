<template>
    <div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <el-menu class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose">

                    <h3 class="text-center">Dimensiones</h3>
                    <div v-for="(value, key, index) in data">
                        <el-submenu :index="(key + 1).toString()">
                            <template slot="title">{{value.dimension}}</template>
                            <el-submenu :index="(llave + 1).toString()"
                                        v-for="(names, llave, index) in value.get_requisitos">
                                <template slot="title">
                                    <p v-if="names.nombreRequisito.length > 1">
                                        {{names.nombreRequisito}}
                                    </p>
                                </template>
                            </el-submenu>
                        </el-submenu>
                    </div>
                </el-menu>
            </div>
        </div>

        <el-dialog title="Agregar una nueva dimension" v-model="dimensionDialogVisible" size="small">
            <el-form url=" " :model="dimension" class="" :rules="rules" ref="dimension" method="POST">
                <el-form-item label="Nombre de la dimension" prop="nombreDimension">
                    <el-input v-model="dimension.nombreDimension"></el-input>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="dimensionSubmit('dimension')" class="pull-right">Agregar
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>


        <el-dialog title="Agregar un nuevo requisito" v-model="requisitosDialogVisible" size="small">
            <el-form url=" " :model="requisitos" class="" :rules="rules" ref="requisitos" method="POST">
                <el-form-item label="Nombre del Requisito" prop="nombreRequisito">
                    <el-input v-model="requisitos.nombreRequisito"></el-input>
                </el-form-item>
                <el-form-item label="Dimension del requisito" prop="idDimension">
                    <el-select v-model="requisitos.idDimension" placeholder="Elija una" style="width: 100%">
                        <el-option
                                v-for="item in data"
                                :label="item.dimension"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>


                <el-form-item>
                    <el-button type="primary" @click="requisitoSubmit('requisitos')" class="pull-right">Agregar
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>


        <el-dialog title="Agregar una nueva pregunta" v-model="preguntasDialogVisible" size="large">
            <el-form url=" " :model="preguntas" class="" :rules="rules" ref="preguntas" method="POST">


                <el-form-item label="Nombre de la pregunta" prop="nombrePregunta">
                    <el-input v-model="pregunta.nombreRequisito"></el-input>
                </el-form-item>


                <el-form-item label="Nombre del requisito" prop="idDimension">
                    <el-select v-model="pregunta.idRequisito" placeholder="Elija una" style="width: 100%">
                        <el-option
                                v-for="item in data.get_requisitos"
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

                <el-form-item label="Observacion Numeral" prop="idDimension">
                    <el-switch on-text="SI" off-text="NO" v-model="pregunta.tipoObservacion.numeral"></el-switch>
                </el-form-item>

                <el-form-item label="Observacion escrita" prop="idDimension">
                    <el-switch on-text="SI" off-text="NO" v-model="pregunta.tipoObservacion.escrita"></el-switch>
                </el-form-item>

                <el-form-item label="Observacion documental" prop="idDimension">
                    <el-switch on-text="SI" off-text="NO" v-model="pregunta.tipoObservacion.documental"></el-switch>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="requisitoSubmit('requisitos')" class="pull-right">Agregar
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
    import createDimension from './modulos/createDimension.vue'
    import createRequisito from './modulos/createRequisito.vue'
    import createPregunta from './modulos/createPregunta.vue'
    export default{
        name: 'admin',
        mounted(){
            this.initLoad();
        },
        data(){
            return {
                data: '',
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
                    tipoObservacion: {
                        numeral: false,
                        escrita: false,
                        documental: false,
                    }
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
                    this.data = response.data;
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

    }

</script>
