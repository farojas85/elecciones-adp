<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Men&uacute;s&nbsp;
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
                <div class="col-md-6 mb-2">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Buscar</span>
                        </div>
                        <input type="text" class="form-control" v-model="dato.buscar"
                            placeholder="Ingrese nombre, slug, padre"
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
                                    <th colspan="7" class="text-center"> Men&uacute;s - {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th class="text-center">Icono</th>
                                    <th class="text-center">Padre</th>
                                    <th class="text-center">Es Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="menus.total == 0">
                                    <td class="text-danger text-center" colspan="7">
                                        -- Datos No Registrados - Tabla Vacía --
                                    </td>
                                </tr>
                                <tr v-else v-for="(menu,index) in menus.data" :key="menu.id">
                                    <td class="text-center">{{ index + menus.from }}</td>
                                    <td>{{ menu.nombre }}</td>
                                    <td>{{ menu.slug }}</td>
                                    <td class="text-center">
                                        <i :class="menu.icono"></i>
                                    </td>
                                    <td class="text-center">
                                        <span v-if="menu.padre">
                                            {{ menu.padre.nombre}}
                                        </span>
                                        <span v-else>
                                            --
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success" v-if="menu.es_activo==1">Activo</span>
                                        <span class="badge bg-secondary" v-else>Inactivo</span>
                                    </td>
                                    <td>
                                        <template v-if="menu.deleted_at == null">
                                            <button class="btn btn-warning btn-sm mr-1" title="Editar Rol" @click.prevent="editar(menu.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm mr-1" title="Enviar a Papelera" @click.prevent="eliminar(menu.id, 'Temporal')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button class="btn bg-indigo btn-sm mr-1" title="Restaurar" @click.prevent="restaurar(menu.id)">
                                                <i class="fas fa-trash-restore-alt"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" title="Eliminar Permanente" @click.prevent="eliminar(menu.id, 'Permanente')">
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
                    Mostrando <b>{{menus.from}}</b> a <b>{{ menus.to }}</b> de <b>{{ menus.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="menus.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">

                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="menus.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(menus.current_page - 1)">

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
                            <li v-if="menus.current_page < menus.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(menus.current_page + 1)">
                                    <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="menus.current_page <= menus.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(menus.last_page)"
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

    <MenuForm :form="form" @onMenus="listar" />
</template>

<script>
import { onMounted, computed, ref } from 'vue'
import useHelper from '@/Helpers'
import useMenu from '@/Composables/sistema/menus'
import MenuForm from './Form.vue'

export default {
    components:{
        MenuForm
    },
    setup() {
        const { defineTitle } = useHelper()

        const {
            errors, menus, obtenerMenus, obtenerMenu, menu, eliminarPermanenteMenu,
            eliminarTemporalMenu, restaurarMenu, respuesta, verificarEnRolMenu
        } = useMenu()

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
            icono : '',
            padre_id : '',
            orden : '',
            es_activo : '1',
            estadoCrud:'nuevo'
        })

        const listar = async(page=1) => {
            dato.value.page = page
            await obtenerMenus(dato.value)
        }

        const getResults = () => {
            listar(menus.value.current_page)
        }

        onMounted(() => {
            defineTitle('Menús')
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

        const cambiarPagina = (pagina) =>{
            menus.value.current_page = pagina
            listar(pagina)
        }

        //Devuelve la pagina actual
        const isActived = () => {
            return menus.value.current_page
        }

        const pagesNumber = () => {
            if(!menus.value.to){
                return []
            }

            let from = menus.value.current_page - offset

            if(from < 1) from = 1

            let to = from + (offset*2)

            if( to >= menus.value.last_page) to = menus.value.last_page

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

        const buscar = async(event) => {
            dato.value.buscar = event.target.value
            listar()
        }

        const limpiar = () =>{
            form.value.id= ""
            form.value.nombre = ""
            form.value.slug= ""
            form.value.icono  = ""
            form.value.padre_id = ""
            form.value.es_activo= 1
        }

        const nuevo = () => {
            limpiar()
            form.value.estadoCrud = 'nuevo'
            $('.modal-title').html('Nuevo Menú')
            $('#modal-menu').modal('show')
        }

        const obtenerDatosMenu= async(id) => {
            await obtenerMenu(id)
            form.value.id = menu.value.id
            form.value.nombre= menu.value.nombre
            form.value.slug= menu.value.slug
            form.value.icono = menu.value.icono
            form.value.padre_id = (menu.value.padre_id) ? menu.value.padre_id : ''
            form.value.es_activo= (menu.value.es_activo == 1) ? true : false
        }

        const editar = (id) => {
            limpiar()
            obtenerDatosMenu(id)
            form.value.estadoCrud ='editar'
            $('.modal-title').html('Editar Menú')
            $('#modal-menu').modal('show')
        }

        const eliminarTemporal = async(id) => {
                await eliminarTemporalMenu(id)
                if(respuesta.value.ok==1)
                {
                    Swal.fire(
                        'Menús',
                        respuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(menus.value.current_page)
                }
            }

            const verificarMenuEnrol = async(id) => {
                await verificarEnRolMenu(id)

                if(respuesta.value.menus_count >0 || respuesta.value.roles_count > 0)
                {
                    Swal.fire({
                        title: "Menús",
                        text: "El Menú esta asignado a algún rol y/o submenú",
                        icon: "warning",
                        confirmButtonColor: "#28a745",
                        confirmButtonText: "Aceptar",
                    }).then((result) => {

                    });

                } else {
                    eliminarPermanente(id)
                }
            }

            const eliminarPermanente = async(id) => {

                await eliminarPermanenteMenu(id)
                if(respuesta.value.ok==1)
                {
                    Swal.fire(
                        'Menús',
                        respuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(menus.value.current_page)
                }
            }

            const eliminar = (id, tipo) => {
                Swal.fire({
                    title: "Menús",
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
                            verificarMenuEnrol(id)
                        }
                    }
                });
            }

            const restauraMenu = async(id) => {
                await restaurarMenu(id)

                if(respuesta.value.ok==1)
                {
                    Swal.fire(
                        'Menús',
                        respuesta.value.mensaje,
                        'success'
                    )

                    cambiarPagina(menus.value.current_page)
                }
            }

            const restaurar = (id) => {
                Swal.fire({
                    title: "Menús",
                    text: "¿Estás seguro de Restaurar el Menú?",
                    icon: "question",
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "Si",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    cancelButtonColor:'#c82333'
                }).then((result) => {
                    if(result.isConfirmed) {
                        restauraMenu(id)
                    }
                });
            }


        return {
            dato, form, menus, obtenerMenus, listar, getResults, cambiarPaginacion,
            mostrarHabilitados, mostrarEliminados, mostrarTodos, cambiarPagina,
            isActived, pagesNumber, buscar, nuevo, errors, editar, eliminar,
            restaurar
        }
    },
}
</script>
