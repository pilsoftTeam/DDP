<template>
    <div>

        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <el-menu class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose">

                    <h3 class="text-center">Dimensiones</h3>
                    <div v-for="(value, key, index) in data">
                        <el-submenu :index="(key + 1).toString()">
                            <template slot="title">{{value.dimension}}</template>
                            <el-submenu :index="(llave + 1).toString()" v-for="(names, llave, index) in value.get_requisitos">
                                <template slot="title">
                                    <p v-if="names.Nombrerequisito.length > 1">
                                        {{names.Nombrerequisito}}
                                    </p>
                                </template>
                            </el-submenu>
                        </el-submenu>
                    </div>


                </el-menu>
            </div>


            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <transition name="fade">
                    <div v-if="crearDimension">
                        <create-dimension></create-dimension>
                    </div>
                </transition>
                <transition name="fade">
                    <div v-if="crearRequisito">
                        <create-requisito></create-requisito>
                    </div>
                </transition>
                <transition name="fade">
                    <div v-if="crearPregunta">
                        <create-pregunta></create-pregunta>
                    </div>
                </transition>


            </div>
        </div>
        <button @click="initLoad">init</button>

        <div class="btn-group" id="fixedbutton">
            <button type="button" class="btn btn-success" @click="crearDimension =! crearDimension">
                Dimension
            </button>
            <button type="button" class="btn btn-info" @click="crearRequisito =! crearRequisito">
                Requisito
            </button>
            <button type="button" class="btn btn-primary" @click="crearPregunta =! crearPregunta">
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
        data(){
            return {
                data: '',
                crearDimension: false,
                crearRequisito: false,
                crearPregunta: false,
            }
        },

        methods: {

            initLoad(){
                this.$http.get('/api/carga/inicial').then((response) => {
                    this.data = response.data;
                }, (response) => {
                    console.log(response)
                })
            },
            create(){

            },

            handleOpen(){

            },
            handleClose(){

            }
        },
        components: {
            'create-dimension': createDimension,
            'create-requisito': createRequisito,
            'create-pregunta': createPregunta,
        }
    }
</script>
