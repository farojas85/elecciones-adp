<template>
    <content-header :titulo="titulo" :icon="icon" :subTitulo="subTitulo"></content-header>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Elección Juntas','fa-solid fa-elevator fa-fw')" >
                                <i class="fas fa-elevator"></i> Elección Juntas
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Ministros','fa-solid fa-user-graduate fa-fw')" >
                                <i class="fas fa-user-graduate "></i> Ministros
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Periodo Juntas','fa-regular fa-calendar-minus fa-fw')" >
                                <i class="far fa-calendar-minus"></i> Periodo Juntas
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Vueltas Proceso','fa-solid fa-arrow-up-1-9 fa-fw')" >
                                <i class="fas fa-arrow-up-1-9"></i> Vueltas Proceso
                            </button>
                        </div>
                        <div class="card-body">
                            <perido-junta-view v-if="vista=='Periodo Juntas'"></perido-junta-view>
                            <ministro-view v-else-if="vista=='Ministros'"></ministro-view>
                            <eleccion-junta-view v-else-if="vista == 'Elección Juntas' "></eleccion-junta-view>
                            <vuelta-proceso-view v-else-if="vista=='Vueltas Proceso'"></vuelta-proceso-view>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { ref } from 'vue'
import ContentHeader from '@/Components/partials/ContentHeader.vue'
import PeridoJuntaView from './periodo-junta/Inicio.vue'
import MinistroView from './ministro/Inicio.vue'
import EleccionJuntaView from './eleccion-junta/Inicio.vue'
import VueltaProcesoView from './vuelta-proceso/Inicio.vue'

export default {
    components:{
        ContentHeader, PeridoJuntaView, MinistroView, EleccionJuntaView,
        VueltaProcesoView
    },
    setup() {
        const titulo = ref("Elección Juntas")
        const icon = ref("fa-solid fa-elevator fa-fw")
        const subTitulo = ref("Elección Juntas")
        const vista = ref("Elección Juntas")

        const cambiarVista = (nuevaVista,icono) => {
            vista.value = nuevaVista
            titulo.value = nuevaVista
            icon.value = icono
            subTitulo.value = nuevaVista
        }

        return {
            titulo, icon, subTitulo, vista,
            cambiarVista
        }
    },
}
</script>
