<template>
    <div class="modal fade" id="modal-candidatos">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-candidatos">Candidatos // Periodo {{ form.anio_inicio+' - '+form.anio_fin }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control"
                                    v-model="buscar_ministro"
                                    placeholder="Ingrese apellidos y nombres Ministro"
                                    @change="buscarMinistro">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-info">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="ministros.length>0">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="thead-dark">
                                        <th>#</th>
                                        <th>Ministro</th>
                                        <th>..</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="ministros.length==0">
                                        <td class="text-danger text-center table-danger" colspan="4">
                                            --Datos no registrados--
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(candidato,indice) in ministros" :key="candidato.id">
                                        <td v-text="indice+1"></td>
                                        <td v-text="candidato.persona.nombres+' '+candidato.persona.apellido_paterno+' '+candidato.persona.apellido_materno"></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-xs"
                                                title="Agregar Candidato"
                                                @click.prevent="seleccionarMinistro(candidato.id)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="thead-dark">
                                        <th colspan="3" class="text-center"> LISTADO CANDIDATOS</th>
                                    </tr>
                                    <tr class="thead-dark">
                                        <th>#</th>
                                        <th>Candidato</th>
                                        <th>..</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="form.candidatos.length==0">
                                        <td class="text-danger text-center table-danger" colspan="4">
                                            -- Ministro(s) no seleccionado(s) --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(candidato,indice) in form.candidatos" :key="candidato.id">
                                        <td v-text="indice+1"></td>
                                        <td v-text="candidato.persona.nombres+' '+candidato.persona.apellido_paterno+' '+candidato.persona.apellido_materno"></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs"
                                                @click.prevent="eliminarMinistro(candidato.id)">
                                                <i class="fas fa-times"></i>
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
</template>

<script>
import { toRefs, ref } from 'vue'
import useHelper from '@/Helpers'
import usePeriodoJunta from '@/Composables/eleccion/periodo-juntas'
export default {
    props:{
        form: Object
    },
    emits:['onPeriodoJuntas'],
    setup(props, {emit}) {
        const { form } = toRefs(props)
        const { Swal, Toast } = useHelper()

        const {
            ministros, respuesta,
            obtenerCandidatos, agregarCandidato, eliminarCandidato
        } = usePeriodoJunta()

        const buscar_ministro = ref("")

        const buscarMinistro = async () => {
            await obtenerCandidatos(buscar_ministro.value)
        }

        const seleccionarMinistro = async (id) => {
            let dato = {
                id: form.value.id,
                ministro_id: id
            }

            await agregarCandidato(dato)

            if(respuesta.value.ok==1)
            {
                 Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })
            }
            if(respuesta.value.ok==2)
            {
                 Toast.fire({
                    icon: 'warning',
                    title: respuesta.value.mensaje
                })
            }

            ministros.value = []
            buscar_ministro.value = ""
            emit('onPeriodoJuntas',form.value.id)
        }

        const eliminarMinistro = async(id) => {
            let dato = {
                id: form.value.id,
                ministro_id: id
            }
            await eliminarCandidato(dato)

            if(respuesta.value.ok==1)
            {
                 Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })
            }

            ministros.value = []
            buscar_ministro.value = ""
            emit('onPeriodoJuntas',form.value.id)
        }


        return {
            form, ministros, buscar_ministro,
            buscarMinistro,seleccionarMinistro, eliminarMinistro
        }
    },
}
</script>
