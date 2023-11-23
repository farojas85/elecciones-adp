import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useJuntaDirectiva() {
    const errors = ref([])
    const junta_directiva = ref({})
    const juntas_directivas = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerJuntasDirectivas = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let responded = await axios.get('api/junta-directivas-'+data.show_tipo+'?'+datos,config)
        juntas_directivas.value =responded.data
    }

    const obtenerJuntaDirectiva = async(id) => {
        let responded = await axios.get('api/junta-directivas-mostrar?id='+id,config)
        junta_directiva.value = responded.data
    }

    const agregarJuntaDirectiva = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/junta-directivas',data,config)

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

    const actualizarJuntaDirectiva = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/junta-directivas-actualizar',data,config)
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

    const habilitarJuntaDirectiva = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/junta-directivas-habilitar',{id:id},config)
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

    const inhabilitarJuntaDirectiva = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/junta-directivas-inhabilitar',{id:id},config)
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
        errors, junta_directiva, juntas_directivas, respuesta,
        obtenerJuntasDirectivas, agregarJuntaDirectiva, obtenerJuntaDirectiva,
        actualizarJuntaDirectiva, inhabilitarJuntaDirectiva, habilitarJuntaDirectiva
    }
}
