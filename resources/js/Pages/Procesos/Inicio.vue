<template>
    <content-header :titulo="titulo" :icon="icon" :subTitulo="subTitulo"></content-header>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Proceso Electoral','fa-solid fa-check-to-slot fa-fw')" >
                                <i class="fas fa-check-to-slot"></i> Proceso Electoral
                            </button>
                            <!-- <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Ministros','fa-solid fa-user-graduate fa-fw')" >
                                <i class="fas fa-user-graduate "></i> Ministros
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Elección Juntas','fa-solid fa-elevator fa-fw')" >
                                <i class="fas fa-elevator"></i> Elección Juntas
                            </button>
                            <button class="btn btn-app bg-primary" @click.prevent="cambiarVista('Vueltas Proceso','fa-solid fa-arrow-up-1-9 fa-fw')" >
                                <i class="fas fa-arrow-up-1-9"></i> Vueltas Proceso
                            </button> -->
                        </div>
                        <div class="card-body">
                            <proceso-electoral-view v-if="vista=='Proceso Electoral'"></proceso-electoral-view>
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
import ProcesoElectoralView from './proceso-electoral/Inicio.vue'
export default {
    components:{
        ContentHeader, ProcesoElectoralView
    },
    setup() {
        const titulo = ref("Proceso Electoral")
        const icon = ref("fa-solid fa-check-to-slot fa-fw")
        const subTitulo = ref("Proceso Electoral")
        const vista = ref("Proceso Electoral")

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
