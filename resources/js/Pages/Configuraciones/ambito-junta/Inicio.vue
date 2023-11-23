<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Ámbitos Juntas
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
                                    <th colspan="5" class="text-center">Ámbitos juntas {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="ambitos_juntas.total == 0">
                                    <td class="text-danger text-center" colspan="4">
                                        -- Datos No Registrados --
                                    </td>
                                </tr>
                                <tr v-else
                                    v-for="(ambito,indice) in ambitos_juntas.data" :key="ambito.id">
                                    <td > {{ indice + ambitos_juntas.from }}</td>
                                    <td v-text="ambito.nombre"></td>
                                    <td class="text-center">
                                        <span v-if="ambito.es_activo==1" class="badge badge-success">ACTIVO</span>
                                        <span v-if="ambito.es_activo==0" class="badge badge-danger">INACTIVO</span>
                                    </td>
                                    <td>
                                        <template v-if="ambito.es_activo==1">
                                            <button class="btn btn-warning btn-xs mr-1"
                                                title="Editar Ámbito Junta"
                                                @click.prevent="editar(ambito.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs mr-1"
                                                title="Inhabilitar Ámbito Junta"
                                                @click.prevent="inhabilitar(ambito.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <button class="btn btn-success btn-xs mr-1"
                                            title="Habilitar Ámbito Junta"
                                            @click.prevent="habilitar(ambito.id)" v-if="ambito.es_activo==0">
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
                    Mostrando <b>{{ambitos_juntas.from}}</b> a <b>{{ ambitos_juntas.to }}</b> de <b>{{ ambitos_juntas.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="ambitos_juntas.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="ambitos_juntas.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(ambitos_juntas.current_page - 1)">

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
                            <li v-if="ambitos_juntas.current_page < ambitos_juntas.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(ambitos_juntas.current_page + 1)">
                                    <span><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="ambitos_juntas.current_page <= ambitos_juntas.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(ambitos_juntas.last_page)"
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
    <ambito-junta-form :form="form" @onAmbitoJuntas="listar"></ambito-junta-form>
</template>

<script>
import { onMounted, computed, ref, inject } from 'vue'
import useHelper from '@/Helpers'
import useAmbitoJunta from '@/Composables/configuracion/ambito-juntas'
import AmbitoJuntaForm from './Form.vue'
export default {
    components:{
        AmbitoJuntaForm
    },
    setup() {
        const { defineTitle, Swal,Toast } = useHelper()


        const {
            errors, ambitos_juntas, ambito_junta, respuesta,
            obtenerAmbitosJuntas, obtenerAmbitoJunta, inhabilitarAmbitoJunta, habilitarAmbitoJunta
        } = useAmbitoJunta()

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
            es_activo : '1',
            estadoCrud:'nuevo',
            errors:[]
        });

        const listar = async (page=1)  => {
            dato.value.page = page
            await obtenerAmbitosJuntas(dato.value)
        }

        const getResult = () => {
            listar(ambitos_juntas.value.current_page)
        }

        const buscar = async() =>{
            listar()
        }

        onMounted(() => {
            defineTitle('Ámbitos juntas')
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
            ambitos_juntas.value.current_page = pagina
            listar(pagina)
        }

        const cambiarPaginacion = () => {
            listar()
        }

        const isActived = () => {
            return ambitos_juntas.value.current_page
        }

        const pagesNumber = () => {
            if(!ambitos_juntas.value.to){
                return []
            }

            let from = ambitos_juntas.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= ambitos_juntas.value.last_page) to = ambitos_juntas.value.last_page

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
            $('.modal-title').html('Nuevo Ámbito Junta')
            $('#modal-ambito-junta').modal('show')
        }

        const obtenerDatos = async(id) => {
            await obtenerAmbitoJunta(id)
            form.value.id = ambito_junta.value.id
            form.value.nombre= ambito_junta.value.nombre
            form.value.es_activo= (ambito_junta.value.es_activo == 1) ? true : false
        }

        const editar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'editar'
            $('.modal-title').html('Editar Ámbito Junta')
            $('#modal-ambito-junta').modal('show')
        }

        const inhabilita = async (id) => {
            await inhabilitarAmbitoJunta(id)
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
                title: 'Ámbitos juntas',
                text:'¿Está seguro de inhabilitar el Ámbito Junta',
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
            await habilitarAmbitoJunta(id)
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
                title: 'Ámbitos juntas',
                text:'¿Está seguro de habilitar el Ámbito Junta',
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
            dato, ambitos_juntas, form,
            listar, getResult, isActived, pagesNumber, cambiarPagina, cambiarPaginacion,
            mostrarActivos, mostrarInactivos, mostrarTodos, buscar, nuevo, editar,
            inhabilitar, habilitar
        }
    },
}
</script>
