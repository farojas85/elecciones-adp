<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-menu">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Men&uacute;s</h6>
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
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">&Iacute;cono</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" v-model="form.icono"
                                    :class="{ 'is-invalid' : errors.icono}" placeholder="Ingrese Ícono">
                                <small class="text-danger" v-for="error in errors.icono"
                                :key="error">{{error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-sm col-md-3">Padre</label>
                            <div class="col-md-9">
                                <select class="form-control form-control-sm" v-model="form.padre_id"
                                    :class="{ 'is-invalid' : errors.padre_id}">
                                    <option value="">-Seleccionar</option>
                                    <option v-for="padre in padres" :key="padre.id" :value="padre.id">
                                        {{ padre.nombre}}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in errors.padre_id"
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
import useMenu from '@/Composables/sistema/menus'
// import useRole from '../../../../composables/sistema/roles'
// import useTipoAcceso from '../../../../composables/sistema/tipo-accesos'
export default {
    props:{
        form: Object
    },
    emits:['onMenus'],
    setup(props,{emit}) {
        const { form } = toRefs(props)
        const { slugify } = useHelper()
        const {
            errors, padres, obtenerPadres, respuesta, agregarMenu, actualizarMenu
        } = useMenu()

        const listarPadres = async() => {
            await obtenerPadres()
        }

        onMounted( () => {
            listarPadres()
        })

        const agregar = async() => {
            await agregarMenu(form.value)

            if(respuesta.value.ok==1){
                $('#modal-menu').modal('hide')
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: respuesta.value.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                })
                emit('onMenus')
            }
        }

        const actualizar = async() => {
            await actualizarMenu(form.value)

            if(respuesta.value.ok==1){
                $('#modal-menu').modal('hide')
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: respuesta.value.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                })
                emit('onMenus')
            }
        }

        const guardar = () => {
            switch(form.value.estadoCrud)
            {
                case 'nuevo': agregar();
                case 'editar': actualizar();
            }
        }

        const cerrar = () => {
            $('#modal-menu').modal('hide')
            errors.value = []
        }

        return {
            slugify, form, padres, obtenerPadres, errors, guardar, actualizar, cerrar, respuesta
        }
    },
}
</script>
