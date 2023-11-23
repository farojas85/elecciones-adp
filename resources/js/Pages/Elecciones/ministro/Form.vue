<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modal-ministro">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Ministros</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" >
                                    <div class="card-header bg-info">
                                        <h5 class="card-title">Datos Personales</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3" for="tipo_documento">Tipo de Documento</label>
                                            <div class="col-md-8"
                                                >
                                                <select class="form-control form-control-sm"
                                                    v-model="form.tipo_documento_id"
                                                    :class="{ 'is-invalid' : form.errors.tipo_documento_id}">
                                                    <option value="">-Seleccionar-</option>
                                                    <option  v-for="tipoDoc in tipo_documentos" :key="tipoDoc.id"
                                                        :value="tipoDoc.id" :title="tipoDoc.nombre_largo">
                                                        {{ tipoDoc.nombre_corto}}
                                                    </option>
                                                </select>
                                                <small class="text-danger" v-for="error in form.errors.tipo_documento_id"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3">N&uacute;mero Documento</label>
                                            <div class="col-md-8">
                                                <input type="text" v-model="form.numero_documento"
                                                    class="form-control form-control-sm"
                                                    :class="{ 'is-invalid' : form.errors.numero_documento}"
                                                    maxlength="15"
                                                    @change="obtenerDatoDocumento" @keypress="soloNumeros"
                                                    placeholder="Número Documento Identidad"
                                                    >
                                                <small class="text-danger" v-for="error in form.errors.numero_documento"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3">Nombres</label>
                                            <div class="col-md-8">
                                                <input type="text" v-model="form.nombres"
                                                    class="form-control form-control-sm"
                                                    :class="{ 'is-invalid' : form.errors.nombres}"
                                                    placeholder="Ingrese Nombres" />
                                                <small class="text-danger" v-for="error in form.errors.nombres"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3">Ape. Paterno</label>
                                            <div class="col-md-8">
                                                <input type="text" v-model="form.apellido_paterno"
                                                    class="form-control form-control-sm"
                                                    :class="{ 'is-invalid' : form.errors.apellido_paterno}"
                                                    placeholder="Apellido Paterno"/>
                                                <small class="text-danger" v-for="error in form.errors.apellido_paterno"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3">Ape. Materno</label>
                                            <div class="col-md-8">
                                                <input type="text" v-model="form.apellido_materno"
                                                    class="form-control form-control-sm"
                                                    :class="{ 'is-invalid' : form.errors.apellido_materno}"
                                                    placeholder="Apellido Materno" />
                                                <small class="text-danger" v-for="error in form.errors.apellido_materno"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3">Sexo</label>
                                            <div class="col-md-8 parsley-checkbox"
                                                :class="{ 'is-invalid' : form.errors.sexo_id}">
                                                <select class="form-control form-control-sm"
                                                    v-model="form.sexo_id"
                                                    :class="{ 'is-invalid' : form.errors.sexo_id}">
                                                    <option value="">-Seleccionar-</option>
                                                    <option  v-for="sexo in sexos" :key="sexo.id"
                                                        :value="sexo.id" >
                                                        {{ sexo.nombre}}
                                                    </option>
                                                </select>
                                                <small class="text-danger" v-for="error in form.errors.sexo_id"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3">Direccion</label>
                                            <div class="col-md-8">
                                                <textarea v-model="form.direccion"
                                                    class="form-control form-control-sm"
                                                    :class="{ 'is-invalid' : form.errors.direccion}"
                                                    placeholder="Ingrese Dirección"
                                                    ></textarea>
                                                <small class="text-danger" v-for="error in form.errors.direccion"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-form-label-sm col-md-3">Telefono</label>
                                            <div class="col-md-8">
                                                <input type="text" v-model="form.telefono"
                                                    class="form-control form-control-sm"
                                                    :class="{ 'is-invalid' : form.errors.telefono}"
                                                    maxlength="9"
                                                    @keypress="soloNumeros"
                                                    placeholder="Ingrese Teléfono Celular" />
                                                <small class="text-danger" v-for="error in form.errors.telefono"
                                                    :key="error">{{error }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-success" type="submit"
                            v-if="form.estadoCrud!='mostrar'">
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
import useMinistro from '@/Composables/eleccion/ministros'

export default {
    props:{
        form: Object
    },
    emits:['onMinistros'],
    setup(props, {emit}) {
        const { Swal, Toast, soloNumeros } = useHelper()
        const { form } = toRefs(props)

        const {
            errors, tipo_documentos, sexos, respuesta,
            obtenerTipoDocumentos, obtenerSexos, agregarMinistro,
            actualizarMinistro
        } = useMinistro()

        onMounted(() =>{
            obtenerTipoDocumentos()
            obtenerSexos()
        })

        const agregar = async() => {
            errors.value = []

            await agregarMinistro(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-ministro').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onMinistros')
            }
        }

        const actualizar = async () => {
            errors.value = []

            await actualizarMinistro(form.value)

            if(errors.value)
            {
                form.value.errors = errors.value
            }

            if(respuesta.value.ok==1)
            {
                $('#modal-ministro').modal('hide')

                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                emit('onMinistros')
            }
        }

        const guardar = () => {
            switch(form.value.estadoCrud)
            {
                case 'nuevo': agregar(); break;
                case 'editar': actualizar(); break;
            }
        }

        return {
            form, tipo_documentos, sexos,
            soloNumeros, guardar
        }
    },
}
</script>
