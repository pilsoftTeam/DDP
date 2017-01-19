<template>
    <div>

        <el-form url=" " :model="dimension" class="" :rules="rules" ref="dimension" method="POST">
            <el-form-item label="Nombre de la dimension" prop="nombreDimension">
                <el-input v-model="dimension.nombreDimension"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="submit('dimension')" class="pull-right">Agregar
                </el-button>
            </el-form-item>
        </el-form>

    </div>
</template>
<style>

</style>
<script>
    import axios from 'axios';
    export default{
        data(){
            return {
                msg: 'hello vue',
                dimension: {
                    nombreDimension: '',
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
                }

            }
        },

        methods: {
            submit(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        let data = this.dimension;

                        //axios.post("/api/crear/dimension", data).then((response) => {
                        //    this.success();
                        //    console.log(response.data);
                        //}).catch((response) => {
                        //    this.error(response)//;
                        //})


                        this.$http.post('/api/crear/dimension', data).then((response) => {
                            this.success();
                        }, (response) => {
                            console.log(response)
                        });


                    } else {

                        return false;
                    }
                });

            },

            error(errorDescription) {
                this.$notify.error({
                    title: 'Error',
                    message: 'Ha ocurrido un error. Por favor intentelo mas tarde. Error :' + errorDescription + ''
                });
            },

            success(){
                this.$notify.success({
                    title: 'Exito',
                    message: 'La accion ha sido completada de manera exitosa',
                });
            }
        },
        components: {}
    }
</script>
