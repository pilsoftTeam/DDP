<template>
    <div>
        <div class="row">
            <div class="col-xs-18 col-sm-4 col-md-4 col-lg-4">

                <el-menu class="el-menu-vertical-demo">
                    <h3 class="text-center"><b>Dimensiones</b></h3>
                    <hr>
                    <div v-for="dimensiones in data">
                        <div @click="getDimension(dimensiones.id)">
                            <el-submenu :index="(dimensiones.ordenDimension).toString()">
                                <template slot="title">{{dimensiones.dimension | truncate }}</template>
                                <h4 class="text-center"><b>Requisitos</b></h4>
                                <hr>
                                <div v-for="requisitos in dimensiones.get_requisitos">
                                    <el-menu-item :index="(requisitos.ordenRequisito).toString()">
                                        <p @click="getPreguntas(requisitos.id)">{{requisitos.nombreRequisito |
                                            truncate}}</p>
                                    </el-menu-item>
                                </div>
                            </el-submenu>
                        </div>
                    </div>
                </el-menu>
            </div>
            <br>
            <div class="col-xs-18 col-sm-8 col-md-8 col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div v-if="showDimension">
                            <h4 class="text-center text-success text-capitalize text-lead">
                                {{dataDimensiones.dimension}}
                            </h4>
                            <br>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <h5 class="text-center pull-right">Numero de requisitos :
                                        <b>{{dataDimensiones.get_requisitos.length}}</b>
                                    </h5>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <h5 class="text-center">Orden de dimension :
                                        <b>{{dataDimensiones.ordenDimension}}</b>
                                    </h5>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <h5 class="text-center pull-left">Estado dimension :
                                        <b>{{dataDimensiones.estado == 0 ? 'Desactivado' : 'Activado'}}</b>
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="text-center text-info">Opciones</h4>
                                <br>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                     style="border-right: solid 1px #EEF1F6">
                                    <div style="display: inline">
                                        <p class="text-center">Cambiar estado de dimension : <span>
                                            <el-switch
                                                    :width="Number(120)"
                                                    v-model="editarDimension.estado"
                                                    on-text="Activado"
                                                    off-text="Desactivado"
                                                    on-color="#2AB27B"
                                                    off-color="#E2E2E2"></el-switch>
                                        </span></p>

                                    </div>


                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                                </div>

                            </div>
                            <hr>

                            <div class="row">
                                <h4 class="text-center text-info">Informacion relevante</h4>
                                <br>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr class="text-center">
                                                <th class="text-center">Nombre Requisito</th>
                                                <th class="text-center">N° Preguntas</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Opciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="data in dataDimensiones.get_requisitos" class="text-center">
                                                <td>{{data.nombreRequisito}}</td>
                                                <td>{{data.get_preguntas.length}}</td>
                                                <td>{{data.estado == 0 ? 'Desactivado' : 'Activado'}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning btn-xs">Editar
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs">Eliminar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div v-if="showPreguntas">
                            <p v-if="dataPreguntas.dimension"><b>Dimension</b> : {{dataPreguntas.dimension}}</p>
                            <p v-if="dataPreguntas.requisito"><b>Requisito</b> : {{dataPreguntas.requisito}}</p>
                            <hr>
                            <draggable :move="onMoveCallback" :list="list" :options="options" @start="drag=true"
                                       @end="onMoveCallback">
                                <div v-for="pregunta in dataPreguntas.data">
                                    <div class="alert alert-info" role="alert">
                                        <h5 class="text-justify" :data="pregunta.ordenPreguntas">
                                            {{pregunta.pregunta}}</h5>

                                        <small class="text-warning">Técnica de Auditoria :
                                            {{pregunta.tecnicaAuditoria}}
                                        </small>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <div class="row">
                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
                                                         v-if="pregunta.numeral === 1">
                                                        <div title="Esta pregunta tiene una observacion numeral (Cantidad)">
                                                            <icon name="calculator"></icon>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
                                                         v-if="pregunta.escrita === 1">
                                                        <div title="Esta pregunta tiene una observacion escrita">
                                                            <icon name="font"></icon>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
                                                         v-if="pregunta.documental === 1">
                                                        <div title="Esta pregunta tiene una observacion documental">
                                                            <icon name="file-text-o"></icon>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-xs btn-warning"
                                                            @click="editarPregunta(pregunta.id)">Editar
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-danger"
                                                            @click="eliminarPregunta(pregunta.id)">Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </draggable>
                        </div>


                    </div>
                </div>
            </div>

        </div>


        <div>
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
                    <el-form-item label="Técnica de Auditoría" prop="tecnicaAuditoria">
                        <el-select v-model="pregunta.tecnicaAuditoria" placeholder="Elija una"
                                   style="width: 100%">
                            <el-option
                                    v-for="item in tecnicasAuditoria"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-alert
                            title="Informacion"
                            type="info"
                            description="Al elegir una de estas opciones usted otorgara a la pregunta una revision. Elija cuidadosamente"
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
    import draggable from 'vuedraggable'
    import Icon from 'vue-awesome/components/Icon.vue'
    import _ from 'lodash'


    import 'vue-awesome/icons'
    export default{
        mounted(){
            this.initLoad();
        },
        data(){
            return {
                data: '',
                dataDimensiones: '',
                dataRequisitos: '',
                dataPreguntas: {
                    data: '',
                    dimension: '',
                    requisito: ''
                },
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
                    tecnicaAuditoria: '',
                    numeral: false,
                    escrita: false,
                    documental: false,

                },

                tecnicasAuditoria: [{
                    value: 'Observación',
                    label: 'Observación'
                }, {
                    value: 'Observación, Revisión Oferta',
                    label: 'Observación, Revisión Oferta'
                }, {
                    value: 'Inspección física (hardware y software) equipamiento computacionales, Catastro de Licencias de Software. Facturas de Compra',
                    label: 'Inspección física (hardware y software) equipamiento computacionales, Catastro de Licencias de Software. Facturas de Compra'
                }, {
                    value: 'Medición de la velocidad de trasferencia de datos, Observación. Contrato ISP',
                    label: 'Medición de la velocidad de trasferencia de datos, Observación. Contrato ISP'
                }, {
                    value: 'Observación, Inspección y reproceso. Entrevista a usuarios',
                    label: 'Observación, Inspección y reproceso. Entrevista a usuarios'
                }, {
                    value: 'Observación, Inspección y reproceso. Revisión sistemas informáticos',
                    label: 'Observación, Inspección y reproceso. Revisión sistemas informáticos'
                }],


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
                    ],
                    tecnicaAuditoria: [
                        {
                            required: true,
                            message: 'Por favor seleccione una tecnica de auditoria',
                            trigger: 'change'
                        }
                    ]


                },

                editarDimension: {
                    estado: false
                },


                dimensionDialogVisible: false,
                requisitosDialogVisible: false,
                preguntasDialogVisible: false,
                showDocumentalHeader: false,
                showDimension: false,
                showPreguntas: false,
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

                            console.log(response.data);

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
            editarDimension (){

            },
            eliminarDimension(){

            },
            editarPregunta(id){
                alert(id);
            },
            eliminarPregunta(id){
                alert('Va a eliminar a : ' + id + '. Esta seguro');
            },
            create(){

            },
            handleOpen(){

            },
            handleClose(){

            },


            onMoveCallback(evt){
                return false;
            },


            getDimension(id){
                this.showPreguntas = false;
                this.showDimension = true;
                this.dataDimensiones = _.find(this.data, obj => {
                    return obj.id === id
                });


            },


            getPreguntas(id){


                this.$http.get('/api/obtener/preguntas/' + id + '').then((response) => {
                    let data = response.data;
                    let self = this;
                    this.dataPreguntas.data = data;
                    Object.keys(data).forEach(function (item) {
                        self.dataPreguntas.requisito = data[item].obtener_requisitos.nombreRequisito;
                        self.dataPreguntas.dimension = data[item].obtener_requisitos.obtener_dimensiones.dimension;
                    });
                    this.showDimension = false;
                    this.showPreguntas = true;
                }, (response) => {
                    this.error(response.status);
                })
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
                    message: 'Un error ha ocurrido. Error :' + error
                });
            }
        },

        computed: {},


        filters: {
            truncate: function (value) {
                return value.substring(0, 30) + '...';
            }

        },

        components: {
            'draggable': draggable,
            'icon': Icon
        }


    }

</script>
