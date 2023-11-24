<script setup>
import { toRefs, onMounted } from 'vue';

import useProcesoElectoral from '@/Composables/proceso/proceso-electoral';

const props = defineProps({
    proceso_electoral: Object
});

const {Swal, Toast} = useHelper();

const { proceso_electoral } = toRefs(props);

const {
    respuesta, errors,
    registrarCandidatoProceso
} = useProcesoElectoral();



</script>
<template>

</template>
