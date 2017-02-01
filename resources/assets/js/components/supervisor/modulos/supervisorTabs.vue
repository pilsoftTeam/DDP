<template>
    <div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <el-tabs type="border-card">
                        <el-tab-pane>
                            <span slot="label">
                                <icon name="address-book"></icon>
                                &nbsp;Asignar
                            </span>
                            <asignarTareasRevisor></asignarTareasRevisor>
                        </el-tab-pane>
                        <el-tab-pane label="Config">
                            <span slot="label">
                                <icon name="address-book-o"></icon>
                                &nbsp;Calidad
                            </span>
                            <estadoAsignaciones></estadoAsignaciones>
                        </el-tab-pane>

                        <el-tab-pane>
                            <span slot="label"> <icon name="file-o"></icon>
                                Reportes
                            </span>
                            <reportes></reportes>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </div>
        </div>

    </div>
</template>
<style>

</style>
<script>
    import Icon from 'vue-awesome/components/Icon.vue'
    import asignarTareas from './asignarTareaRevisor.vue'
    import verEstadoAsignaciones from './verEstadoAsignaciones.vue'
    import reportes from './reportes.vue'

    import 'vue-awesome/icons/'
    export default{
        data(){
            return {}
        },
        components: {
            'icon': Icon,
            'asignarTareasRevisor': asignarTareas,
            'estadoAsignaciones': verEstadoAsignaciones,
            'reportes': reportes
        }
    }
</script>
