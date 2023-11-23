<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0"><i :class="icon ? icon : icono"></i> {{ titulo }}</h4>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/principal">Home</a></li>
                        <li class="breadcrumb-item active">{{ route.name }}</li>
                        <li class="breadcrumb-item active" v-if="subTitulo">{{ subTitulo }}</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
</template>

<script>
import { useRoute } from 'vue-router'
import { toRefs } from 'vue'
export default {
    props:{
        titulo: String,
        subTitulo: String,
        icon: String,
    },
    setup(props) {
        const { titulo, subTitulo, icon } = toRefs(props)

        const route = useRoute()

        const icono = route.meta.icono

        return {
            icono, titulo, subTitulo, icon, route
        }
    },
};
</script>
