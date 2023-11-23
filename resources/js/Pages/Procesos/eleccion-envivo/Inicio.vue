<script setup>
import { ref, onMounted } from 'vue';
import useProcesoElectoral from '@/Composables/proceso/proceso-electoral';

const {
    proceso_electoral,
    obtenerProcesoElectoralActivo
} = useProcesoElectoral();

onMounted(() => {
    obtenerProcesoElectoralActivo()
})

</script>
<template>
    <h2 class="text-center display-6">Elecciones: Periodo {{ proceso_electoral.periodo }} - {{ proceso_electoral.junta_directiva }}</h2>
    <h2 class="text-center display-7 font-weight-bold">Cargo:  {{ proceso_electoral.cargo_directivo }} - {{ proceso_electoral.vuelta_proceso }}</h2>

</template>
