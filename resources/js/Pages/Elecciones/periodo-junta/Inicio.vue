<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Periodo Juntas
                <a class="btn btn-danger btn-sm ml-1"
                    @click.prevent="nuevo">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
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
                            <span class="input-group-text font-weight-bold">registros</span>
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
                                    <th colspan="5" class="text-center">Periodos Juntas {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">A&ntilde;o Inicio</th>
                                    <th class="text-center">A&ntilde;o Fin</th>
                                    <th class="text-center">Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="periodos_juntas.total == 0">
                                    <td class="text-danger text-center table-danger" colspan="5">
                                        -- Datos No Registrados --
                                    </td>
                                </tr>
                                <tr v-else
                                    v-for="(periodo,indice) in periodos_juntas.data" :key="periodo.id"
                                    :class="{ 'table-danger': periodo.es_activo==0}">
                                    <td > {{ indice + periodos_juntas.from }}</td>
                                    <td v-text="periodo.anio_inicio" class="text-center"></td>
                                    <td v-text="periodo.anio_fin" class="text-center"></td>
                                    <td class="text-center">
                                        <span v-if="periodo.es_activo==1" class="badge badge-success">ACTIVO</span>
                                        <span v-if="periodo.es_activo==0" class="badge badge-danger">INACTIVO</span>
                                    </td>
                                    <td>
                                        <template v-if="periodo.es_activo==1">
                                            <button class="btn btn-info btn-xs mr-1"
                                                title="Mostrar Periodo Junta"
                                                @click.prevent="mostrar(periodo.id)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-xs mr-1"
                                                title="Editar Periodo Junta"
                                                @click.prevent="editar(periodo.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs mr-1"
                                                title="Inhabilitar Periodo Junta"
                                                @click.prevent="inhabilitar(periodo.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <button class="btn btn-success btn-xs mr-1"
                                            title="Habilitar Periodo Junta"
                                            @click.prevent="habilitar(periodo.id)" v-if="periodo.es_activo==0">
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
                    Mostrando <b>{{periodos_juntas.from}}</b> a <b>{{ periodos_juntas.to }}</b> de <b>{{ periodos_juntas.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="periodos_juntas.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="periodos_juntas.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(periodos_juntas.current_page - 1)">

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
                            <li v-if="periodos_juntas.current_page < periodos_juntas.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(periodos_juntas.current_page + 1)">
                                    <span><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="periodos_juntas.current_page <= periodos_juntas.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(periodos_juntas.last_page)"
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
    <periodo-junta-form :form="form" @onPeriodoJuntas="listar"></periodo-junta-form>
</template>

<script>
import { onMounted, computed, ref, inject } from 'vue'
import useHelper from '@/Helpers'
import usePeriodoJunta from '@/Composables/eleccion/periodo-juntas'
import PeriodoJuntaForm from './Form.vue'

export default {
    components:{
        PeriodoJuntaForm
    },
    setup() {
        const { defineTitle, Swal, Toast } = useHelper()

        const {
            periodos_juntas, periodo_junta, respuesta, errors,
            obtenerPeriodosJuntas, obtenerPeriodoJunta,
            habilitarPeriodoJunta, inhabilitarPeriodoJunta
        } = usePeriodoJunta()

        const offset = 4

        const dato = ref({
            page:'',
            show_tipo : 'activos',
            paginacion: 5
        })

        const form=ref({
            id:'',
            anio_inicio : '',
            anio_fin: '',
            es_activo : 1,
            estadoCrud:'nuevo',
            errors:[]
        });

        const listar = async (page=1)  => {
            dato.value.page = page
            await obtenerPeriodosJuntas(dato.value)
        }

        onMounted(() => {
            defineTitle('Periodos Juntas')
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
            periodos_juntas.value.current_page = pagina
            listar(pagina)
        }

        const cambiarPaginacion = () => {
            listar()
        }

        const isActived = () => {
            return periodos_juntas.value.current_page
        }

        const pagesNumber = () => {
            if(!periodos_juntas.value.to){
                return []
            }

            let from = periodos_juntas.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= periodos_juntas.value.last_page) to = periodos_juntas.value.last_page

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
            form.value.id = ''
            form.value.anio_inicio = ''
            form.value.anio_fin = ''
            form.value.es_activo = 1
            form.value.estadoCrud=''
            form.value.errors=[]
            errors.value = []
        }

        const nuevo = () => {
            limpiar()
            form.value.estadoCrud = 'nuevo'
            $('.modal-title').html("Nuevo Periodo Junta")
            $('#modal-periodo-junta').modal('show')
        }

        const obtenerDatos = async(id) => {
            await obtenerPeriodoJunta(id)
            form.value.id=periodo_junta.value.id
            form.value.anio_inicio=periodo_junta.value.anio_inicio
            form.value.anio_fin=periodo_junta.value.anio_fin
            form.value.es_activo= periodo_junta.value.es_activo== 1 ? true : false
        }

        const mostrar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'mostrar'
            $('.modal-title').html("Datos Periodo Junta")
            $('#modal-periodo-junta').modal('show')
        }

        const editar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'editar'
            $('.modal-title').html("Editar Periodo Junta")
            $('#modal-periodo-junta').modal('show')
        }

        const inhabilita = async (id) => {
            await inhabilitarPeriodoJunta(id)
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
                title: 'Periodos juntas',
                text:'¿Está seguro de inhabilitar el Periodo Junta',
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
            await habilitarPeriodoJunta(id)
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
                title: 'Periodos juntas',
                text:'¿Está seguro de habilitar el Periodo Junta',
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
            dato, form, periodos_juntas,
            listar, mostrarActivos, mostrarInactivos, mostrarTodos, cambiarPagina,
            cambiarPaginacion, isActived, pagesNumber, nuevo, mostrar, editar,
            habilitar, inhabilitar
        }
    },
}
</script>
