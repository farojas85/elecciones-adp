<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Roles&nbsp;
                <a class="btn btn-danger btn-sm"
                    @click.prevent="nuevo">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-1 mb-1">
                    <select class="form-control form-control-sm" @change="cambiarPaginacion">
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
                            <a class="dropdown-item" href="" @click.prevent="mostrarTodos">Todos</a>
                            <a class="dropdown-item" href="" @click.prevent="mostrarHabilitados">Habilitados</a>
                            <a class="dropdown-item" href="" @click.prevent="mostrarEliminados">Eliminados</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Buscar</span>
                        </div>
                        <input type="text" class="form-control" v-model="dato.buscar"
                            placeholder="Ingrese nombre, slug, tipo acceso"
                            @keyup="buscar" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="6" class="text-center"> Roles - {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Tipo Acceso</th>
                                    <th>Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="roles.total == 0">
                                    <td class="text-danger text-center" colspan="6">
                                        -- Datos No Registrados - Tabla Vacía --
                                    </td>
                                </tr>
                                <tr v-else v-for="(role,index) in roles.data" :key="role.id">
                                    <td>{{ index + roles.from }}</td>
                                    <td>{{ role.nombre }}</td>
                                    <td>{{ role.slug }}</td>
                                    <td>
                                        <span class="badge bg-indigo" v-if="role.tipo_acceso.slug=='acceso-total'">
                                            {{role.tipo_acceso.nombre}}
                                        </span>
                                        <span class="badge bg-primary" v-else-if="role.tipo_acceso.slug=='acceso-parcial'">
                                            {{role.tipo_acceso.nombre}}
                                        </span>
                                        <span class="badge bg-navy" v-else-if="role.tipo_acceso.slug=='acceso-denegado'">
                                            {{role.tipo_acceso.nombre}}
                                        </span>
                                        <span class="badge bg-maroon" v-else-if="role.tipo_acceso.slug=='invitado'">
                                            {{role.tipo_acceso.nombre}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success" v-if="role.es_activo==1">Activo</span>
                                        <span class="badge bg-secondary" v-else>Inactivo</span>
                                    </td>
                                    <td>
                                        <template v-if="role.deleted_at == null">
                                            <button class="btn btn-warning btn-sm mr-1" title="Editar Rol" @click.prevent="editar(role.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm mr-1" title="Enviar a Papelera" @click.prevent="eliminar(role.id, 'Temporal')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button class="btn bg-indigo btn-sm mr-1" title="Restaurar" @click.prevent="restaurar(role.id)">
                                                <i class="fas fa-trash-restore-alt"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" title="Eliminar Permanente" @click.prevent="eliminar(role.id, 'Permanente')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Mostrando <b>{{roles.from}}</b> a <b>{{ roles.to }}</b> de <b>{{ roles.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="roles.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">

                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="roles.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(roles.current_page - 1)">

                                    <span><i class="fas fa-angle-left"></i></span>
                                </a>
                            </li>
                            <li v-for="page in pagesNumber()" class="page-item"
                                :key="page"
                                :class="[ page == isActived() ? 'active' : '']"
                                :title="'Página '+ page">
                                <a href="#" class="page-link"
                                    @click.prevent="cambiarPagina(page)">{{ page }}</a>
                            </li>
                            <li v-if="roles.current_page < roles.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(roles.current_page + 1)">
                                    <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="roles.current_page <= roles.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(roles.last_page)"
                                    title="Última Página">
                                    <span aria-hidden="true"><i class="fas fa-forward-fast"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <RoleForm :form="form" @onRoles="listar" :errors="errors" />
</template>

<script>
    import { onMounted, computed, ref } from 'vue'
    import useHelper from '@/Helpers'
    import useRole from '@/Composables/sistema/roles'
    import RoleForm from './Form.vue'

    export default {
        components:{
            RoleForm
        },
        setup() {
            const { defineTitle } = useHelper()

            const {
                role, roles, errors, datoRole, respuesta, obtenerRoles, obtenerRole,
                eliminarTemporalRole, eliminarPermanenteRole, restaurarRole
             } = useRole()

            const offset = 4

            const dato = ref({
                page:'',
                buscar:'',
                show_tipo : 'habilitados',
                paginacion: 5
            })

            const form =ref({
                id:'',
                nombre : '',
                slug : '',
                es_activo : '1',
                tipo_acceso_id:'',
                estadoCrud:'nuevo',
                errors:[]
            });

            const listar = async(page=1) => {
                dato.value.page = page
                await obtenerRoles(dato.value)
            }

            const getResults = () => {
                listar(roles.value.current_page)
            }

            onMounted(() => {
                defineTitle('Roles')
                listar()
            })

            const cambiarPaginacion = (event) => {
                dato.value.paginacion = event.target.value
                listar()
            }

            const mostrarHabilitados = async () => {
                dato.value.show_tipo = 'habilitados'
                listar()
            }

            const mostrarEliminados = async () => {
                dato.value.show_tipo = 'eliminados'
                listar()
            }

            const mostrarTodos = async () => {
                dato.value.show_tipo = 'todos'
                listar()
            }

            //Devuelve la pagina actual
            const isActived = () => {
                return roles.value.current_page
            }

            const pagesNumber = () => {
                if(!roles.value.to){
                    return []
                }

                let from = roles.value.current_page - offset

                if(from < 1) from = 1

                let to = from + (offset*2)

                if( to >= roles.value.last_page) to = roles.value.last_page

                let pagesArray = []

                while(from <= to) {
                    pagesArray.push(from)
                    from ++
                }

                return pagesArray
            }

            const cambiarPagina = (pagina) =>{
                roles.value.current_page = pagina
                listar(pagina)
            }

            computed(() => {
                isActived()
                pagesNumber()
            })

            const buscar = async(event) => {
                dato.value.buscar = event.target.value
                listar()
            }

            const limpiar = () =>{
                form.value.id= ""
                form.value.nombre = ""
                form.value.slug= ""
                form.value.tipo_acceso_id = ""
                form.value.es_activo= 1
                errors.value=[]
                form.value.errors = []
            }

            const nuevo = () => {
                limpiar()

                form.value.estadoCrud = 'nuevo'
                $('#modal-title').html('Nuevo Rol')
                $('#modal-role').modal('show')

            }

            const obtenerDatosRole = async(id) => {
                await obtenerRole(id)
                form.value.id = role.value.id
                form.value.nombre= role.value.nombre
                form.value.slug= role.value.slug
                form.value.tipo_acceso_id = role.value.tipo_acceso_id
                form.value.es_activo= (role.value.es_activo == 1) ? true : false
            }

            const editar = (id) => {
                limpiar()
                obtenerDatosRole(id)
                form.value.estadoCrud ='editar'
                $('.modal-title').html('Editar Rol')
                $('#modal-role').modal('show')
            }

            const eliminarTemporal = async(id) => {
                await eliminarTemporalRole(id)
                if(respuesta.value.ok==1)
                {
                    Swal.fire(
                        'Roles',
                        respuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(roles.value.current_page)
                }
            }

            const eliminarPermanente = async(id) => {
                await eliminarPermanenteRole(id)
                if(respuesta.value.ok==1)
                {
                    Swal.fire(
                        'Roles',
                        respuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(roles.value.current_page)
                }
            }

            const eliminar = (id, tipo) => {
                Swal.fire({
                    title: "Roles",
                    text: "¿Estás seguro de Eliminar?",
                    icon: "question",
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "Si",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    cancelButtonColor:'#c82333'
                }).then((result) => {
                    if(result.isConfirmed) {
                        if(tipo=='Temporal'){
                            eliminarTemporal(id)
                        }else{
                            eliminarPermanente(id)
                        }
                    }
                });
            }

            const restauraRole = async(id) => {
                await restaurarRole(id)

                if(respuesta.value.ok==1)
                {
                    Swal.fire(
                        'Roles',
                        respuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(roles.value.current_page)
                }
            }

            const restaurar = (id) => {
                Swal.fire({
                    title: "Roles",
                    text: "¿Estás seguro de Restaurar el Rol?",
                    icon: "question",
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "Si",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    cancelButtonColor:'#c82333'
                }).then((result) => {
                    if(result.isConfirmed) {
                        restauraRole(id)
                    }
                });
            }


            return {
                listar, getResults, mostrarTodos, mostrarHabilitados, mostrarEliminados,
                cambiarPaginacion, cambiarPagina, isActived, pagesNumber, buscar, nuevo,
                dato, limpiar, form, roles, role, datoRole, errors, respuesta,
                editar, eliminar,restaurar
            }
        },
    }
</script>
