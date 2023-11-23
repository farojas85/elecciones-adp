<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Tipo Accesos&nbsp;
                <a class="btn btn-danger btn-sm"
                    @click.prevent="nuevoTipoAcceso">
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
                            placeholder="Ingrese nombre, slug"
                            @keyup="buscarTipoAcceso" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="5" class="text-center">Tipo Accesos {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="tipoAccesos.total == 0">
                                    <td class="text-danger text-center" colspan="5">
                                        -- Datos No Registrados - Tabla Vacía --
                                    </td>
                                </tr>
                                <tr v-else v-for="(tipo,index) in tipoAccesos.data" :key="tipo.id">
                                    <td>{{ index + tipoAccesos.from }}</td>
                                    <td>{{ tipo.nombre }}</td>
                                    <td>{{ tipo.slug }}</td>
                                    <td>
                                        <span class="badge bg-success" v-if="tipo.es_activo==1">Activo</span>
                                        <span class="badge bg-secondary" v-else>Inactivo</span>
                                    </td>
                                    <td>
                                        <template v-if="tipo.deleted_at == null">
                                            <button class="btn btn-warning btn-sm mr-1" title="Editar" @click.prevent="editar(tipo.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm mr-1" title="Enviar a Papelera" @click.prevent="eliminarTipoAcceso(tipo.id, 'Temporal')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button class="btn bg-indigo btn-sm mr-1" title="Restaurar" @click.prevent="restaurar(tipo.id)">
                                                <i class="fas fa-trash-restore-alt"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" title="Eliminar Permanente" @click.prevent="eliminarTipoAcceso(tipo.id, 'Permanente')">
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
                    Mostrando <b>{{tipoAccesos.from}}</b> a <b>{{ tipoAccesos.to }}</b> de <b>{{ tipoAccesos.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="tipoAccesos.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">

                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="tipoAccesos.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(tipoAccesos.current_page - 1)">

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
                            <li v-if="tipoAccesos.current_page < tipoAccesos.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(tipoAccesos.current_page + 1)">
                                    <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="tipoAccesos.current_page <= tipoAccesos.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(tipoAccesos.last_page)"
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

    <TipoAccesoForm :form="form" @onTipoAcceso ="listarTipoAccesos"  />
</template>

<script>
import { onMounted, computed, ref } from 'vue'
import useHelper from '@/Helpers'
import useTipoAcceso from '@/Composables/sistema/tipo-accesos'
import TipoAccesoForm from './Form.vue'

export default {
    components:{
        TipoAccesoForm
    },
    setup() {
        const { defineTitle } = useHelper()

        const {
            tipoAcceso, tipoAccesos, errors, obtenerTipoAccesos, obtenerTipoAcceso,
            eliminarTemporalTipoAcceso, eliminarPermanenteTipoAcceso, taRespuesta,
            restaurarTipoAcceso
        } = useTipoAcceso()

        const offset = 4

        const dato = ref({
            page:'',
            buscar:'',
            show_tipo : 'habilitados',
            paginacion: 5
        })

        const form=ref({
            id:'',
            nombre : '',
            slug : '',
            es_activo : '1',
            estadoCrud:'nuevo'
        });

        const getResults = () => {
            listarTipoAccesos(tipoAccesos.value.current_page)
        }

        const listarTipoAccesos = async(page=1) => {
            dato.value.page= page
            await obtenerTipoAccesos(dato.value)
        }

        onMounted(() => {
            defineTitle('Tipo Accesos')
            listarTipoAccesos()
        })

        const mostrarHabilitados = async () => {
            dato.value.show_tipo = 'habilitados'
            listarTipoAccesos()
        }

        const mostrarEliminados = async () => {
            dato.value.show_tipo = 'eliminados'
            listarTipoAccesos()
        }

        const mostrarTodos = async () => {
            dato.value.show_tipo = 'todos'
            listarTipoAccesos()
        }

        const cambiarPagina = (pagina) =>{
            tipoAccesos.value.current_page = pagina
            listarTipoAccesos(pagina)
        }
        const cambiarPaginacion = (event) => {
            dato.value.paginacion = event.target.value
            listarTipoAccesos()
        }

        //Devuelve la pagina actual
        const isActived = () => {
            return tipoAccesos.value.current_page
        }

        const pagesNumber = () => {
            if(!tipoAccesos.value.to){
                return []
            }

            let from = tipoAccesos.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= tipoAccesos.value.last_page) to = tipoAccesos.value.last_page

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

        const buscarTipoAcceso = async(event) =>{
            dato.value.buscar = event.target.value
            listarTipoAccesos()
        }

        const limpiarDato = () => {
            form.value.id= ""
            form.value.nombre = ""
            form.value.slug= ""
            form.value.es_activo= 1
        }

        const nuevoTipoAcceso = () => {
            limpiarDato()
            form.value.estadoCrud='nuevo'
            $('.modal-title').html('Nuevo Tipo Acceso')
            $('#modal-tipo-acceso').modal('show')
        }

        const obtenerDatosTipoAcceso = async(id) => {
            await obtenerTipoAcceso(id)
            form.value.id = tipoAcceso.value.id
            form.value.nombre= tipoAcceso.value.nombre
            form.value.slug= tipoAcceso.value.slug
            form.value.es_activo= (tipoAcceso.value.es_activo == 1) ? true : false
        }

        const editar = (id) => {
            obtenerDatosTipoAcceso(id)
            form.value.estadoCrud ='editar'
            $('.modal-title').html('Editar Tipo Acceso')
            $('#modal-tipo-acceso').modal('show')
        }

        const eliminarTemplorar = async(id) => {
            await eliminarTemporalTipoAcceso(id)
            if(taRespuesta.value.ok==1)
            {
                Swal.fire(
                    'Tipo de Acceso',
                    taRespuesta.value.mensaje,
                    'success'
                )

                cambiarPagina(tipoAccesos.value.current_page)
            }
        }

        const eliminarTipoAccesoPermanente = async(id) =>{
            await eliminarPermanenteTipoAcceso(id)
            if(taRespuesta.value.ok==1)
            {
                Swal.fire(
                    'Tipo de Acceso',
                    taRespuesta.value.mensaje,
                    'success'
                )

                cambiarPagina(tipoAccesos.value.current_page)
            }
        }

        const eliminarTipoAcceso = (id, tipo) => {
            Swal.fire({
                title: "Tipo de Acceso",
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
                        eliminarTemplorar(id)
                    }else{
                        eliminarTipoAccesoPermanente(id)
                    }

                }
            });
        }

        const restaurar = async(id) => {
                await restaurarTipoAcceso(id)
                if(taRespuesta.value.ok==1)
                {
                    Swal.fire(
                        'Tipo de Acceso',
                        taRespuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(tipoAccesos.value.current_page)
                }
            }

        return {
            dato, form, tipoAcceso, tipoAccesos, errors, obtenerTipoAccesos, listarTipoAccesos,
            getResults, mostrarHabilitados, mostrarTodos, mostrarEliminados, isActived, pagesNumber,
            cambiarPagina, cambiarPaginacion, buscarTipoAcceso, nuevoTipoAcceso, editar,
            eliminarTipoAcceso, restaurar
        }
    },
}
</script>
