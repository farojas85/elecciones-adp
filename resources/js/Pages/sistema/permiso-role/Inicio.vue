<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Permiso/Roles&nbsp;
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="card border border-primary">
                        <div class="card-header tx-medium bd-0 tx-white bg-primary">
                            Roles
                        </div>
                        <div class="card-body ">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-form-label-sm col-md-3">Rol</label>
                                <div class="col-md-9">
                                    <select class="form-control form-control-sm"
                                        v-model="role_permisos.role_id"
                                        :class="{ 'is-invalid' : errors.role_id}">
                                        <option value="" :class="role_permisos.role_id == '' ? 'd-block' : 'd-none'">-Seleccionar-</option>
                                        <option  v-for="rol in roles" :key="rol.id"
                                            :value="rol.id" :title="rol.nombre">
                                            {{ rol.nombre}}
                                        </option>
                                    </select>
                                    <small class="text-danger" v-for="error in errors.role_id"
                                    :key="error">{{error }}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-form-label col-form-label-sm col-md-3">Modelo</label>
                                <div class="col-md-9">
                                    <select class="form-control form-control-sm" v-model="role_permisos.modelo">
                                        <option value="">-Seleccionar-</option>
                                        <option  v-for="modelo in modelos" :key="modelo.nombre"
                                            :value="modelo.nombre" :title="modelo.nombre">
                                            {{ modelo.nombre }}
                                        </option>
                                    </select>
                                    <br />
			                        <button class="btn btn-success btn-block" @click="mostrarRolePermisos" :disabled="role_permisos.modelo==''">Generar <i class="fas fa-arrow-alt-circle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <permiso-role-form :role="role" :role_permisos="role_permisos" :permisos="permisos"></permiso-role-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { onMounted, ref } from 'vue'
    import useRol from '@/Composables/sistema/roles'
    import usePermisoRole from '@/Composables/sistema/permiso-role'
    import PermisoRoleForm from './Form.vue'

    export default {
        components:{
            PermisoRoleForm
        },
        setup() {
            const {roles, listarRoles} = useRol()
            const {modelos, listarModelos, listarPermisos,
            role, permisos, rolePermisos ,errors,
            listarPermisosModelo, prueba} = usePermisoRole()
            const obtenerRoles = async() =>{
                await listarRoles()
            }
            const obtenerModelos = async() =>{
                await listarModelos()
            }
            onMounted(() => {
                obtenerRoles()
                obtenerModelos()

            })
            const role_permisos=ref({
                role_id         : '',
                role_nombre     : '',
                modelo          : '',
                permiso_id      : []
            })
            const mostrarRolePermisos = async() =>{
                await listarPermisos(role_permisos.value)
                role_permisos.value.role_nombre=role.value.nombre
                await listarPermisosModelo(role_permisos.value)
                role_permisos.value.permiso_id = []
                rolePermisos.value.forEach(p=>{
                    role_permisos.value.permiso_id.push(p.id)
                })
            }
            return {
                roles, obtenerRoles, role_permisos,
                errors, modelos, mostrarRolePermisos,
                permisos, role
            }

        },
    }
</script>
