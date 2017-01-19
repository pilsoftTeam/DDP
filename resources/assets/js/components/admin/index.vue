<template>
    <div>

        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <el-menu default-active="2" class="el-menu-vertical-demo" @open="handleOpen"
                         @close="handleClose">

                    <h3 class="text-center">Dimensiones</h3>
                    <el-submenu index="1">
                        <template slot="title"><i class="el-icon-message"></i>Navigator One
                        </template>
                        <el-menu-item-group title="Group One">
                            <el-menu-item index="1-1">item one</el-menu-item>
                            <el-menu-item index="1-2">item one</el-menu-item>
                        </el-menu-item-group>
                        <el-menu-item-group title="Group Two">
                            <el-menu-item index="1-3">item three</el-menu-item>
                        </el-menu-item-group>
                        <el-submenu index="1-4">
                            <template slot="title">item four</template>
                            <el-menu-item index="1-4-1">item one</el-menu-item>
                        </el-submenu>
                    </el-submenu>


                    <el-menu-item index="2"><i class="el-icon-menu"></i>Navigator Two</el-menu-item>
                    <el-menu-item index="3"><i class="el-icon-setting"></i>Navigator Three
                    </el-menu-item>
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

                }, (response) => {

                })
            },
            create(){

            },

            handleOpen(){
                console.log(this);
            },
            handleClose(){
                console.log(this);
            }
        },
        components: {
            'create-dimension': createDimension,
            'create-requisito': createRequisito,
            'create-pregunta': createPregunta,
        }
    }
</script>
