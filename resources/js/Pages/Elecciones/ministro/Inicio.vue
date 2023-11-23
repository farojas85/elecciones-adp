<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Ministros
                <a class="btn btn-danger btn-sm ml-1"
                    @click.prevent="nuevo">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <label for="" class="col-form-label col-form-label-sm col-md-1">Mostrar</label>
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
                <div class="col-md-4 mb-1">
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
                            @change="buscar" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="7" class="text-center">Ministros {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Grado Ministerial</th>
                                    <th>Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="ministros.total == 0">
                                    <td class="text-danger text-center" colspan="7">
                                        -- Datos No Registrados --
                                    </td>
                                </tr>
                                <tr v-else
                                    v-for="(ministro,indice) in ministros.data" :key="ministro.id">
                                    <td > {{ indice + ministros.from }}</td>
                                    <td>
                                         <img :src="'images/'+ministro.foto" class="img-circle img-size-32" alt=""
                                            height="32">
                                    </td>
                                    <td v-text="ministro.persona.nombres+' '+ministro.persona.apellido_paterno+' '+ministro.persona.apellido_materno"></td>
                                    <td v-text="ministro.grado_ministerial?.nombre"></td>
                                    <td class="text-center">
                                        <span v-if="ministro.es_activo==1" class="badge badge-success">ACTIVO</span>
                                        <span v-if="ministro.es_activo==0" class="badge badge-danger">INACTIVO</span>
                                    </td>
                                    <td>
                                        <template v-if="ministro.es_activo==1">
                                            <button class="btn btn-warning btn-xs mr-1"
                                                title="Editar Ministro"
                                                @click.prevent="editar(ministro.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs mr-1"
                                                title="Inhabilitar Ministro"
                                                @click.prevent="inhabilitar(ministro.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <button class="btn btn-success btn-xs mr-1"
                                            title="Habilitar Ministro"
                                            @click.prevent="habilitar(ministro.id)" v-if="ministro.es_activo==0">
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
                    Mostrando <b>{{ministros.from}}</b> a <b>{{ ministros.to }}</b> de <b>{{ ministros.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="ministros.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="ministros.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(ministros.current_page - 1)">

                                    <span><i class="fas fa-angle-left"></i></span>
                                </a>
                            </li>
                            <li v-for="page in pagesNumber()" class="page-item"
                                :key="page"
                                :class="[ page == isActived() ? 'active' : '' ]"
                                :title="'Página '+ page">
                                <a href="#" class="page-link"
                                    @click.prevent="cambiarPagina(page)">{{ page }}</a>
                            </li>
                            <li v-if="ministros.current_page < ministros.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(ministros.current_page + 1)">
                                    <span><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="ministros.current_page <= ministros.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(ministros.last_page)"
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
    <ministro-form :form="form" @onMinistros="listar"></ministro-form>
</template>

<script>
import { onMounted, computed, ref, inject } from 'vue'
import useHelper from '@/Helpers'
import useMinistro from '@/Composables/eleccion/ministros'
import MinistroForm from './Form.vue'

export default {
    components:{
        MinistroForm
    },
    setup() {
        const { defineTitle, Swal,Toast } = useHelper()

        const {
            errors, ministros, ministro, respuesta,
            obtenerMinistros, obtenerMinistro, inhabilitarMinistro, habilitarMinistro
        } = useMinistro()

        const offset = 4

        const dato = ref({
            page:'',
            buscar:'',
            show_tipo : 'activos',
            paginacion: 10
        })

        const form=ref({
            id:'',
            tipo_documento_id:'',
            numero_documento:'',
            nombres : '',
            apellido_paterno:'',
            apellido_materno:'',
            sexo_id:'',
            telefono:'',
            direccion:'',
            grados_ministeriales:[],
            es_activo : '1',
            estadoCrud:'nuevo',
            errors:[]
        });

        const listar = async (page=1)  => {
            dato.value.page = page
            await obtenerMinistros(dato.value)
        }

        const buscar = async() =>{
            await listar()
        }

        const cambiarPaginacion = () => {
            listar()
        }

        onMounted(() => {
            defineTitle('Ministros')
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
            ministros.value.current_page = pagina
            listar(pagina)
        }

        const isActived = () => {
            return ministros.value.current_page
        }

        const pagesNumber = () => {
            if(!ministros.value.to){
                return []
            }

            let from = ministros.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= ministros.value.last_page) to = ministros.value.last_page

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
            form.value.tipo_documento_id=''
            form.value.numero_documento=''
            form.value.nombres =''
            form.value.apellido_paterno=''
            form.value.apellido_materno=''
            form.value.sexo_id=''
            form.value.telefono=''
            form.value.direccion=''
            form.value.grados_ministeriales=[]
            form.value.es_activo =1
            form.value.errors = []
            errors.value=[]
        }

        const nuevo = () => {
            limpiar()
            form.value.estadoCrud = 'nuevo'
            $('.modal-title').html('Nuevo Ministro')
            $('#modal-ministro').modal('show')
        }

        const obtenerDatos = async(id) => {
            await obtenerMinistro(id)
            form.value.id=ministro.value.id
            form.value.tipo_documento_id=ministro.value.persona.tipo_documento_id
            form.value.numero_documento=ministro.value.persona.numero_documento
            form.value.nombres =ministro.value.persona.nombres
            form.value.apellido_paterno=ministro.value.persona.apellido_paterno
            form.value.apellido_materno=ministro.value.persona.apellido_materno
            form.value.sexo_id=ministro.value.persona.sexo_id
            form.value.telefono=ministro.value.persona.telefono
            form.value.direccion=ministro.value.persona.direccion
            //form.value.grados_ministeriales= []
            form.value.es_activo = ministro.value.es_activo == 1 ? true : false
        }

        const editar = (id) => {
            limpiar()
            obtenerDatos(id)
            form.value.estadoCrud = 'editar'
            $('.modal-title').html('Editar Ministro')
            $('#modal-ministro').modal('show')
        }

        const inhabilita = async (id) => {
            await inhabilitarMinistro(id)
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
                title: 'Ministros',
                text:'¿Está seguro de inhabilitar el Ministro?',
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
            await habilitarMinistro(id)
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
                title: 'Ministros',
                text:'¿Está seguro de habilitar el Ministro?',
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
            dato, form, ministros, errors,
            listar, buscar, cambiarPaginacion, mostrarActivos, mostrarInactivos, mostrarTodos,
            cambiarPagina, isActived, pagesNumber, nuevo, editar, inhabilitar, habilitar
        }
    },
}
</script>
