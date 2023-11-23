<template>
    <div class="card border border-info">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">Permisos para:... {{ role.nombre}}</h3>
        </div>
        <div class="card-body">
            <div class="tab-content pt-0" id="tab-contenido">
                <div v-for="permiso in permisos" :key="permiso.id" >
                    <label>
                        <input type="checkbox" :value="permiso.id" v-model="role_permisos.permiso_id">
                        {{ permiso.slug }}
                    </label>
                </div>
                <div class="row container-fluid text-center" v-if="role_permisos.modelo &&  role.nombre">
                    <button type="button" class="btn btn-success" @click="guardar">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { toRefs } from 'vue'
    import usePermisoRole from '@/Composables/sistema/permiso-role'

    export default {
         props:{
            permisos        : Object,
            role            : Object,
            role_permisos   : Object
        },
        //emits:['onRole'],
        setup(props) {
            const { role_permisos, role , permisos} = toRefs(props)
            const{agregarRolePermisos, rpRespuesta} = usePermisoRole()

            const agregar = async() => {
                await agregarRolePermisos(role_permisos.value)
                if(rpRespuesta.value.ok==1){
                    Swal.fire({
                        title: "Permisos / Roles",
                        text: rpRespuesta.value.mensaje,
                        icon: 'success',
                        confirmButtonColor: "#22c03c",
                        confirmButtonText: 'Aceptar',
                    }, function(isConfirm) {
                        if (isConfirm) {

                        }
                    });
                }
            }
            const guardar = () =>{
                agregar()
            }
            return {
                role_permisos, guardar,
                agregarRolePermisos, role,
                permisos
            }
        },
    }
</script>
