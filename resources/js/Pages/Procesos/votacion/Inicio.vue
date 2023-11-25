<script setup>
import { ref, onMounted, computed } from 'vue';
import useHelper from '@/Helpers';
import useProcesoElectoral from '@/Composables/proceso/proceso-electoral';

const datoSession = JSON.parse(localStorage.getItem('user-logged'));

const { Swal, Toast,soloNumeros } = useHelper();


const {
    proceso_electoral, respuesta, errors,
    obtenerProcesoElectoralActivo,  registrarVotacion
} = useProcesoElectoral();

const numero_candidato = ref('');

onMounted(() => {
    obtenerProcesoElectoralActivo()
})

const registrar = async () => {
    let data = {
        id: proceso_electoral.value.id,
        eleccion_junta_id: proceso_electoral.value.eleccion_junta_id,
        numero_candidato: numero_candidato.value,
        user_id:datoSession.id
    }
    await registrarVotacion(data);
    if(respuesta.value.ok==1)
    {
        Toast.fire({
            icon: 'success',
            title: respuesta.value.mensaje
        })
        numero_candidato.value ="";
    }
}
</script>
<template>
    <h2 class="text-center display-6">Elecciones: Periodo {{ proceso_electoral.periodo }} - {{
        proceso_electoral.junta_directiva }}</h2>
    <h2 class="text-center display-7 font-weight-bold">Cargo: {{ proceso_electoral.cargo_directivo }} - {{
        proceso_electoral.vuelta_proceso }}</h2>

    <div class="row justify-content-center" v-if="proceso_electoral">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">VOTACIÓN</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center">
                            <input type="text" class="form-control form-control-sm text-center"
                                style="font-size: 5rem; height: 10rem;" @keypress="soloNumeros" maxlength="3"
                                v-model="numero_candidato"
                            />
                            <small class="text-danger" v-for="error in errors.numero_candidato" :key="error">{{error }}</small>
                        </div>
                        <div class="col-md-12 mt-1 text-center">
                            <button type="button" class="btn btn-primary" @click="registrar">
                                <i class=""></i> Registrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
