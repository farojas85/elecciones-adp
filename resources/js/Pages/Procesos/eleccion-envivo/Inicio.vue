<script setup>
import { ref, onMounted, computed } from 'vue';
import useHelper from '@/Helpers';
import useProcesoElectoral from '@/Composables/proceso/proceso-electoral';

const { Swal, Toast } = useHelper();

const {
    proceso_electoral, respuesta, errors,
    obtenerProcesoElectoralActivo, registrarCandidatoProceso, pasarSiguienteVotacion,
    registroDeGanador
} = useProcesoElectoral();

onMounted(() => {
    obtenerProcesoElectoralActivo()
})

const registrar = async () => {
    await registrarCandidatoProceso(proceso_electoral.value);
}

const registrarGanador = async() => {
    await registroDeGanador(proceso_electoral.value);
    if(respuesta.value.ok==1)
    {
        Toast.fire({
            icon: 'success',
            title: respuesta.value.mensaje
        });
    }
}

const seleccionarCandidatosEnProceso = async() => {
    let timerInterval;

    Swal.fire({
        title: "Elección de "+proceso_electoral.value.cargo_directivo+' - '+proceso_electoral.value.vuelta_proceso,
        html: "Registrando candidatos al Proceso Electoral",
        timer: 3000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            registrar();
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            if(respuesta.value.ok==1) {
                obtenerProcesoElectoralActivo()
            }
        }
    });
}

const no_procede = ref(null);

const dos_tercios =   computed(() => {
    return Math.round((2*proceso_electoral.value.votos_validos/3)*100/100);
});


const validarVotaciones = () => {

    let i=0;
    let valor = false;

    for(i=0;i< proceso_electoral.value.candidatos.length;i++)
    {
        if(proceso_electoral.value.candidatos[i].cantidad_votos >= dos_tercios.value) {
            valor = true;
            break;
        }
    }

    return valor;
}

const mostrarValidacion = () => {
    no_procede.value=null;
    no_procede.value = validarVotaciones();
    if(no_procede.value===true)
    {
        Swal.fire({
            title: "Felicitaciones",
            html: "El Candidato <b>"+proceso_electoral.value.candidatos[0].candidato+"</b>"+
                    " ha ganado en el cargo de <b>"+proceso_electoral.value.cargo_directivo+"</b>"+
                    " en <b>"+proceso_electoral.value.vuelta_proceso+"</b>",
            icon: "success"
        });
    }
}

const pasaSiguienteVotacion = async() => {
    await pasarSiguienteVotacion(proceso_electoral.value)
    if(respuesta.value.ok==1)
    {
        Toast.fire({
            icon: 'success',
            title: respuesta.value.mensaje
        })
    }
}
</script>
<template>
    <h2 class="text-center display-6">Elecciones: Periodo {{ proceso_electoral.periodo }} - {{
        proceso_electoral.junta_directiva }}</h2>
    <h2 class="text-center display-7 font-weight-bold">Cargo: {{ proceso_electoral.cargo_directivo }} - {{
        proceso_electoral.vuelta_proceso }}</h2>
    <div class="row" v-if="proceso_electoral.cantidad_candidatos == 0">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">SELECCIONAR CANDIDATOS</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 table-responsive">
                            <table class="table table-valign-middle table-bordered table-sm ">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Candidatos</th>
                                        <th class="text-center">
                                            <button type="button" class="btn btn-success" @click="seleccionarCandidatosEnProceso">
                                                <i class="fas fa-check"></i> registrar
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(cand, index) in proceso_electoral.candidatos">
                                        <td v-text="cand.numero_candidato" class="col-md-1 text-center"></td>
                                        <td v-text="cand.candidato"></td>
                                        <td class="text-center">
                                            <input type="checkbox" name="my-checkbox" class="form-control"
                                                v-model="cand.aceptado">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-else-if="proceso_electoral.cantidad_candidatos > 0">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">VOTACIÓN EN PROCESO</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 table-responsive">
                            <table class="table table-sm table-bordered table-valign-middle">
                                <thead class="table-info">
                                    <tr>
                                        <th class="col-md-1">Nro</th>
                                        <th>Candidato</th>
                                        <th class="text-center col-md-1">
                                            Nro. Votos
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(candi,index) in proceso_electoral.candidatos">
                                        <td v-text="candi.numero_candidato" class="text-center"></td>
                                        <td v-text="candi.candidato" ></td>
                                        <td v-text="candi.cantidad_votos" class="text-center"  style="font-size: 1.5rem" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header border-0 bg-info">
                                    <h3 class="card-title">TOTAL VOTOS</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center border-bottom ">
                                        <!-- <p class="text-success text-xl">
                                            <i class="ion ion-ios-refresh-empty"></i>
                                        </p> -->
                                        <p class="d-flex flex-column">
                                            <span class="font-weight-bold" style="font-size: 1.6rem">
                                                {{ proceso_electoral.votos_validos }}
                                            </span>
                                            <span class="text-muted">VOTOS VÁLIDOS</span>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center border-bottom">
                                        <p class="d-flex flex-column">
                                            <span class="font-weight-bold" style="font-size: 1.6rem">
                                                {{ proceso_electoral.votos_emitidos }}
                                            </span>
                                            <span class="text-muted">VOTOS EMITIDOS</span>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center border-bottom">
                                        <p class="d-flex flex-column">
                                            <span class="font-weight-bold" style="font-size: 1.6rem">
                                                {{ proceso_electoral.votos_blancos ?? 0 }}
                                            </span>
                                            <span class="text-muted">VOTOS BLANCOS</span>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column">
                                            <span class="font-weight-bold" style="font-size: 1.6rem">
                                                {{ dos_tercios ?? 0 }}
                                            </span>
                                            <span class="text-muted">2/3 VOTANTES</span>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-success" @click="mostrarValidacion">
                                            <i></i> Validar
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center" v-if="no_procede===false">
                                        <p class="d-flex flex-column">
                                            <span class="text-danger">No Procede Elección !</span>
                                            <span class="font-weight-bold" style="font-size: 1.6rem">
                                                <button class="btn btn-primary" @click="pasaSiguienteVotacion">
                                                    <i></i> Siguiente Votación
                                                </button>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center" v-if="no_procede===true">
                                        <p class="d-flex flex-column">
                                            <span class="text-primary">Candidato alcanzó los 2/3 de votos !</span>
                                            <span class="font-weight-bold" style="font-size: 1.6rem">
                                                <button class="btn btn-primary" @click="registrarGanador">
                                                    <i></i> Registrar ganador
                                                </button>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
