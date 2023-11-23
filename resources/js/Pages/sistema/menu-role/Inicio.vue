<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Menús / Roles&nbsp;
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
                                        v-model="role_menu.role_id"
                                        :class="{ 'is-invalid' : errors.role_id}">
                                        <option value="" >-Seleccionar-</option>
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
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success" :disabled="role_menu.role_id==''"
                                        @click="mostrarMenuRoles">
                                        <i class="fas fa-eye"></i> Mostrar
                                    </button>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-md-7">
                    <menu-role-form :role_menu="role_menu" :menus="menus" ></menu-role-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import useHelper from '@/Helpers'
import useRol from '@/Composables/sistema/roles'
import useMenuRole from '@/Composables/sistema/menu-role'
import MenuRoleForm from './Form.vue'

export default {
    components:{
        MenuRoleForm
    },
    setup() {
        const { defineTitle } = useHelper()

        const { roles, listarRoles } = useRol()

        const { menuRoles, listarMenus, listarMenuRoles,
            role, menus, errors
        } = useMenuRole()

        const role_menu=ref({
            role_id      : '',
            role_nombre  : '',
            menu_id      : []
        })

        const obtenerRoles = async() => {
            await listarRoles()
        }

        const mostrarMenuRoles = async() => {
            await listarMenuRoles(role_menu.value)
            await listarMenus()

            role_menu.value.menu_id = []
            role_menu.value.role_nombre = role.value.slug

            menuRoles.value.forEach( m => {
                role_menu.value.menu_id.push(m.id)
            })
        }

        onMounted(() => {
            defineTitle('Ménus Roles')
            obtenerRoles()
        })

        return {
            role_menu, roles, obtenerRoles, errors, menus,
            mostrarMenuRoles
        }
    },
}
</script>
