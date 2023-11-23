import axios from 'axios'
import { ref } from 'vue'
export default function useMenuRole() {
    const menuRoles = ref([])
    const role = ref({})
    const menus = ref([])
    const errors = ref([])
    const respuesta = ref('')

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const listarMenus = async() => {
        errors.value = ''
        try {
            let respuesta = await axios.get('api/obtener-menus/',config)
            menus.value =respuesta.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const listarMenuRoles = async(data) => {//de acuerdo a rol
        errors.value = ''
        menuRoles.value = ''
        role.value = ''
        try {
            let datos = 'role_id='+data.role_id
            let respuesta = await axios.get('api/menu-roles?'+datos,config)
            menuRoles.value =respuesta.data.role.menus
            role.value = respuesta.data.role
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const agregarMenuRole= async(data)=> {
        errors.value = ''
        try {
            let respond = await axios.post('api/menu-role-guardar',data,config)
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data

            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }

    }

    return {
        errors, menuRoles, role, menus, respuesta, listarMenus, listarMenuRoles,
        agregarMenuRole
    }
}
