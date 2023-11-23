<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Permisos&nbsp;
                <a class="modal-effect btn btn-danger btn-sm"
                @click="nuevoPermiso"><i class="fa fa-plus"></i></a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-1">
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
                            placeholder="Ingrese nombre, slug"
                            @keyup="buscar" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="7" class="text-center">Permisos {{ show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="permisos.total == 0">
                                    <td class="text-danger text-center" colspan="5">
                                        -- Datos No Registrados - Tabla Vacía --
                                    </td>
                                </tr>
                                <tr v-else v-for="(permiso,index) in permisos.data" :key="permiso.id">
                                    <td>{{ index + permisos.from }}</td>
                                    <td>{{ permiso.nombre }}</td>
                                    <td>{{ permiso.slug }}</td>
                                    <td>
                                        <span class="badge bg-success" v-if="permiso.es_activo==1">Activo</span>
                                        <span class="badge bg-secondary" v-else>Inactivo</span>
                                    </td>
                                    <td>
                                        <template v-if="permiso.deleted_at == null">
                                            <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(permiso.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Enviar a Papelera" @click.prevent="eliminar(permiso.id, 'Temporal')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button class="btn bg-indigo btn-sm mr-1" title="Restaurar" @click.prevent="restaurar(permiso.id)">
                                                <i class="fas fa-trash-restore-alt"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" title="Eliminar Permanente" @click.prevent="eliminar(permiso.id, 'Permanente')">
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
                    Mostrando <b>{{permisos.from}}</b> a <b>{{ permisos.to }}</b> de <b>{{ permisos.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="permisos.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">

                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="permisos.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(permisos.current_page - 1)">

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
                            <li v-if="permisos.current_page < permisos.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(permisos.current_page + 1)">
                                    <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="permisos.current_page <= permisos.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(permisos.last_page)"
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
    <PermisoForm :permiso="permiso" @onPermisos="listarPermisos" />
</template>

<script>
    import useHelper from '@/Helpers'
    import usePermiso from '@/Composables/sistema/permisos'
    import { onMounted, ref, computed } from 'vue'
    import PermisoForm from './Form.vue'
    export default {
        components:{
            PermisoForm
        },
        setup() {
            const { defineTitle } = useHelper()

            const {
                errors, permisos, obtenerPermisos, obtenerPermiso, permisoc,
            eliminarTemporalPermiso, eliminarPermanentePermiso, restaurarPermiso,
            perRespuesta} = usePermiso()

            const show_tipo = ref("habilitados")
            const offset = 4
            const dato = ref({
                page:'',
                buscar:'',
                show_tipo : 'habilitados',
                paginacion: 5
            })
            const cambiarPaginacion = (event) => {
                dato.value.paginacion = event.target.value
                listarPermisos()
            }
            const listarPermisos = async(page=1) => {
                dato.value.page= page
                await obtenerPermisos(dato.value)
            }
            const permiso=ref({
                nombre : '',
                slug : '',
                es_activo: 1,
                estadoCrud:'nuevo'
            });

            onMounted(() => {
                defineTitle('Permisos')
                listarPermisos()
            })

            computed(() => {
                isActived()
                pagesNumber()
            })

            const isActived = () => {
                return permisos.value.current_page
            }

            const pagesNumber = () => {
                if(!permisos.value.to){
                    return []
                }

                let from = permisos.value.current_page - offset

                if(from < 1) from = 1

                let to = from + (offset*2)

                if( to >= permisos.value.last_page) to = permisos.value.last_page

                let pagesArray = []

                while(from <= to) {
                    pagesArray.push(from)
                    from ++
                }

                return pagesArray
            }

            const cambiarPagina = (pagina) =>{
                permisos.value.current_page = pagina
                listarPermisos(pagina)
            }

            const obtenerDatosPermiso = async(id) => {
                await obtenerPermiso(id)
                permiso.value.id = permisoc.value.id
                permiso.value.nombre= permisoc.value.nombre
                permiso.value.slug= permisoc.value.slug
                permiso.value.es_activo= (permisoc.value.es_activo == 1) ? true : false
            }

            const editar = (id) => {
                obtenerDatosPermiso(id)
                permiso.value.estadoCrud = 'editar'
                $('#modal-permiso').modal('show')
            }

            const mostrarTodos = async () => {
                show_tipo.value = 'Todos'
                dato.value.show_tipo = 'todos'
                listarPermisos()
            }

            const mostrarHabilitados = async () => {
                show_tipo.value = 'Habilitados'
                dato.value.show_tipo = 'habilitados'
                listarPermisos()
            }

            const mostrarEliminados = async () => {
                show_tipo.value = 'Eliminados'
                dato.value.show_tipo = 'eliminados'
                listarPermisos()
            }

            const buscar = async(event) =>{
                dato.value.buscar = event.target.value
                listarPermisos()
            }

            const eliminarTemporalemente = async(id) => {
                await eliminarTemporalPermiso(id)
                if(perRespuesta.value.ok==1)
                {
                    Swal.fire(
                        'Permisos',
                        perRespuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(permisos.value.current_page)
                }
            }

            const eliminarPermanente = async(id) =>{
                await eliminarPermanentePermiso(id)
                if(perRespuesta.value.ok==1)
                {
                    Swal.fire(
                        'Permisos',
                        perRespuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(permisos.value.current_page)
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
                    if (result.isConfirmed) {
                        if(tipo=='Temporal'){
                            eliminarTemporalemente(id)
                        }else{
                            eliminarPermanente(id)
                        }
                    }
                    else {

                    }
                });
            }

            const nuevoPermiso=() => {
                errors.value = ''
                permiso.value = {
                    nombre : '',
                    slug : '',
                    tipo_acceso_id  : '',
                    es_activo : '1',
                    estadoCrud:'nuevo'
                }
                $('#modal-permiso').modal('show')
            }

            const restauraPermiso = async(id) => {
                await restaurarPermiso (id)

                if(perRespuesta.value.ok==1)
                {
                    Swal.fire(
                        'Permisos',
                        perRespuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(permisos.value.current_page)
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
                        restauraPermiso(id)
                    }
                });
            }

            return {
                permisos, listarPermisos, permiso, buscar,
                dato, show_tipo, mostrarTodos, mostrarHabilitados,
                mostrarEliminados, editar, eliminar, mostrarTodos,
                mostrarEliminados, nuevoPermiso,cambiarPaginacion,
                isActived, pagesNumber, cambiarPagina, restaurar
            }
        },
    }
</script>
