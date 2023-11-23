import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useMenu() {
    const errors = ref([])
    const menu = ref({})
    const menus = ref([])
    const padres = ref([])
    const datoMenu = ref({})
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerMenus = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar

        let responded = await axios.get('api/menus-'+data.show_tipo+'?'+datos,config)
        menus.value =responded.data
    }

    const obtenerMenu = async(id) => {
        let responded = await axios.get('api/menus-mostrar?id='+id,config)
        menu.value = responded.data
    }

    const obtenerPadres = async() => {
        let responded = await axios.get('api/menus-padres',config)
        padres.value = responded.data
    }

    const agregarMenu = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/menus',data,config)

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

    const actualizarMenu = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/menus-actualizar',data,config)
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

    const eliminarTemporalMenu = async(id) => {
        const respond = await axios.post('api/menus-eliminar', {id:id},config)
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }

    const verificarEnRolMenu = async(id) => {
        const respond = await axios.get('api/menus-verificar-enrol',{params:{id:id}},config)
        if(respond.data)
        {
            respuesta.value = respond.data
        }
    }

    const eliminarPermanenteMenu = async(id) => {
        const respond = await axios.post('api/menus-eliminar-permanente', {id:id}, config)
        if(respond.data.ok==1){
            respuesta.value = respond.data
        }
    }

    const restaurarMenu = async(id) => {
        const respond = await axios.post('api/menus-restaurar', {id:id},config)
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }

    return {
        errors, menus, obtenerMenus, padres, obtenerPadres, respuesta, agregarMenu,
        obtenerMenu, menu, actualizarMenu, eliminarPermanenteMenu, eliminarTemporalMenu,
        restaurarMenu, verificarEnRolMenu
    }
}
