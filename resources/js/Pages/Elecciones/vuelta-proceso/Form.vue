<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-vuelta-proceso">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Vuelta Proceso</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" v-model="form.nombre"
                                :class="{ 'is-invalid' : form.errors.nombre}" placeholder="Ingrese Nombre">
                                <small class="text-danger" v-for="error in form.errors.nombre" :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">Abreviatura</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" v-model="form.abreviatura"
                                :class="{ 'is-invalid' : form.errors.abreviatura}" placeholder="Ingrese Abreviatura">
                                <small class="text-danger" v-for="error in form.errors.abreviatura" :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row" v-if="form.estadoCrud!='nuevo'">
                            <label class="col-form-label col-form-label-sm col-md-3">Estado</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox2" v-model="form.es_activo" :value="form.es_activo">
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
import { toRefs } from 'vue'
import useHelper from '@/Helpers'
import useVueltaProceso from '@/Composables/eleccion/vuelta-procesos'

export default {
    props:{
        form: Object
    },
    emits:['onVueltaProcesos'],
    setup(props,{emit}) {
        const { Toast } = useHelper()
        const { form } = toRefs(props)

        const {
            respuesta, errors,
            agregarVueltaProceso, actualizarVueltaProceso
        } = useVueltaProceso()

        const agregar = async() => {
            errors.value = []
            await agregarVueltaProceso(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-vuelta-proceso').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onVueltaProcesos')
            }
        }

        const actualizar = async() => {
            errors.value = []
            await actualizarVueltaProceso(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-vuelta-proceso').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onVueltaProcesos')
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
            form,
            guardar
        }
    },
}
</script>
