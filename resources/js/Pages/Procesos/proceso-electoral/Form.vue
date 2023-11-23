<script setup>
import { toRefs, onMounted } from 'vue';
import useProcesoElectoral from '@/Composables/proceso/proceso-electoral';
import useHelper from '@/Helpers';

const { Toast } = useHelper();

const props = defineProps({
    form: Object
});

const { form } = toRefs(props);

const emit = defineEmits(['onListar']);

const {
    errors, respuesta, periodo_juntas, junta_directivas, cargo_directivos, vuelta_procesos,
    obtenerDatosIniciales, agregarProcesoElectoral, actualizarProcesoElectoral
} = useProcesoElectoral();

onMounted(() => {
    obtenerDatosIniciales();
});

const crud = {
    'nuevo': async() => {
        errors.value = []
        await agregarProcesoElectoral(form.value)

        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok == 1)
        {
            $('#modal-proceso-electoral').modal('hide')

            Toast.fire({
                icon: 'success',
                title: respuesta.value.mensaje
            })

            emit('onListar')
        }
    },
    'editar': async() => {
        errors.value = []
        await actualizarProcesoElectoral(form.value)

        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok == 1)
        {
            $('#modal-proceso-electoral').modal('hide')

            Toast.fire({
                icon: 'success',
                title: respuesta.value.mensaje
            })

            emit('onListar')
        }
    }
}

const guardar = () => {
    crud[form.value.estadoCrud]()
}

</script>
<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-proceso-electoral">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-proceso-electoral-title">Proceso Electiral</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3" for="periodo Junta">Periodo</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-sm"
                                    id="periodo_junta"
                                    v-model="form.periodo_junta_id"
                                    :class="{ 'is-invalid' : form.errors.periodo_junta_id}"
                                    :disabled="form.estadoCrud=='mostrar'">
                                    <option value="">-Seleccionar-</option>
                                    <option  v-for="period in periodo_juntas" :key="period.id"
                                        :value="period.id">
                                        {{ period.anio_inicio+' - '+period.anio_fin }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.periodo_junta_id"
                                    :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3" for="junta_directiva">Junta Directiva</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-sm"
                                    id="junta_directiva"
                                    v-model="form.junta_directiva_id"
                                    :class="{ 'is-invalid' : form.errors.junta_directiva_id}"
                                    :disabled="form.estadoCrud=='mostrar'">
                                    <option value="">-Seleccionar-</option>
                                    <option  v-for="junta in junta_directivas" :key="junta.id"
                                        :value="junta.id">
                                        {{ junta.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.junta_directiva_id"
                                    :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3" for="cargo_directivo">Cargo Directivo</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-sm"
                                    id="cargo_directivo"
                                    v-model="form.cargo_directivo_id"
                                    :class="{ 'is-invalid' : form.errors.cargo_directivo_id}"
                                    :disabled="form.estadoCrud=='mostrar'">
                                    <option value="">-Seleccionar-</option>
                                    <option  v-for="cargo in cargo_directivos" :key="cargo.id"
                                        :value="cargo.id">
                                        {{ cargo.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.cargo_directivo_id"
                                    :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3" for="vuelta_proceso">Vuelta Proceso</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-sm"
                                    id="vuelta_proceso"
                                    v-model="form.vuelta_proceso_id"
                                    :class="{ 'is-invalid' : form.errors.vuelta_proceso_id}"
                                    :disabled="form.estadoCrud=='mostrar'">
                                    <option value="">-Seleccionar-</option>
                                    <option  v-for="vuelta in vuelta_procesos" :key="vuelta.id"
                                        :value="vuelta.id">
                                        {{ vuelta.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.vuelta_proceso_id" :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row" v-if="form.estadoCrud!='nuevo'">
                            <label class="col-form-label col-form-label-sm col-md-3">Estado</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox2" v-model="form.es_activo" :value="form.es_activo">
                                    <label for="customCheckbox2" class="custom-control-label">{{ form.es_activo ==1 ? 'Activo' : 'Inactivo' }}</label>
                                </div>
                                <small class="text-danger" v-for="error in errors.es_activo" :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row" v-if="form.estadoCrud!='nuevo'">
                            <label class="col-form-label col-form-label-sm col-md-3">Finalizado</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox3" v-model="form.finalizado" :value="form.finalizado">
                                    <label for="customCheckbox3" class="custom-control-label">{{ form.finalizado ==1 ? 'Si' : 'No' }}</label>
                                </div>
                                <small class="text-danger" v-for="error in errors.finalizado" :key="error">{{error }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit"
                            v-if="form.estadoCrud!='mostrar'">
                            <i class="fas fa-save"></i>
                            {{ (form.estadoCrud=='nuevo') ? 'Guardar' : 'Actualizar' }}
                        </button>
                        <button class="btn btn-danger" data-dismiss="modal" type="button">
                            <i class="fa fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
