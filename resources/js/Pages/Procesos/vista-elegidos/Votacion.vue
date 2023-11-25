<script setup>
import { ref, onMounted, computed } from 'vue';
import useHelper from '@/Helpers';
import useVistaElegidos from '@/Composables/proceso/vista-elegidos';

const { Swal, Toast } = useHelper();

const {
    eleccion_junta,
    obtenerEleccionJuntaActual
} = useVistaElegidos();

onMounted(() => {
    obtenerEleccionJuntaActual()
})
</script>
<template>
    <h2 class="text-center display-6">Elección: Periodo {{eleccion_junta.periodo}} - {{eleccion_junta.junta_directiva}}</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">MINISTROS ELEGIDOS</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-valign-middle table-bordered table-sm ">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cargo Directivo</th>
                                    <th class="text-center">Ministro Elegido</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(cargo,index) in eleccion_junta.cargo_directivos" style="font-size: 1.5rem;">
                                    <td></td>
                                    <td v-text="cargo.cargo_directivo"></td>
                                    <td v-text="cargo.candidato" class="text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
