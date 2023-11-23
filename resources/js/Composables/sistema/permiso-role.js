import axios from 'axios'
import { ref } from 'vue'
export default function usePermisoRole() {
    const modelos = ref('')
    const permisos = ref([])
    const rolePermisos = ref([])
    const role=ref({})
    const errors = ref([])
    const rpRespuesta = ref('')
    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }
    const listarModelos = async(data) => {
        let respuesta = await axios.get('api/mostrar-modelos',config)
        modelos.value =respuesta.data
    }
    const listarPermisos = async(data) => {//de acuerdo a roles
        errors.value = ''
        rolePermisos.value = ''
        try {
            let datos = 'role_id='+data.role_id+"&modelo="+data.modelo
            let respuesta = await axios.get('api/permiso-roles?'+datos,config)
            role.value =respuesta.data.role
            rolePermisos.value =respuesta.data.role_permisos
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const listarPermisosModelo = async(data) => {
        let datos = 'role_id='+data.role_id+"&modelo="+data.modelo
                    +'&role_nombre='+data.role_nombre
        let respuesta = await axios.get('api/mostrar-permisos-modelo?'+datos,config)
        permisos.value = respuesta.data
    }
    const agregarRolePermisos = async(data) =>{
        errors.value = ''
        try {
            let respuesta = await axios.post('api/permiso-role-guardar',data,config)
            errors.value =''
            if(respuesta.data.ok==1){
                rpRespuesta.value=respuesta.data
            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    return {
        modelos, listarModelos, listarPermisos,role,
        permisos, errors, listarPermisosModelo, rolePermisos,
        agregarRolePermisos, rpRespuesta
    }
}
