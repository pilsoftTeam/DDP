<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <transition name="custom" enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOut">
                        <div class="row" v-if="init">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Informacion</h3>
                                    </div>
                                    <div class="panel-body">
                                        Informacion importante antes de empezar
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                <div class="well">
                                    <h3>Datos requeridos</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <el-form :model="datos" ref="datos" label-width="170px" :rules="rules">
                                                <el-form-item label="Datos antes de iniciar" prop="datos">
                                                    <el-input v-model="datos.datos"></el-input>
                                                </el-form-item>
                                                <el-form-item>
                                                    <el-button type="success" class="pull-right"
                                                               @click="iniciarCuestionario('datos')">
                                                        Iniciar
                                                    </el-button>
                                                </el-form-item>
                                            </el-form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>

                    <transition name="custom" enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div class="row" v-if="start">
                            <cuestionario :data="datos"></cuestionario>
                        </div>
                    </transition>
                </div>
            </div>


        </div>

    </div>
</template>
<style>

</style>

<script>
    import cuestionario from './revisor/index.vue'
    export default {
        data() {
            return {

                datos: {
                    datos: ''
                },

                rules: {
                    datos: [
                        {required: true, message: 'Por favor escriba algo', trigger: 'blur'},
                    ]
                },

                init: true,
                start: false
            }
        },

        methods: {
            iniciarCuestionario(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.init = false;
                        setTimeout(() => {
                            this.start = true;
                        }, 1000)

                    } else {
                        return false;
                    }
                })
            }
        },
        components: {
            'cuestionario': cuestionario
        }
    }
</script>
