import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useGradoMinisterial() {
    const errors = ref([])
    const grado_ministerial = ref({})
    const grados_ministeriales = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerGradosMinisteriales = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let responded = await axios.get('api/grado-ministeriales-'+data.show_tipo+'?'+datos,config)
        grados_ministeriales.value =responded.data
    }

    const obtenerGradoMinisterial = async(id) => {
        let responded = await axios.get('api/grado-ministeriales-mostrar?id='+id,config)
        grado_ministerial.value = responded.data
    }

    const agregarGradoMinisterial = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/grado-ministeriales',data,config)

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

    const actualizarGradoMinisterial = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/grado-ministeriales-actualizar',data,config)
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

    const habilitarGradoMinisterial = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/grado-ministeriales-habilitar',{id:id},config)
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

    const inhabilitarGradoMinisterial = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/grado-ministeriales-inhabilitar',{id:id},config)
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

    return {
        errors, grado_ministerial, grados_ministeriales, respuesta,
        obtenerGradosMinisteriales, agregarGradoMinisterial, obtenerGradoMinisterial,
        actualizarGradoMinisterial, inhabilitarGradoMinisterial, habilitarGradoMinisterial
    }
}
