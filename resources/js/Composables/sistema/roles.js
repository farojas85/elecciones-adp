import axios from 'axios'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default function useRole() {
    const errors = ref([])
    const role = ref({})
    const roles = ref([])
    const datoRole = ref({})
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerRoles = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
        '&buscar='+data.buscar
        let responded = await axios.get('api/roles-'+data.show_tipo+'?'+datos,config)
        roles.value =responded.data
    }

    const obtenerRole = async(id) => {
        let responded = await axios.get('api/roles-mostrar?id='+id,config)
        role.value = responded.data
    }

    const listarRoles = async() => {
        let respuesta = await axios.get('api/roles-listar',config)
        roles.value =respuesta.data
    }

    const agregarRole = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/roles',data,config)

            errors.value = ''
            if(responsed.data.ok==1)
            {
                respuesta.value = responsed.data
            }
        }
        catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const actualizarRole = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/roles-actualizar',data,config)
            errors.value =''
            if(responded.data.ok==1){
                respuesta.value=responded.data
            }

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const eliminarTemporalRole = async(id) => {
        const responded = await axios.post('api/roles-eliminar', {id:id},config)
        if(responded.data.ok==1)
        {
            respuesta.value = responded.data
        }
    }

    const eliminarPermanenteRole = async(id) => {
        const responded = await axios.post('api/roles-eliminar-permanente', {id:id}, config)
        if(responded.data.ok==1){
            respuesta.value = responded.data
        }
    }

    const restaurarRole = async(id) => {
        const responded = await axios.post('api/roles-restaurar', {id:id},config)
        if(responded.data.ok==1)
        {
            respuesta.value = responded.data
        }
    }

    return {
        role, roles, errors, datoRole, respuesta, obtenerRoles, agregarRole, obtenerRole,
        actualizarRole, eliminarTemporalRole, eliminarPermanenteRole, restaurarRole,
        listarRoles
    }

}
