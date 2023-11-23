<template>
    <content-header :titulo="titulo" :icon="icon" :subTitulo="subTitulo"></content-header>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Usuarios','fa fa-users')" >
                                <i class="fa fa-users"></i> Usuarios
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Tipo Accesos','fas fa-low-vision')" >
                                <i class="fas fa-low-vision"></i> Tipo Acceso
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Roles','fas fa-tags')" >
                                <i class="fas fa-tags"></i> Roles
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Menús','fas fa-bars')" >
                                <i class="fas fa-bars"></i> Men&uacute;s
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Menús - Roles','fas fa-user-minus')" >
                                <i class="fas fa-user-minus"></i> Men&uacute;s / Roles
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Permisos','fas fa-shield-alt')" >
                                <i class="fas fa-shield-alt"></i> Permisos
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Permisos - Roles','fas fa-user-shield')" >
                                <i class="fas fa-user-shield"></i> Permisos / Roles
                            </button>
                        </div>
                        <div class="card-body">
                            <usuario-view v-if="vista=='Usuarios'"></usuario-view>
                            <tipo-acceso-view v-else-if="vista=='Tipo Accesos'"></tipo-acceso-view>
                            <role-view v-else-if="vista == 'Roles'"></role-view>
                            <menu-view v-else-if="vista == 'Menús' "></menu-view>
                            <menu-role-view v-else-if="vista == 'Menús - Roles'"></menu-role-view>
                            <permiso-view v-else-if="vista== 'Permisos'"></permiso-view>
                            <permiso-role-view v-else-if="vista == 'Permisos - Roles'"></permiso-role-view>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script >
    import { onMounted,ref } from 'vue'
    import ContentHeader from '../../Components/partials/ContentHeader.vue'
    import UsuarioView from './usuario/Inicio.vue'
    import TipoAccesoView from './tipo-acceso/Inicio.vue'
    import RoleView from './roles/Inicio.vue'
    import MenuView from './menus/Inicio.vue'
    import MenuRoleView from './menu-role/Inicio.vue'
    import PermisoView from './permisos/Inicio.vue'
    import PermisoRoleView from './permiso-role/Inicio.vue'

    export default {
        components:{
            ContentHeader, UsuarioView, TipoAccesoView, RoleView,
            MenuView, MenuRoleView, PermisoView, PermisoRoleView
        },
        setup () {
            const titulo = ref("Configuración Sistema")
            const icon = ref("")
            const subTitulo = ref("Usuarios")
            const vista = ref("Usuarios")

            const cambiarVista = (nuevaVista,icono) => {
                vista.value = nuevaVista
                titulo.value = "Configuración "+nuevaVista
                icon.value = icono
                subTitulo.value = nuevaVista
            }

            return {
                titulo, subTitulo, vista, cambiarVista, icon
            }
        }
    }
</script>
