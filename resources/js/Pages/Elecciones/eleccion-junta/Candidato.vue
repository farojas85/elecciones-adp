<script setup>
import { ref, toRefs} from 'vue';
import useHelper from '@/Helpers';
import useEleccionJunta from '@/Composables/eleccion/eleccion-juntas';

const { Toast } = useHelper();

const props = defineProps({
    form: Object
});

const { form } = toRefs(props);

const emit = defineEmits(['onEleccionJuntas']);

const {
    ministros, candidatos, respuesta,
    buscarMinistro, agregarCandidato, eliminarCandidato
} = useEleccionJunta();

const ministro_encontrado = ref(0);

const buscar = ref("");

const encontrarMinistro = async() => {
    ministro_encontrado.value = 0;
    await buscarMinistro(buscar.value);

    ministro_encontrado.value = (ministros.value.length > 0) ? 1 : 2;
}

const agregar = async(id) => {
    form.value.ministro = id
    await agregarCandidato(form.value)

    if(respuesta.value.ok==1)
    {
        Toast.fire({
            icon: 'success',
            title: respuesta.value.mensaje
        })

        buscar.value = "";
        ministros.value = [];
        emit('onEleccionJuntas', form.value.id)
    }
}


</script>
<template>
    <div class="modal fade" id="modal-candidatos">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold" id="modal-title-candidatos">Candidatos</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Buscar</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Ingrese DNI, apellidos, nombres" v-model="buscar"
                                    @change="encontrarMinistro"/>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="ministro_encontrado!= 0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-info">
                                        <tr>
                                            <th>#</th>
                                            <th>Ministo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="ministro_encontrado==2">
                                            <td class="text-center text-danger table-danger" colspan="3">--Datos no encontrados--</td>
                                        </tr>
                                        <tr v-else-if="ministro_encontrado==1" v-for="(minin,index) in ministros">
                                            <td v-text="index+1"></td>
                                            <td v-text="minin.apellidos_nombres"></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-xs"
                                                    @click="agregar(minin.id)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="thead-dark">
                                            <th>Nro.</th>
                                            <th>Candidato</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="form.candidatos.length == 0">
                                            <td class="text-center text-danger table-danger" colspan="3">--Datos no registrados--</td>
                                        </tr>
                                        <tr v-else v-for="(cand,index) in form.candidatos">
                                            <td>{{ cand.numero_candidato }}</td>
                                            <td v-text="cand.candidato"></td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-xs">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
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
    </div>
</template>
