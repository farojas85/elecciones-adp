<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Cargos Directivos
                <a class="btn btn-danger btn-sm ml-1"
                    @click.prevent="nuevo">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-1 mb-1">
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
                <div class="col-md-5 mb-1">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Mostrar <span class="sr-only">Toggle Dropdown</span>
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
                <div class="col-md-6 mb-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Buscar</span>
                        </div>
                        <input type="text" class="form-control" v-model="dato.buscar"
                            placeholder="Ingrese nombre"
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
                                    <th colspan="5" class="text-center">Grados Ministeriales {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="cargos_directivos.total == 0">
                                    <td class="text-danger text-center" colspan="4">
                                        -- Datos No Registrados --
                                    </td>
                                </tr>
                                <tr v-else
                                    v-for="(grado,indice) in cargos_directivos.data" :key="grado.id">
                                    <td > {{ indice + cargos_directivos.from }}</td>
                                    <td v-text="grado.nombre"></td>
                                    <td class="text-center">
                                        <span v-if="grado.es_activo==1" class="badge badge-success">ACTIVO</span>
                                        <span v-if="grado.es_activo==0" class="badge badge-danger">INACTIVO</span>
                                    </td>
                                    <td>
                                        <template v-if="grado.es_activo==1">
                                            <button class="btn btn-warning btn-xs mr-1"
                                                title="Editar Cargo Directivo"
                                                @click.prevent="editar(grado.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs mr-1"
                                                title="Inhabilitar Cargo Directivo"
                                                @click.prevent="inhabilitar(grado.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <button class="btn btn-success btn-xs mr-1"
                                            title="Habilitar Cargo Directivo"
                                            @click.prevent="habilitar(grado.id)" v-if="grado.es_activo==0">
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
                    Mostrando <b>{{cargos_directivos.from}}</b> a <b>{{ cargos_directivos.to }}</b> de <b>{{ cargos_directivos.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="cargos_directivos.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="cargos_directivos.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(cargos_directivos.current_page - 1)">

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
                            <li v-if="cargos_directivos.current_page < cargos_directivos.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(cargos_directivos.current_page + 1)">
                                    <span><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="cargos_directivos.current_page <= cargos_directivos.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(cargos_directivos.last_page)"
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
    <cargo-directivo-form :form="form" @onCargoDirectivos="listar"></cargo-directivo-form>
</template>

<script>
import { onMounted, computed, ref, inject } from 'vue'
import useHelper from '@/Helpers'
import useCargoDirectivo from '@/Composables/configuracion/cargo-directivos'
import CargoDirectivoForm from './Form.vue'
export default {
    components:{
        CargoDirectivoForm
    },
    setup() {
        const { defineTitle, Swal,Toast } = useHelper()


        const {
            errors, cargos_directivos, cargo_directivo, respuesta,
            obtenerCargosDirectivos, obtenerCargoDirectivo, inhabilitarCargoDirectivo,
            habilitarCargoDirectivo
        } = useCargoDirectivo()

        const offset = 2

        const dato = ref({
            page:'',
            buscar:'',
            show_tipo : 'activos',
            paginacion: 10
        })

        const form=ref({
            id:'',
            nombre : '',
            es_activo : '1',
            estadoCrud:'nuevo',
            errors:[]
        });

        const listar = async (page=1)  => {
            dato.value.page = page
            await obtenerCargosDirectivos(dato.value)
        }

        const getResult = () => {
            listar(cargos_directivos.value.current_page)
        }

        const buscar = async() =>{
            listar()
        }

        onMounted(() => {
            defineTitle('Grados Ministeriales')
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
            cargos_directivos.value.current_page = pagina
            listar(pagina)
        }

        const cambiarPaginacion = () => {
            listar()
        }

        const isActived = () => {
            return cargos_directivos.value.current_page
        }

        const pagesNumber = () => {
            if(!cargos_directivos.value.to){
                return []
            }

            let from = cargos_directivos.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= cargos_directivos.value.last_page) to = cargos_directivos.value.last_page

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
            form.value.nombre = ''
            form.value.es_activo = 1
            form.value.estadoCrud=''
            form.value.errors=[]
            errors.value = []
        }

        const nuevo = () => {
            limpiar()
            form.value.estadoCrud = 'nuevo'
            $('.modal-title').html('Nuevo Cargo Directivo')
            $('#modal-cargo-directivo').modal('show')
        }

        const obtenerDatos = async(id) => {
            await obtenerCargoDirectivo(id)
            form.value.id = cargo_directivo.value.id
            form.value.nombre= cargo_directivo.value.nombre
            form.value.es_activo= (cargo_directivo.value.es_activo == 1) ? true : false
        }

        const editar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'editar'
            $('.modal-title').html('Editar Cargo Directivo')
            $('#modal-cargo-directivo').modal('show')
        }

        const inhabilita = async (id) => {
            await inhabilitarCargoDirectivo(id)
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
                title: 'Grados Ministeriales',
                text:'¿Está seguro de inhabilitar el Cargo Directivo?',
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
            await habilitarCargoDirectivo(id)
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
                title: 'Grados Ministeriales',
                text:'¿Está seguro de habilitar el Cargo Directivo?',
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
            dato, cargos_directivos, form,
            listar, getResult, isActived, pagesNumber, cambiarPagina, cambiarPaginacion,
            mostrarActivos, mostrarInactivos, mostrarTodos, buscar, nuevo, editar,
            inhabilitar, habilitar
        }
    },
}
</script>
