<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Elecci&oacute; Juntas
                <a class="btn btn-danger btn-sm ml-1"
                    @click.prevent="nuevo">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-2 col-md-2 mb-1">
                    <select class="form-control form-control-sm" v-model="dato.paginacion"
                        @change="cambiarPaginacion">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-2 col-md-2 mb-1">
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
                                    <th colspan="6" class="text-center">Elecciones Juntas {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Periodo</th>
                                    <th class="text-center">Junta Directiva</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="elecciones_juntas.total == 0">
                                    <td class="text-danger text-center table-danger" colspan="6">
                                        -- Datos No Registrados --
                                    </td>
                                </tr>
                                <tr v-else
                                    v-for="(eleccion,indice) in elecciones_juntas.data" :key="eleccion.id"
                                    :class="{ 'table-danger': eleccion.es_activo==0}">
                                    <td > {{ indice + elecciones_juntas.from }}</td>
                                    <td v-text="eleccion.periodo" class="text-center"></td>
                                    <td v-text="eleccion.junta_directiva" class="text-center"></td>
                                    <td class="text-center">
                                        {{ $filters.formatoFecha(eleccion.fecha_eleccion) }}
                                    </td>
                                    <td class="text-center">
                                        <span v-if="eleccion.es_activo==1" class="badge badge-success">ACTIVO</span>
                                        <span v-if="eleccion.es_activo==0" class="badge badge-danger">INACTIVO</span>
                                    </td>
                                    <td>
                                        <template v-if="eleccion.es_activo==1">
                                            <button class="btn btn-info btn-xs mr-1"
                                                title="Mostrar eleccion Junta"
                                                @click.prevent="mostrar(eleccion.id)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-xs mr-1"
                                                title="Editar eleccion Junta"
                                                @click.prevent="editar(eleccion.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-primary btn-xs mr-1"
                                                title="Mostrar Cargos Directivos"
                                                @click.prevent="mostrarCargosDirectivos(eleccion.id)">
                                                <i class="fas fa-clipboard-user"></i>
                                            </button>
                                            <button class="btn bg-purple btn-xs mr-1"
                                                title="Mostrar Candidatos"
                                                @click.prevent="mostrarCandidatos(eleccion.id)">
                                                <i class="fas fa-user-graduate"></i>
                                            </button>

                                            <button class="btn btn-danger btn-xs mr-1"
                                                title="Inhabilitar eleccion Junta"
                                                @click.prevent="inhabilitar(eleccion.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <button class="btn btn-success btn-xs mr-1"
                                            title="Habilitar eleccion Junta"
                                            @click.prevent="habilitar(eleccion.id)" v-if="eleccion.es_activo==0">
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
                    Mostrando <b>{{elecciones_juntas.from}}</b> a <b>{{ elecciones_juntas.to }}</b> de <b>{{ elecciones_juntas.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="elecciones_juntas.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="elecciones_juntas.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(elecciones_juntas.current_page - 1)">

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
                            <li v-if="elecciones_juntas.current_page < elecciones_juntas.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(elecciones_juntas.current_page + 1)">
                                    <span><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="elecciones_juntas.current_page <= elecciones_juntas.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(elecciones_juntas.last_page)"
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
    <eleccion-junta-form :form="form" @onEleccionJuntas="listar" ></eleccion-junta-form>
    <cargo-directivo-form :form="form" @onEleccionJuntas="obtenerDatos"></cargo-directivo-form>
    <candidato-form :form="form" @onEleccionJuntas="obtenerDatosCandidatos"></candidato-form>
</template>

<script>
import { onMounted, computed, ref, inject } from 'vue'
import useHelper from '@/Helpers'
import useEleccionJunta from '@/Composables/eleccion/eleccion-juntas'
import EleccionJuntaForm from './Form.vue'
import CargoDirectivoForm from './CargoDirectivo.vue'
import CandidatoForm from './Candidato.vue';

export default {
    components:{
        EleccionJuntaForm, CargoDirectivoForm, CandidatoForm
    },
    setup() {
        const { defineTitle, Swal, Toast } = useHelper()

        const {
            errors, elecciones_juntas, eleccion_junta, respuesta, candidatos,
            obtenerEleccionJuntas, obtenerEleccionJunta, inhabilitarEleccionJunta,
            habilitarEleccionJunta, obtenerCandidatos
        } = useEleccionJunta()

        const offset = 4

        const dato = ref({
            page:'',
            show_tipo : 'activos',
            paginacion: 10
        })

        const form=ref({
            id:'',
            periodo_junta_id: '',
            junta_directiva_id : '',
            cargo_directivo_id: '',
            fecha:'',
            hora: '',
            es_activo : 1,
            estadoCrud:'nuevo',
            junta_directiva:'',
            periodo_junta:'',
            ministro:'',
            cargo_directivos:[],
            candidatos:[],
            errors:[]
        });

        const listar = async (page=1)  => {
            dato.value.page = page
            await obtenerEleccionJuntas(dato.value)
        }

        onMounted(() => {
            defineTitle('Elecciones Juntas')
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
            elecciones_juntas.value.current_page = pagina
            listar(pagina)
        }

        const cambiarPaginacion = () => {
            listar()
        }

        const isActived = () => {
            return elecciones_juntas.value.current_page
        }

        const pagesNumber = () => {
            if(!elecciones_juntas.value.to){
                return []
            }

            let from = elecciones_juntas.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= elecciones_juntas.value.last_page) to = elecciones_juntas.value.last_page

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
            form.value.periodo_junta_id = ''
            form.value.junta_directiva_id = ''
            form.value.cargo_directivo_id = ''
            form.value.fecha = '',
            form.value.hora = '',
            form.value.es_activo = 1
            form.value.estadoCrud=''
            form.value.cargo_directivos=[];
            form.value.candidatos = [];
            form.value.junta_directiva =''
            form.value.periodo_junta = ''
            form.value.ministro ="";
            form.value.errors=[]
            errors.value = []
        }

        const nuevo = () => {
            limpiar()
            form.value.estadoCrud = 'nuevo'
            $('.modal-title').html("Nueva Elección Junta")
            $('#modal-eleccion-junta').modal('show')
        }

        const obtenerDatos = async(id) => {
            await obtenerEleccionJunta(id)
            form.value.id = eleccion_junta.value.id
            form.value.periodo_junta_id = eleccion_junta.value.periodo_junta_id
            form.value.junta_directiva_id = eleccion_junta.value.junta_directiva_id
            form.value.fecha = eleccion_junta.value.fecha
            form.value.hora = eleccion_junta.value.hora
            form.value.junta_directiva = eleccion_junta.value.junta_directiva?.nombre ?? ''
            form.value.periodo_junta = eleccion_junta.value.periodo_junta?.anio_inicio+' - '+eleccion_junta.value.periodo_junta?.anio_fin
            form.value.cargo_directivos = eleccion_junta.value.cargo_directivos
            form.value.es_activo = eleccion_junta.value.es_activo == 1 ? true : false
        }

        const obtenerDatosCandidatos = async(id) => {
            await obtenerEleccionJunta(id)
            form.value.id = eleccion_junta.value.id
            form.value.periodo_junta_id = eleccion_junta.value.periodo_junta_id
            form.value.junta_directiva_id = eleccion_junta.value.junta_directiva_id
            form.value.fecha = eleccion_junta.value.fecha
            form.value.hora = eleccion_junta.value.hora
            form.value.junta_directiva = eleccion_junta.value.junta_directiva?.nombre ?? ''
            form.value.periodo_junta = eleccion_junta.value.periodo_junta?.anio_inicio+' - '+eleccion_junta.value.periodo_junta?.anio_fin
            form.value.cargo_directivos = eleccion_junta.value.cargo_directivos
            form.value.es_activo = eleccion_junta.value.es_activo == 1 ? true : false

            await obtenerCandidatos(id)
            form.value.candidatos = candidatos.value;
        }


        const mostrar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'mostrar'

            $('.modal-title').html("Datos Elección Junta")
            $('#modal-eleccion-junta').modal('show')
        }

        const editar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'editar'

            $('.modal-title').html("Editar Elección Junta")
            $('#modal-eleccion-junta').modal('show')
        }

        const mostrarCargosDirectivos = async (id) => {
            limpiar()
            await obtenerDatos(id)
            form.value.estadoCrud = 'cargos'
            $('#modal-title-cargo-directivos').html(form.value.junta_directiva+' / Periodo '+form.value.periodo_junta)
            $('#modal-cargo-directivos').modal('show')
        }

        const mostrarCandidatos = async(id) => {
            limpiar()
            await obtenerDatos(id);
            form.value.estadoCrud = 'candidatos';
            await obtenerCandidatos(id);
            form.value.candidatos = candidatos.value
            $('#modal-title-candidatos').html(form.value.junta_directiva+' / Periodo '+form.value.periodo_junta)
            $('#modal-candidatos').modal('show')
        }

        const inhabilita = async (id) => {
            await inhabilitarEleccionJunta(id)
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
                title: 'Elecciones Juntas',
                text:'¿Está seguro de inhabilitar la Elección Junta',
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
            await  habilitarEleccionJunta(id)
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
                title: 'Elecciones Juntas',
                text:'¿Está seguro de habilitar la Elección Junta',
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
            dato, form, elecciones_juntas, candidatos,
            listar, mostrarActivos, mostrarInactivos, mostrarTodos, cambiarPagina,
            cambiarPaginacion, isActived, pagesNumber, nuevo, mostrar, editar,
            habilitar, inhabilitar, mostrarCargosDirectivos, obtenerDatos, mostrarCandidatos,
            obtenerDatosCandidatos
        }
    },
}
</script>
