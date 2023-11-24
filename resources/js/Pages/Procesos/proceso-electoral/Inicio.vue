<script setup>
import { onMounted, computed, ref, inject } from 'vue'
import useHelper from '@/Helpers'
import useProcesoElectoral from '@/Composables/proceso/proceso-electoral';
import ProcesoElectoralForm from './Form.vue';

const { defineTitle, Swal,Toast } = useHelper();

const {
    errors, respuesta, procesos_electorales, proceso_electoral,
    obtenerProcesosElectorales, obtenerProcesosElectoral, habilitarProcesoElectoral,
    inhabilitarProcesoElectoral
} = useProcesoElectoral();

const offset = 4

const dato = ref({
    page:'',
    buscar:'',
    show_tipo : 'todos',
    paginacion: 20
})

const form=ref({
    id:'',
    periodo_junta_id : '',
    junta_directiva_id:'',
    eleccion_junta_id:'',
    cargo_directivo_id:'',
    vuelta_proceso_id:'',
    abreviatura: '',
    es_activo : 0,
    finalizado:0,
    estadoCrud:'nuevo',
    errors:[]
});

const listar = async (page=1)  => {
    dato.value.page= page
    await obtenerProcesosElectorales(dato.value)
}

onMounted(() => {
    defineTitle('Procesos Electorales')
    listar()
});

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
    procesos_electorales.value.current_page = pagina
    listar(pagina)
}

const cambiarPaginacion = () => {
    listar()
}

const isActived = () => {
    return procesos_electorales.value.current_page
}

const pagesNumber = () => {
    if(!procesos_electorales.value.to){
        return []
    }

    let from = procesos_electorales.value.current_page - offset

    if(from < 1) from = 1

    let to = from + (offset*2)

    if( to >= procesos_electorales.value.last_page) to = procesos_electorales.value.last_page

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
});

const limpiar = () => {
    form.value.id='';
    form.value.periodo_junta_id='';
    form.value.junta_directiva_id='';
    form.value.eleccion_junta_id = '';
    form.value.cargo_directivo_id="";
    form.value.vuelta_proceso_id="";
    form.value.abreviatura="";
    form.value.estadoCrud='';
    form.value.es_activo=false;
    form.value.finalizado = false;
    form.value.errors = []
}

const nuevo = () => {
    limpiar();
    form.value.estadoCrud='nuevo'
    $('#modal-proceso-electoral-title').html("Nuevo Proceso Electoral")
    $('#modal-proceso-electoral').modal('show')
}

const editar = async(id) => {
    limpiar();
    await obtenerProcesosElectoral(id)

    if(proceso_electoral.value)
    {
        form.value.id =proceso_electoral.value.id;
        form.value.periodo_junta_id =proceso_electoral.value.periodo_junta_id;
        form.value.junta_directiva_id =proceso_electoral.value.junta_directiva_id;
        form.value.eleccion_junta_id =proceso_electoral.value.eleccion_junta_id;
        form.value.cargo_directivo_id =proceso_electoral.value.cargo_directivo_id;
        form.value.vuelta_proceso_id =proceso_electoral.value.vuelta_proceso_id;
        form.value.es_activo = proceso_electoral.value.es_activo == 1 ? true : false
        form.value.finalizado = proceso_electoral.value.finalizado == 1 ? true : false
    }
    form.value.estadoCrud = 'editar';
    $('#modal-proceso-electoral-title').html("Editar Proceso Electoral");
    $('#modal-proceso-electoral').modal('show');
}

const inhabilita = async (id) => {
    await inhabilitarProcesoElectoral(id)
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
        text:'¿Está seguro de inhabilitar el Proceso Electoral',
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
    await habilitarProcesoElectoral(id)
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
        text:'¿Está seguro de habilitar el Proceso Electoral',
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
</script>
<template>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado Procesos Electorales
                <a class="btn btn-danger btn-sm ml-1"
                    @click.prevent="nuevo">
                    <i class="fa fa-plus"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 mb-1">
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
                                    <th colspan="8" class="text-center">Vueltas Proceso {{ dato.show_tipo }}</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Periodo</th>
                                    <th>Junta Directiva</th>
                                    <th>Cargo Directivo</th>
                                    <th>Proceso</th>
                                    <th>Es Activo</th>
                                    <th>Finalizado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="procesos_electorales.total == 0">
                                    <td class="text-danger text-center table-danger" colspan="8">
                                        -- Datos No Registrados --
                                    </td>
                                </tr>
                                <tr v-else
                                    v-for="(proceso,indice) in procesos_electorales.data" :key="proceso.id">
                                    <td > {{ indice + procesos_electorales.from }}</td>
                                    <td v-text="proceso.periodo"></td>
                                    <td v-text="proceso.junta_directiva"></td>
                                    <td v-text="proceso.cargo_directivo"></td>
                                    <td v-text="proceso.vuelta_nombre"></td>
                                    <td class="text-center">
                                        <span v-if="proceso.es_activo==1" class="badge badge-success">ACTIVO</span>
                                        <span v-if="proceso.es_activo==0" class="badge badge-danger">INACTIVO</span>
                                    </td>
                                    <td class="text-center">
                                        <span v-if="proceso.finalizado==1" class="badge badge-success">SI</span>
                                        <span v-if="proceso.finalizado==0" class="badge badge-danger">NO</span>
                                    </td>
                                    <td>
                                        <template v-if="proceso.es_activo==1">
                                            <button class="btn btn-warning btn-xs mr-1"
                                                title="Editar proceso Proceso"
                                                @click.prevent="editar(proceso.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs mr-1"
                                                title="Inhabilitar proceso Proceso"
                                                @click.prevent="inhabilitar(proceso.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <button class="btn btn-success btn-xs mr-1"
                                            title="Habilitar proceso Proceso"
                                            @click.prevent="habilitar(proceso.id)" v-if="proceso.es_activo==0">
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
                    Mostrando <b>{{procesos_electorales.from}}</b> a <b>{{ procesos_electorales.to }}</b> de <b>{{ procesos_electorales.total}}</b> Registros
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="procesos_electorales.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward-fast"></i></span>
                                </a>
                            </li>
                            <li v-if="procesos_electorales.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Página Anterior"
                                    @click.prevent="cambiarPagina(procesos_electorales.current_page - 1)">

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
                            <li v-if="procesos_electorales.current_page < procesos_electorales.last_page" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(procesos_electorales.current_page + 1)">
                                    <span><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="procesos_electorales.current_page <= procesos_electorales.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
                                    @click.prevent="cambiarPagina(procesos_electorales.last_page)"
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
    <ProcesoElectoralForm :form="form" @onListar="listar"></ProcesoElectoralForm>
</template>

