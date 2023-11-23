import axios from 'axios'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default function useUsuario() {
    const errors = ref([])
    const tipoAcceso = ref({})
    const tipoAccesos = ref([])
    const datoPersona = ref({})
    const taRespuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerTipoAccesos = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
        '&buscar='+data.buscar

        let respuesta = await axios.get('api/tipo-accesos-'+data.show_tipo+'?'+datos,config)
        tipoAccesos.value =respuesta.data
    }

    const obtenerTipoAcceso = async(id) => {
        let respuesta = await axios.get('api/tipo-accesos-mostrar?id='+id,config)
        tipoAcceso.value = respuesta.data
    }

    const listarTipoAccesos = async() => {
        let respuesta = await axios.get('api/tipo-accesos-listar',config)
        tipoAccesos.value = respuesta.data
    }

    const agregarTipoAcceso = async(data) => {
        errors.value = ''
        try {
            let respuesta = await axios.post('api/tipo-accesos',data,config)

            errors.value = ''
            if(respuesta.data.ok==1)
            {
                taRespuesta.value = respuesta.data
            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const actualizarTipoAcceso = async(data) => {
        errors.value = ''
        try {
            let respuesta = await axios.post('api/tipo-accesos-actualizar',data,config)
            errors.value =''
            if(respuesta.data.ok==1){
                taRespuesta.value=respuesta.data
            }

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const eliminarTemporalTipoAcceso = async(id) => {
        const respuesta = await axios.post('api/tipo-accesos-eliminar', {id:id},config)
        if(respuesta.data.ok==1)
        {
            taRespuesta.value = respuesta.data
        }
    }

    const eliminarPermanenteTipoAcceso = async(id) => {
        const respuesta = await axios.post('api/tipo-accesos-eliminar-permanente', {id:id}, config)
        if(respuesta.data.ok==1){
            taRespuesta.value = respuesta.data
        }
    }

    const restaurarTipoAcceso = async(id) => {
        const respuesta = await axios.post('api/tipo-accesos-restaurar', {id:id},config)
        if(respuesta.data.ok==1)
        {
            taRespuesta.value = respuesta.data
        }
    }

    return {
        tipoAccesos, obtenerTipoAccesos, errors, tipoAcceso, agregarTipoAcceso, taRespuesta,
        obtenerTipoAcceso, actualizarTipoAcceso, eliminarTemporalTipoAcceso,
        eliminarPermanenteTipoAcceso, restaurarTipoAcceso, listarTipoAccesos
    }
}
