<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Vueltas
                <a class="btn btn-danger btn-sm ml-1"
                    @click.prevent="nuevo">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold">Mostrar</span>
                        </div>
                        <select class="form-control form-control-sm" v-model="dato.paginacion"
                            @change="cambiarPaginacion">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <div class="input-group-append">
                            <span class="input-group-text font-weight-bold">Registros</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-1">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Filtrar <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href=""
                                @click.prevent="mostrarTodos">Todos</a>
                            <a class="dropdown-item" href=""
                                @click.prevent="mostrarActivos">Activos</a>
                            <a class="dropdown-item" href=""
                                @click.prevent="mostrarInactivos">Inactivos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="5" class="text-center">Vueltas Proceso {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Abreviatura</th>
                                    <th>Nombre</th>
                                    <th>Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="vuelta_procesos.total == 0">
                                    <td class="text-danger text-center" colspan="4">
                                        -- Datos No Registrados --
                                    </td>
                                </tr>
                                <tr v-else
                                    v-for="(vuelta,indice) in vuelta_procesos.data" :key="vuelta.id">
                                    <td > {{ indice + vuelta_procesos.from }}</td>
                                    <td v-text="vuelta.abreviatura"></td>
                                    <td v-text="vuelta.nombre"></td>
                                    <td class="text-center">
                                        <span v-if="vuelta.es_activo==1" class="badge badge-success">ACTIVO</span>
                                        <span v-if="vuelta.es_activo==0" class="badge badge-danger">INACTIVO</span>
                                    </td>
                                    <td>
                                        <template v-if="vuelta.es_activo==1">
                                            <button class="btn btn-warning btn-xs mr-1"
                                                title="Editar Vuelta Proceso"
                                                @click.prevent="editar(vuelta.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs mr-1"
                                                title="Inhabilitar Vuelta Proceso"
                                                @click.prevent="inhabilitar(vuelta.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <button class="btn btn-success btn-xs mr-1"
                                            title="Habilitar Vuelta Proceso"
                                            @click.prevent="habilitar(vuelta.id)" v-if="vuelta.es_activo==0">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Mostrando <b>{{vuelta_procesos.from}}</b> a <b>{{ vuelta_procesos.to }}</b> de <b>{{ vuelta_procesos.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="vuelta_procesos.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="vuelta_procesos.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(vuelta_procesos.current_page - 1)">

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
                            <li v-if="vuelta_procesos.current_page < vuelta_procesos.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(vuelta_procesos.current_page + 1)">
                                    <span><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="vuelta_procesos.current_page <= vuelta_procesos.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(vuelta_procesos.last_page)"
                                    title="Última Página">
                                    <span><i class="fas fa-forward-fast"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <vuelta-proceso-form :form="form" @onVueltaProcesos="listar"></vuelta-proceso-form>
</template>

<script>
import { onMounted, computed, ref, inject } from 'vue'
import useHelper from '@/Helpers'
import VueltaProcesoForm from './Form.vue'
import useVueltaProceso from '@/Composables/eleccion/vuelta-procesos'
export default {
    components:{
        VueltaProcesoForm
    },
    setup() {
        const { defineTitle, Swal,Toast } = useHelper()

        const {
            errors, respuesta, vuelta_proceso, vuelta_procesos,
            obtenerVueltaProcesos, obtenerVueltaProceso, inhabilitarVueltaProceso,
            habilitarVueltaProceso
        } = useVueltaProceso()

        const offset = 4

        const dato = ref({
            page:'',
            buscar:'',
            show_tipo : 'activos',
            paginacion: 10
        })

        const form=ref({
            id:'',
            nombre : '',
            abreviatura: '',
            es_activo : '1',
            estadoCrud:'nuevo',
            errors:[]
        });

        const listar = async (page=1)  => {
            dato.value.page = page
            await obtenerVueltaProcesos(dato.value)
        }

        onMounted(() => {
            defineTitle('Vueltas Proceso')
            listar()
        })

        const mostrarActivos = async () => {
            dato.value.show_tipo = 'activos'
            listar()
        }

        const mostrarInactivos = async () => {
            dato.value.show_tipo = 'inactivos'
            listar()
        }

        const mostrarTodos = async () => {
            dato.value.show_tipo = 'todos'
            listar()
        }

        const cambiarPagina = (pagina) =>{
            vuelta_procesos.value.current_page = pagina
            listar(pagina)
        }

        const cambiarPaginacion = () => {
            listar()
        }

        const isActived = () => {
            return vuelta_procesos.value.current_page
        }

        const pagesNumber = () => {
            if(!vuelta_procesos.value.to){
                return []
            }

            let from = vuelta_procesos.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= vuelta_procesos.value.last_page) to = vuelta_procesos.value.last_page

            let pagesArray = []

            while(from <= to) {
                pagesArray.push(from)
                from ++
            }

            return pagesArray
        }

        computed(() => {
            isActived()
            pagesNumber()
        })

        const limpiar = () => {
            form.value.id=''
            form.value.nombre=''
            form.value.abreviatura=''
            form.value.estadoCrud=''
            form.value.es_activo=true
            form.value.errors = []
        }

        const nuevo = () => {
            limpiar()
            form.value.estadoCrud='nuevo'
            $('.modal-title').html("Nueva Vuelta Proceso")
            $('#modal-vuelta-proceso').modal('show')
        }

        const obtenerDatos = async(id) => {
            await obtenerVueltaProceso(id)
            form.value.id = vuelta_proceso.value.id
            form.value.nombre = vuelta_proceso.value.nombre
            form.value.abreviatura = vuelta_proceso.value.abreviatura
            form.value.es_activo = vuelta_proceso.value.es_activo == 1 ? true : false
        }

        const editar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'editar'
            $('.modal-title').html("Editar Vuelta Proceso")
            $('#modal-vuelta-proceso').modal('show')
        }

        const inhabilita = async (id) => {
            await inhabilitarVueltaProceso(id)
            if(respuesta.value.ok==1) {
                errors.value=[]
                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })
            }
        }

        const inhabilitar = (id) => {
             Swal.fire({
                title: 'Vueltas Procesos',
                text:'¿Está seguro de inhabilitar la Vuelta proceso',
                icon:'question',
                confirmButtonColor: "#28a745",
                confirmButtonText: "Si",
                showCancelButton: true,
                cancelButtonText: "No",
                cancelButtonColor:'#c82333'
            }).then((result) => {
                if (result.isConfirmed) {
                    inhabilita(id)
                    listar()
                }
            })
        }

        const habilita = async (id) => {
            await  habilitarVueltaProceso(id)
            if(respuesta.value.ok==1) {
                errors.value=[]
                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })
            }
        }

        const habilitar = (id) => {
             Swal.fire({
                title: 'Vueltas Procesos',
                text:'¿Está seguro de habilitar la Vuelta proceso',
                icon:'question',
                confirmButtonColor: "#28a745",
                confirmButtonText: "Si",
                showCancelButton: true,
                cancelButtonText: "No",
                cancelButtonColor:'#c82333'
            }).then((result) => {
                if (result.isConfirmed) {
                    habilita(id)
                    listar()
                }
            })
        }

        return {
            dato, form, vuelta_procesos, vuelta_proceso,
            listar, cambiarPaginacion, mostrarActivos, mostrarInactivos, mostrarTodos,
            cambiarPagina, isActived, pagesNumber, nuevo, editar, habilitar, inhabilitar
        }
    },
}
</script>
