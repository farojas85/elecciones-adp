<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-permiso">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Permisos</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-form-label-sm col-md-3">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-control-sm" v-model="permiso.nombre"
                                        :class="{ 'is-invalid' : errors.nombre}">
                                        <small class="text-danger" v-for="error in errors.nombre"
                                        :key="error">{{error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-form-label-sm col-md-3">Slug</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-control-sm" v-model="permiso.slug"
                                        :class="{ 'is-invalid' : errors.slug}">
                                        <small class="text-danger" v-for="error in errors.slug"
                                        :key="error">{{error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="permiso.estadoCrud!='nuevo'">
                                    <label class="col-form-label col-form-label-sm col-md-3">Estado</label>
                                    <div class="col-md-9">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" v-model="permiso.es_activo" :value="permiso.es_activo">
                                            <label for="customCheckbox2" class="custom-control-label">{{ permiso.es_activo ==1 ? 'Activo' : 'Inactivo' }}</label>
                                        </div>
                                        <small class="text-danger" v-for="error in errors.es_activo"
                                            :key="error">{{error }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-success" type="submit"
                            v-if="permiso.estadoCrud!='mostrar'">
                            <i class="fas fa-save"></i>
                            {{ (permiso.estadoCrud=='nuevo') ? 'Guardar' : 'Actualizar' }}
                        </button>
                        <button class="btn btn-danger" data-dismiss="modal" type="button"
                            @click="cerrar" >
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
    import useHelper from '@/Helpers';
    import usePermiso from '@/Composables/sistema/permisos'
    export default {
         props:{
            permiso: Object
        },
        emits:['onPermisos'],
        setup(props, { emit }) {
            const { permiso } = toRefs(props)
            const { slugify } = useHelper()
            const { errors, agregarPermiso, perRespuesta, actualizarPermiso } = usePermiso()

            const agregar = async() => {
                await agregarPermiso(permiso.value)

                if(perRespuesta.value.ok==1){
                    $('#modal-permiso').modal('hide')
                    Swal.fire({
                        title: "Permisos",
                        text: perRespuesta.value.mensaje,
                        icon: 'success',
                        confirmButtonColor: "#22c03c",
                        confirmButtonText: 'Aceptar',
                    }, function(isConfirm) {
                        if (isConfirm) {
                            emit('onPermisos')
                        }
                    });
                }

            }
            const actualizar =async() => {
                await actualizarPermiso(permiso.value)
                if(perRespuesta.value.ok==1)
                {
                    $('#modal-permiso').modal('hide')
                    Swal.fire({
                        text: "Permisos",
                        title: perRespuesta.value.mensaje,
                        icon: 'success',
                        confirmButtonColor: "#22c03c",
                        confirmButtonText: 'Aceptar',
                    }, function(isConfirm) {
                        if (isConfirm) {
                            emit('onPermisos')
                        }
                    });
                }
            }
            const guardar = () => {
                if(permiso.value.estadoCrud == 'nuevo')
                {
                    agregar()
                } else if(permiso.value.estadoCrud == 'editar')
                {
                    actualizar()
                }
            }

            const cerrar = () => {
                $('#modal-permiso').modal('hide')
                errors.value = []
            }

            return {
                permiso, errors,
                agregar, actualizar, guardar, slugify, cerrar
            }
        },
    }
</script>
