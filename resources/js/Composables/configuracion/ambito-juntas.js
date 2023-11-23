import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useAmbitoJunta() {
    const errors = ref([])
    const ambito_junta = ref({})
    const ambitos_juntas = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerAmbitosJuntas = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let responded = await axios.get('api/ambito-juntas-'+data.show_tipo+'?'+datos,config)
        ambitos_juntas.value =responded.data
    }

    const obtenerAmbitoJunta = async(id) => {
        let responded = await axios.get('api/ambito-juntas-mostrar?id='+id,config)
        ambito_junta.value = responded.data
    }

    const agregarAmbitoJunta = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/ambito-juntas',data,config)

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

    const actualizarAmbitoJunta = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/ambito-juntas-actualizar',data,config)
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

    const habilitarAmbitoJunta = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/ambito-juntas-habilitar',{id:id},config)
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

    const inhabilitarAmbitoJunta = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/ambito-juntas-inhabilitar',{id:id},config)
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
        errors, ambito_junta, ambitos_juntas, respuesta,
        obtenerAmbitosJuntas, agregarAmbitoJunta, obtenerAmbitoJunta,
        actualizarAmbitoJunta, inhabilitarAmbitoJunta, habilitarAmbitoJunta
    }
}
