<template>
    <div>


        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h3>Agregar un nuevo usuario</h3>
                <el-form label-position="left" label-width="100px" ref="crearUser" :model="crearUser" :rules="rules">
                    <el-form-item label="Nombre completo" prop="nombre">
                        <el-input v-model="crearUser.name"></el-input>
                    </el-form-item>
                    <el-form-item label="Email" prop="email">
                        <el-input v-model="crearUser.email"></el-input>
                    </el-form-item>
                    <el-form-item label="Rol" prop="rol">
                        <el-select placeholder="Seleccione" v-model="crearUser.rol">
                            <el-option
                                    v-for="rol in roles"
                                    :label="rol.perfil"
                                    :value="rol.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button class="pull-right" type="primary" @click="crearUsuario('crearUser')">
                            Agregar
                        </el-button>
                    </el-form-item>
                </el-form>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>

        </div>


        <hr>
        <h3>Lista de usuarios</h3>

        <el-table
                :data="users"
                border
                style="width: 100%">
            <el-table-column
                    prop="id"
                    label="#"
                    width="50">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="Nombre completo">
            </el-table-column>
            <el-table-column
                    prop="email"
                    label="Direccion email">
            </el-table-column>
            <el-table-column
                    prop="get_perfil.get_nombre_perfil.perfil"
                    label="Tipo de usuario">
            </el-table-column>
            <el-table-column
                    :context="_self"
                    label="Acciones">
                <template scope="scope">
                    <el-button
                            size="small"
                            type="warning"
                            @click="handleEdit(scope.row)">Editar usuario
                    </el-button>
                    <el-button
                            size="small"
                            type="danger"
                            @click="handleDelete(scope.row)">Borrar usuario
                    </el-button>
                </template>
            </el-table-column>
        </el-table>


        <el-dialog title="Editar usuario" v-model="editDialogVisible" size="small">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <el-form :model="editUsers" :rules="rules" ref="editForm" label-width="120px">
                        <el-form-item label="Nombre completo" prop="nombre">
                            <el-input type="text" v-model="editUsers.name"></el-input>
                        </el-form-item>
                        <el-form-item label="Email" prop="email">
                            <el-input type="text" v-model="editUsers.email"></el-input>
                        </el-form-item>
                        <el-form-item label="Rol" prop="rol">
                            <el-select placeholder="Seleccione" v-model="editUsers.rol">
                                <el-option
                                        v-for="rol in roles"
                                        :label="rol.perfil"
                                        :value="rol.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-button class="pull-right" type="primary" @click="submitEditarForm('editForm')">
                                Guardar cambios
                            </el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </el-dialog>

    </div>
</template>
<style>

</style>
<script>

    export default{
        mounted(){
            this.init();
            this.getRoles();
        },
        data(){
            return {
                users: [],
                roles: [],
                crearUser: {
                    name: '',
                    email: '',
                    rol: ''
                },
                editUsers: {
                    id: '',
                    name: '',
                    email: '',
                    rol: ''
                },
                rules: {
                    nombre: [
                        {required: true, message: 'Por favor escriba algo', trigger: 'blur'},
                        {
                            min: 1,
                            max: 500,
                            message: 'Min. de caracteres : 1. MAx. de caracteres 500',
                            trigger: 'blur'
                        }
                    ],
                    email: [
                        {required: true, message: 'Por favor escriba algo', trigger: 'blur'},
                        {
                            min: 1,
                            max: 500,
                            message: 'Min. de caracteres : 1. MAx. de caracteres 500',
                            trigger: 'blur'
                        }
                    ],
                },
                editDialogVisible: false
            }
        },
        methods: {

            init(){
                this.$http.get('/api/obtener/usuarios').then((response) => {
                    this.users = response.data
                }, (response) => {
                    this.error(response.status);
                })
            },
            getRoles(){
                this.$http.get('/api/obtener/roles/').then((response) => {
                    this.roles = response.data
                }, (response) => {

                })
            },

            crearUsuario(formName){

                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let user = this.crearUser;
                        this.$http.post('/crear/usuario/', user).then((response) => {
                            this.success();
                            this.initLoad();
                        }, (response) => {
                            this.error(response);
                        });
                    } else {
                        return false;
                    }
                })

            },

            handleEdit(row){
                this.editUsers.id = row.id;
                this.editUsers.name = row.name;
                this.editUsers.email = row.email;
                this.editUsers.rol = row.get_perfil.idPerfil;
                this.editDialogVisible = true
            },

            success(){
                this.$notify.success({
                    title: 'Exito',
                    message: 'La accion se ha completado con exito'
                });
            },
            error(error){
                this.$notify.error({
                    title: 'Error',
                    message: 'Un error ha ocurrido. Error :' + error
                })
            }

        },
        components: {}
    }
</script>
