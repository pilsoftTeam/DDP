<template>
    <div>
        <div class="row">
            <div class="col-xs-18 col-sm-12 col-md-12 col-lg-12">
                <el-table
                        :data="data"
                        border
                        style="width: 100%">
                    <el-table-column
                            label="Comuna"
                            width="120">
                        <template scope="scope">
                            {{scope.row.comuna}}
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="Region">
                        <template scope="scope">
                            {{scope.row.region}}
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="Estado asignacion"
                            width="160">
                        <template scope="scope">
                            {{scope.row.estado}}
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="Revisor encargado">
                        <template scope="scope">
                            {{scope.row.nombreRealizador}}
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="Supervisor">
                        <template scope="scope">
                            {{scope.row.nombreSupervisor}}
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="errores"
                            width="300"
                            label="Estado del cuestionario"
                            :filters="[
                                {text: 'No efectuada', value: 'No listo' },
                                {text: 'Terminado y Cumplimiento 100%', value: 'Si cumple'},
                                {text: 'Terminado y con Incumplimientos', value: 'No cumple'},
                                ]"
                            :filter-method="filterTag">
                        <template scope="scope">

                            <div v-if="scope.row.errores === 'No listo'">
                                <h6 class="text-center">
                                    <icon name="question-circle" style="color:blue;"></icon>
                                </h6>
                                <h5 class="text-center">
                                    <small>La revision aun no se ha efectuado</small>
                                </h5>

                            </div>
                            <div v-else-if="scope.row.errores === 'No cumple'">
                                <h6 class="text-center">
                                    <icon name="exclamation-circle" style="color:red;"></icon>
                                </h6>
                                <h5 class="text-center">
                                    <small>La revision tiene preguntas que no cumplen!</small>
                                </h5>
                                <button class="btn btn-xs btn-info btn-block" @click="getInformativeDocs(scope.row.id)">
                                    Descargar informativo
                                </button>
                            </div>
                            <div v-else>
                                <h6 class="text-center">
                                    <icon name="check-circle" style="color:lawngreen;"></icon>
                                </h6>
                                <h5 class="text-center">
                                    <small>La revision esta completa y se cumplen todas las <br/> observaciones</small>
                                </h5>

                                <button class="btn btn-xs btn-info btn-block" @click="getInformativeDocs(scope.row.id)">
                                    Descargar informativo
                                </button>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>

    </div>
</template>
<style>
    .example {
        color: red;
    }
</style>
<script>
    import Icon from 'vue-awesome/components/Icon.vue'
    import 'vue-awesome/icons'
    import downloader from './../../common/downloader'
    export default {


        mounted(){
            this.init();
        },
        data () {
            return {
                data: [],
                batchDownload: [],
            }
        },
        methods: {
            init(){
                let self = this;
                this.$http.get('api/reportes/all').then((response) => {
                    _.forEach(response.data, (r) => {
                        let obj = {
                            id: '',
                            comuna: '',
                            region: '',
                            estado: '',
                            nombreRealizador: '',
                            nombreSupervisor: '',
                            errores: '',
                        };

                        obj.comuna = r.get_comuna.nombreComuna;
                        obj.region = r.get_comuna.get_region.nombreRegion;
                        obj.estado = r.get_reportes_asignaciones.length == 0 ? obj.estado = 'Pendiente' : r.get_reportes_asignaciones[0].estado;
                        obj.id = r.get_reportes_asignaciones.length == 0 ? obj.id = null : r.get_reportes_asignaciones[0].id;
                        obj.nombreRealizador = r.get_reportes_asignaciones.length == 0 ? obj.nombreRealizador = 'No asignado' : r.get_reportes_asignaciones[0].get_realizador.name;
                        obj.nombreSupervisor = r.get_reportes_asignaciones.length == 0 ? obj.nombreSupervisor = 'No asignado' : r.get_reportes_asignaciones[0].get_creador.name;
                        if (r.get_reportes_asignaciones.length == 0) {
                            obj.errores = 'No listo'
                        } else if (r.get_reportes_asignaciones.length > 0 && r.get_reportes_asignaciones[0].get_cuestionario_realizado.length == 0) {
                            obj.errores = 'No listo'
                        } else if (r.get_reportes_asignaciones.length > 0 && r.get_reportes_asignaciones[0].get_cuestionario_realizado.length > 0) {
                            _.each(r.get_reportes_asignaciones[0].get_cuestionario_realizado, (e) => {
                                if (e.cumplimiento == 0) {
                                    obj.errores = 'No cumple';
                                    return false;
                                } else {
                                    obj.errores = 'Si cumple';
                                }
                            })
                        }
                        this.data.push(obj);
                    })
                }, (response) => {
                    console.log(response.status)
                })
            },
            getInformativeDocs(id){
                let date = new Date();
                this.$http.post('api/reportes/docs/' + id + '').then((response) => {
                    let filename = JSON.parse(response.headers.get('Content-Disposition').split('=').pop());
                    downloader(response.data, filename, 'application/octet-stream');
                }, (response) => {
                    console.log(response.status)
                })
            },
            filterTag(value, row) {
                let self = this;
                if (row.errores === value) {
                    self.batchDownload.push(row.id);
                }
                return row.errores === value;
            }
        },
        components: {
            'icon': Icon
        }
    }
</script>
