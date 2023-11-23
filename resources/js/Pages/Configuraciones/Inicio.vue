<template>
    <content-header :titulo="titulo" :icon="icon" :subTitulo="subTitulo"></content-header>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Juntas Directivas','fa-solid fa-chess fa-fw')" >
                                <i class="fas fa-chess"></i> Juntas Directivas
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Grados Ministeriales','fa-solid fa-graduation-cap fa-fw')" >
                                <i class="fas fa-graduation-cap"></i> Grados Ministeriales
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Ámbitos Juntas','fa-solid fa-compass fa-fw')" >
                                <i class="fas fa-compass"></i> Ámbitos Juntas
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Cargos Directivos','fa-solid fa-clipboard-user fa-fw')" >
                                <i class="fas fa-clipboard-user"></i> Cargos Directivos
                            </button>
                        </div>
                        <div class="card-body">
                            <grado-ministerial-view v-if="vista=='Grados Ministeriales'"></grado-ministerial-view>
                            <junta-directiva-view v-else-if="vista=='Juntas Directivas'"></junta-directiva-view>
                            <cargo-directivo-view v-else-if="vista == 'Cargos Directivos' "></cargo-directivo-view>
                            <ambito-junta-view v-else-if="vista == 'Ámbitos Juntas'"></ambito-junta-view>
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
import GradoMinisterialView from './grado-ministerial/Inicio.vue'
import AmbitoJuntaView from './ambito-junta/Inicio.vue'
import CargoDirectivoView from './cargo-directivo/Inicio.vue'
import JuntaDirectivaView from './junta-directiva/Inicio.vue'

export default {
    components:{
        ContentHeader, GradoMinisterialView, AmbitoJuntaView,
        JuntaDirectivaView, CargoDirectivoView
    },
    setup() {
        const titulo = ref("Juntas Directivas")
        const icon = ref("fa-solid fa-chess fa-fw")
        const subTitulo = ref("Juntas Directivas")
        const vista = ref("Juntas Directivas")

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
