<template>
    <div>
        <div class="container">
            <el-tabs type="border-card" @tab-click="openEvent">
                <el-tab-pane>
                    <span slot="label"> <icon name="list-alt"></icon>&nbsp; Cuestionarios</span>
                    <div v-if="showCuestionarios">
                        <cuestionario></cuestionario>
                    </div>
                </el-tab-pane>
                <el-tab-pane>
                    <span slot="label"> <icon name="users"></icon> &nbsp;Usuarios</span>
                    <div v-if="showUsuarios">
                        <usuarios></usuarios>
                    </div>
                </el-tab-pane>
            </el-tabs>

        </div>

    </div>

</template>
<style>
    .el-tabs__content {
        min-height: 85vh;
        max-height: 100%;
    }
</style>

<script>
    import cuestionario from './modulos/moduloCuestionario.vue'
    import usuarios from './modulos/moduloUsuarios.vue'
    import Icon from 'vue-awesome/components/Icon.vue'
    import 'vue-awesome/icons'
    export default {
        mounted(){

        },
        data() {
            return {
                showCuestionarios: true,
                showUsuarios: false
            }
        },

        methods: {

            openEvent(e){
                if (e.index == 0) {
                    this.showCuestionarios = true
                } else if (e.index == 1) {
                    this.showUsuarios = true
                }
            }
        },
        components: {
            'cuestionario': cuestionario,
            'usuarios': usuarios,
            'icon': Icon
        }

    }
</script>