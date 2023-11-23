<template>
    <div class="card" >
        <div class="card-header bg-success">
            <h5 class="card-title">Grados Ministeriales</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-1">
                    <button type="button" class="btn btn-danger btn-sm">
                        <i class="fas fa-plus"></i> añadir Grado Ministerial
                    </button>
                </div>
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Grado</th>
                                <th>Estado</th>
                                <th>..</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="form.grados_ministeriales.length==0">
                                <td class="text-danger text-center table-danger" colspan="4">
                                    --Datos no registrados--
                                </td>
                            </tr>
                            <tr v-else v-for="(grado,indice) in form.grados_ministeriales" :key="grado.id">
                                <td v-text="indice+1"></td>
                                <td v-text="grado.nombre"></td>
                                <td>
                                    <span class="badge badge-success" v-if="grado.es_activo==1">Activo</span>
                                    <span class="badge badge-danger" v-else>Inactivo</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <small class="text-danger" v-for="error in form.errors.grados_ministeriales"
                        :key="error">{{error }}</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    setup() {

    },
}
</script>
