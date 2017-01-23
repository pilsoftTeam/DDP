<template>
    <div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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

            </div>
        </div>


        <el-dialog title="Editar usuario" v-model="editDialogVisible" size="small">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <el-form :model="editUsers" :rules="rules" ref="editForm" label-width="120px">
                        <el-form-item label="Nombre completo" prop="nombre">
                            <el-input type="text" v-model="editUsers.nombre"></el-input>
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
                            <el-button class="pull-right" type="primary" @click="editarUsuario('editForm')">
                                Guardar cambios
                            </el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </el-dialog>


        <el-dialog title="Agregar Usuario" v-model="addDialogVisible" size="small">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <el-form label-position="left" label-width="100px" ref="crearUser" :model="crearUser"
                             :rules="rules">
                        <el-form-item label="Nombre completo" prop="nombre">
                            <el-input v-model="crearUser.nombre"></el-input>
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
            </div>
        </el-dialog>


        <el-dialog title="Eliminar usuario" v-model="deleteDialogVisible" size="tiny">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3 class="text-center text-danger">¿ Esta seguro que desea eliminar a este usuario ?</h3>

                </div>
            </div>


            <span slot="footer" class="dialog-footer">
                        <el-button @click="deleteDialogVisible = false">Cancelar</el-button>
                        <el-button type="danger" @click="eliminarUsuario">Eliminar</el-button>
                      </span>

        </el-dialog>

        <div class="btn-group">
            <button type="button" class="btn btn-success fixedbutton" @click="addDialogVisible = true">
                Agregar un usuario
            </button>
        </div>
    </div>
</template>
<style scoped>
    .fixedbutton {
        position: fixed;
        bottom: 5px;
        right: 5px;
    }
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
                    nombre: '',
                    email: '',
                    rol: ''
                },
                editUsers: {
                    id: '',
                    nombre: '',
                    email: '',
                    rol: ''
                },
                deleteUser: {
                    id: ''
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
                    rol: [
                        {
                            required: true,
                            message: 'Por favor seleccione un rol para este usuario',
                            trigger: 'change',
                            type: 'integer'
                        }
                    ],
                },
                addDialogVisible: false,
                editDialogVisible: false,
                deleteDialogVisible: false
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

            editarUsuario(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let user = this.editUsers;
                        this.$http.post('/api/editar/usuario', user).then((response) => {
                            this.crearUser.nombre = '';
                            this.crearUser.email = '';
                            this.crearUser.rol = '';
                            this.editDialogVisible = false;
                            this.success();
                            this.init();
                        }, (response) => {
                            this.error(response.data);
                        });
                    } else {
                        return false;
                    }
                })
            },

            crearUsuario(formName){

                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let user = this.crearUser;
                        this.$http.post('/api/crear/usuario', user).then((response) => {
                            this.crearUser.nombre = '';
                            this.crearUser.email = '';
                            this.crearUser.rol = '';
                            this.addDialogVisible = false;
                            this.userCreationSuccess(response.data);
                            this.init();
                        }, (response) => {
                            this.userCreationError(response.data);
                        });
                    } else {
                        return false;
                    }
                })

            },

            eliminarUsuario(){
                let user = {
                    id: this.deleteUser.id
                };

                this.$http.post('/api/borrar/usuario', user).then((response) => {
                    this.init();
                    this.deleteDialogVisible = false;
                    this.success();
                    console.log(response.data)
                }, (response) => {
                    this.error(response.status)
                })


            },

            handleEdit(row){
                this.editUsers.id = row.id;
                this.editUsers.nombre = row.name;
                this.editUsers.email = row.email;
                this.editUsers.rol = row.get_perfil.idPerfil;
                this.editDialogVisible = true
            },
            handleDelete(row){
                this.deleteUser.id = row.id;
                this.deleteDialogVisible = true
            },
            userCreationSuccess(pass){
                this.$notify.success({
                    title: 'Exito',
                    message: 'La accion se ha completado con exito. La contraseña de este usuario es : ' + pass + '. Guardela y entregela a quien corresponda.',
                    duration: 0
                });
            },
            userCreationError(error){
                this.$notify.error({
                    title: 'Error',
                    message: 'Error : ' + error.email,
                    duration: 0
                });
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
