<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-eleccion-junta">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Elección Junta</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3" for="tipo_documento">Periodo Junta</label>
                            <div class="col-md-8"
                                >
                                <select class="form-control form-control-sm"
                                    v-model="form.periodo_junta_id"
                                    :class="{ 'is-invalid' : form.errors.periodo_junta_id}"
                                    :disabled="form.estadoCrud=='mostrar'">
                                    <option value="">-Seleccionar-</option>
                                    <option  v-for="periodo in periodo_juntas" :key="periodo.id"
                                        :value="periodo.id">
                                        {{ periodo.anio_inicio+' - '+periodo.anio_fin}}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.periodo_junta_id"
                                    :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3" for="tipo_documento">Junta Directiva</label>
                            <div class="col-md-8"
                                >
                                <select class="form-control form-control-sm"
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
                            <label class="col-form-label col-form-label-sm col-md-3">Fecha</label>
                            <div class="col-md-8">
                                <input type="date" v-model="form.fecha"
                                    class="form-control form-control-sm"
                                    :class="{ 'is-invalid' : form.errors.fecha}"
                                    :disabled="form.estadoCrud=='mostrar'"
                                    placeholder="Fecha Elección" />
                                <small class="text-danger" v-for="error in form.errors.fecha"
                                    :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">Hora</label>
                            <div class="col-md-8">
                                <input type="time" v-model="form.hora"
                                    class="form-control form-control-sm"
                                    :class="{ 'is-invalid' : form.errors.hora}"
                                    :disabled="form.estadoCrud=='mostrar'"
                                    placeholder="Hora Elección" />
                                <small class="text-danger" v-for="error in form.errors.hora"
                                    :key="error">{{error }}</small>
                            </div>
                        </div>
                         <div class="form-group row" v-if="form.estadoCrud!='nuevo'">
                            <label class="col-form-label col-form-label-sm col-md-3">Estado</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox2"
                                        v-model="form.es_activo" :value="form.es_activo"
                                        :disabled="form.estadoCrud=='mostrar'" />
                                    <label for="customCheckbox2" class="custom-control-label">{{ form.es_activo ==1 ? 'Activo' : 'Inactivo' }}</label>
                                </div>
                                <small class="text-danger" v-for="error in form.errors.es_activo"
                                    :key="error">{{error }}</small>
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

<script>
import { toRefs, onMounted } from 'vue'
import useHelper from '@/Helpers'
import useEleccionJunta from '@/Composables/eleccion/eleccion-juntas'
export default {
    props:{
        form: Object
    },
    emits:['onEleccionJuntas'],
    setup(props, {emit}) {

        const { Swal, Toast } = useHelper()

        const { form } = toRefs(props)

        const {
            periodo_juntas, junta_directivas, errors, respuesta,
            obtenerPeriodoJuntas, obtenerJuntaDirectivas,
            agregarEleccionJunta, actualizarEleccionJunta
        } = useEleccionJunta()

        onMounted(() => {
            obtenerPeriodoJuntas()
            obtenerJuntaDirectivas()
        })

        const agregar = async() => {
            errors.value = []
            await agregarEleccionJunta(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-eleccion-junta').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onEleccionJuntas')
            }

        }

        const actualizar = async() => {
            errors.value = []
            await actualizarEleccionJunta(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-eleccion-junta').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onEleccionJuntas')
            }
        }

        const guardar = () => {

            var crud = {
                'nuevo': agregar,
                'editar': actualizar
            }

            crud[form.value.estadoCrud]()
        }

        return {
            form, periodo_juntas, junta_directivas,
            guardar
        }
    },
}
</script>
