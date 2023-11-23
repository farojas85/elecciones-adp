import axios from 'axios'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'


export default function usePermiso() {
    const errors = ref('')
    const permisos = ref('')
    const perRespuesta= ref('')
    const permisoc= ref('')
    const router = useRouter()
    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }
    const agregarPermiso = async(data) => {
        errors.value = ''
        try {
            let respuesta = await axios.post('api/permisos',data,config)
            errors.value =''
            if(respuesta.data.ok==1){
                perRespuesta.value=respuesta.data
            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const obtenerPermiso = async(id) => {
        let respuesta = await axios.get('api/permisos-mostrar?id='+id,config)
        permisoc.value = respuesta.data
    }
    const obtenerPermisos = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let respuesta = await axios.get('api/permisos-'+data.show_tipo+'?'+datos,config)
        permisos.value =respuesta.data
    }

    const actualizarPermiso = async(data) => {
        errors.value = ''
        try {
            let respuesta = await axios.post('api/permisos-actualizar',data,config)
            errors.value =''
            if(respuesta.data.ok==1){
                perRespuesta.value=respuesta.data
            }

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const eliminarTemporalPermiso = async(id) => {
        const respuesta = await axios.post('api/permisos-eliminar', {id:id},config)
        if(respuesta.data.ok==1)
        {
            perRespuesta.value = respuesta.data
        }
    }
    const eliminarPermanentePermiso = async(id) => {
        const respuesta = await axios.post('api/permisos-eliminar-permanente', {id:id},config)
        if(respuesta.data.ok==1)
        {
            perRespuesta.value = respuesta.data
        }
    }
    const restaurarPermiso = async(id) => {
        const respuesta = await axios.post('api/permisos-restaurar', {id:id},config)
        if(respuesta.data.ok==1)
        {
            perRespuesta.value = respuesta.data
        }
    }
    return {
        permisos, obtenerPermisos, errors, agregarPermiso, perRespuesta,
        obtenerPermiso, permisoc, actualizarPermiso,eliminarTemporalPermiso,
        eliminarPermanentePermiso, restaurarPermiso

    }

}
