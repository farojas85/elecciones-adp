<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Usuarios&nbsp;
                <a class="btn btn-danger btn-sm"
                    @click.prevent="">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-1 mb-1">
                    <select class="form-control form-control-sm" >
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-5 mb-1">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Mostrar <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="" @click.prevent="">Todos</a>
                            <a class="dropdown-item" href="" @click.prevent="">Habilitados</a>
                            <a class="dropdown-item" href="" @click.prevent="">Eliminados</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Buscar</span>
                        </div>
                        <input type="text" class="form-control"
                            placeholder="Ingrese Usuario, nombres, apellidos, etc."
                             />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="7" class="text-center">Usuarios {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Email</th>
                                    <th>Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="usuarios.total == 0">
                                    <td class="text-center text-danger" colspan="7">
                                        -- Datos no registrados - tabla vacía --
                                    </td>
                                </tr>
                                <tr v-else v-for="(usuario,index) in usuarios.data" :key="usuario.id">
                                    <td>{{  index + usuarios.from }}</td>
                                    <td>
                                        <img :src="'images/'+usuario.foto" class="img-circle img-size-32" alt=""
                                            height="32">
                                    </td>
                                    <td>{{ usuario.name }}</td>
                                    <td>{{ usuario.persona.apellido_paterno + ' '+usuario.persona.apellido_materno + ', '+usuario.persona.nombres }}</td>
                                    <td>{{ usuario.email }}</td>
                                    <td>
                                        <span class="badge bg-success" v-if="usuario.es_activo==1">Activo</span>
                                        <span class="badge bg-secondary" v-else>Inactivo</span>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, computed, ref } from 'vue'
import useHelper from '@/Helpers'
import useUsuario from '@/Composables/sistema/usuarios'

export default {
    setup() {
        const { defineTitle } = useHelper()

        const {
            usuarios, usuario, errors, obtenerUsuarios
        } = useUsuario()

        const show_tipo = ref("habilitados")

        const offset = 4

        const dato = ref({
            page : '',
            buscar : '',
            show_tipo : 'habilitados',
            paginacion : 5
        })

        const listarUsuarios = async(page=1) => {
            dato.value.page = page
            await obtenerUsuarios(dato.value)
        }

        onMounted(() => {
            defineTitle('Usuarios')
            listarUsuarios()
        })

        const mostrarHabilitados = async  () => {
            show_tipo.value = 'habilitados'
            dato.value.show_tipo = 'habilitados'
            listarUsuarios()
        }

        const mostrarEliminados = async  () => {
            show_tipo.value = 'eliminados'
            dato.value.show_tipo = 'eliminados'
            listarUsuarios()
        }

        const mostrarTodos = async  () => {
            show_tipo.value = 'todos'
            dato.value.show_tipo = 'todos'
            listarUsuarios()
        }

        return {
            dato, usuario, usuarios, obtenerUsuarios, errors, listarUsuarios,
            mostrarHabilitados, mostrarEliminados, mostrarTodos
        }
    },
}
</script>
