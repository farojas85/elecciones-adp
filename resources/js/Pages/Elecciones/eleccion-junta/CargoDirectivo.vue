<template>
    <div class="modal fade" id="modal-cargo-directivos">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-cargo-directivos">Cargos Directivos</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-form-label-sm col-md-3 mb-1">Cargo Directivo</label>
                        <div class="col-md-9">
                            <div class="input-group input-group-sm mb-1">
                                <select class="form-control form-control-sm"
                                    v-model="form.cargo_directivo_id">
                                    <option value="">-Seleccionar-</option>
                                    <option  v-for="cargo in cargo_directivos" :key="cargo.id"
                                        :value="cargo.id">
                                        {{ cargo.nombre }}
                                    </option>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success btn"
                                        @click.prevent="agregarCargo">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="thead-dark">
                                        <th colspan="3" class="text-center"> LISTADO CARGOS</th>
                                    </tr>
                                    <tr class="thead-dark">
                                        <th>#</th>
                                        <th>Cargo</th>
                                        <th>..</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="form.cargo_directivos.length==0">
                                        <td class="text-danger text-center table-danger" colspan="4">
                                            -- Cargos no registrados --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(cargo,indice) in form.cargo_directivos" :key="cargo.id">
                                        <td v-text="indice+1"></td>
                                        <td v-text="cargo.nombre"></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs"
                                               @click.prevent="eliminarCargo(cargo.id)">
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
import { toRefs, onMounted, ref } from 'vue'
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

        const cargo_directivo_id = ref('')

        const {
            cargo_directivos, respuesta, errors,
            obtenerCargoDirectivos, agregarCargoDirectivo, eliminarCargoDirectivo
        } = useEleccionJunta()

        const listarCargoDirectivos = async() => {
            await obtenerCargoDirectivos()
        }

        onMounted(() => {
            listarCargoDirectivos()
        })

        const agregarCargo = async() => {

            await agregarCargoDirectivo(form.value)

            if(respuesta.value.ok==1)
            {
                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                cargo_directivo_id.value = ""

                emit('onEleccionJuntas', form.value.id)
            }
        }

        const eliminarCargo = async(id) => {

            form.value.cargo_directivo_id = id

            await eliminarCargoDirectivo(form.value)

            if(respuesta.value.ok==1)
            {
                Toast.fire({
                    icon: 'success',
                    title: respuesta.value.mensaje
                })

                form.value.cargo_directivo_id = ""

                emit('onEleccionJuntas', form.value.id)
            }
        }

        return {
            form, cargo_directivos, cargo_directivo_id,
            agregarCargo, eliminarCargo
        }

    },
}
</script>
