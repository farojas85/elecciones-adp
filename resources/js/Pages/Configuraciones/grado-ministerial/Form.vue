<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-grado-ministerial">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Grado Ministerial</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" v-model="form.nombre"
                                :class="{ 'is-invalid' : errors.nombre}" placeholder="Ingrese Nombre">
                                <small class="text-danger" v-for="error in errors.nombre" :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row" v-if="form.estadoCrud!='nuevo'">
                            <label class="col-form-label col-form-label-sm col-md-3">Estado</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox2" v-model="form.es_activo" :value="form.es_activo">
                                    <label for="customCheckbox2" class="custom-control-label">{{ form.es_activo ==1 ? 'Activo' : 'Inactivo' }}</label>
                                </div>
                                <small class="text-danger" v-for="error in errors.es_activo"
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
import useGradoMinisterial from '@/Composables/configuracion/grado-ministeriales'

export default {
    props:{
        form: Object
    },
    emits:['onGradoMinisteriales'],
    setup(props, { emit }) {
        const { Toast } = useHelper()
        const { form } = toRefs(props)

        const {
            errors, respuesta,
            agregarGradoMinisterial, actualizarGradoMinisterial
        } = useGradoMinisterial()

        const agregar = async() => {
            await agregarGradoMinisterial(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-grado-ministerial').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onGradoMinisteriales')
            }
        }

        const actualizar = async() => {
             await actualizarGradoMinisterial(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-grado-ministerial').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onGradoMinisteriales')
            }
        }

        const guardar = () => {
            switch(form.value.estadoCrud)
            {
                case 'nuevo': agregar();break;
                case 'editar': actualizar();break;
            }
        }

        return {
            form, errors,
            guardar
        }
    },
}
</script>
