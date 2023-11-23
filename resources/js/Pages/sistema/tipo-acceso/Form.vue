<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-tipo-acceso">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Tipo Acceso</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" v-model="form.nombre"
                                :class="{ 'is-invalid' : errors.nombre}" @keyup="form.slug=slugify(form.nombre)"
                                    placeholder="Ingrese Nombre">
                                <small class="text-danger" v-for="error in errors.nombre" :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">Slug</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" v-model="form.slug"
                                    :class="{ 'is-invalid' : errors.slug}" placeholder="Slug - ruta Amigable">
                                <small class="text-danger" v-for="error in errors.slug"
                                :key="error">{{error }}</small>
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
                        <button class="btn ripple btn-success" type="submit"
                            v-if="form.estadoCrud!='mostrar'">
                            <i class="fas fa-save"></i>
                            {{ (form.estadoCrud=='nuevo') ? 'Guardar' : 'Actualizar' }}
                        </button>
                        <button class="btn btn-danger" data-dismiss="modal" type="button"
                            @click="cerrar">
                            <i class="fa fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { toRefs, onMounted, ref } from 'vue'
import useHelper from '@/Helpers'
import useTipoAcceso from '@/Composables/sistema/tipo-accesos'

export default {
    props:{
        form: Object
    },
    emits:['onTipoAcceso'],
    setup(props,{ emit }) {
        const { form } = toRefs(props)
        const { slugify } = useHelper()
        const { errors, agregarTipoAcceso, taRespuesta, actualizarTipoAcceso } = useTipoAcceso()

        const agregar = async() => {
            await agregarTipoAcceso(form.value)

            if(taRespuesta.value.ok==1){
                $('#modal-tipo-acceso').modal('hide')
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: taRespuesta.value.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                })
                emit('onTipoAcceso')
            }
        }

        const actualizar = async() => {
            await actualizarTipoAcceso(form.value)

            if(taRespuesta.value.ok==1){
                $('#modal-tipo-acceso').modal('hide')
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: taRespuesta.value.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                })
                emit('onTipoAcceso')
            }
        }

        const guardar = () => {
            if(form.value.estadoCrud =='nuevo')
            {
                agregar()
            }
            else if(form.value.estadoCrud == 'editar' )
            {
                actualizar()
            }
        }

        const cerrar = () => {
            $('#modal-tipo-acceso').modal('hide')
            errors.value = []
        }

        return {
            slugify, form, errors, guardar, cerrar
        }
    },
}
</script>
