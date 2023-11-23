import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useVueltaProceso() {
    const errors = ref([])
    const vuelta_proceso = ref({})
    const vuelta_procesos = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerVueltaProcesos = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let responded = await axios.get('api/vuelta-procesos-'+data.show_tipo+'?'+datos,config)
        vuelta_procesos.value =responded.data
    }

    const obtenerVueltaProceso = async(id) => {
        let responded = await axios.get('api/vuelta-procesos-mostrar?id='+id,config)
        vuelta_proceso.value = responded.data
    }

    const agregarVueltaProceso = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/vuelta-procesos',data,config)

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

    const actualizarVueltaProceso = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/vuelta-procesos-actualizar',data,config)

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

    const habilitarVueltaProceso = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/vuelta-procesos-habilitar',{id:id},config)
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

    const inhabilitarVueltaProceso = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/vuelta-procesos-inhabilitar',{id:id},config)
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
        errors, respuesta, vuelta_proceso, vuelta_procesos,
        obtenerVueltaProcesos, agregarVueltaProceso, obtenerVueltaProceso,
        actualizarVueltaProceso, habilitarVueltaProceso, inhabilitarVueltaProceso
    }
}
