import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function usePeriodoJunta() {
    const errors = ref([])
    const periodo_junta = ref({})
    const periodos_juntas = ref([])
    const ministros = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerPeriodosJuntas = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let responded = await axios.get('api/periodo-juntas-'+data.show_tipo+'?'+datos,config)
        periodos_juntas.value =responded.data
    }

    const obtenerPeriodoJunta = async(id) => {
        let responded = await axios.get('api/periodo-juntas-mostrar?id='+id,config)
        periodo_junta.value = responded.data
    }

    const agregarPeriodoJunta = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/periodo-juntas',data,config)

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

    const actualizarPeriodoJunta = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/periodo-juntas-actualizar',data,config)
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

    const habilitarPeriodoJunta = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/periodo-juntas-habilitar',{id:id},config)
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

    const inhabilitarPeriodoJunta = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/periodo-juntas-inhabilitar',{id:id},config)
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

    const obtenerCandidatos = async(data) => {
        let responded = await axios.get('api/periodo-juntas-ministros?buscar='+data,config)
        ministros.value =responded.data
    }

    const agregarCandidato = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/periodo-juntas-agregar-candidato',data,config)
            errors.value =''
            respuesta.value=responded.data
        }
        catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }



    return {
        errors, periodo_junta, periodos_juntas, respuesta, ministros,
        obtenerPeriodosJuntas, agregarPeriodoJunta, obtenerPeriodoJunta, actualizarPeriodoJunta,
        inhabilitarPeriodoJunta, habilitarPeriodoJunta, obtenerCandidatos, agregarCandidato
    }
}
