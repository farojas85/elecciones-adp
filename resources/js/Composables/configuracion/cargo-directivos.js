import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useCargoDirectivo() {
    const errors = ref([])
    const cargo_directivo = ref({})
    const cargos_directivos = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerCargosDirectivos = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let responded = await axios.get('api/cargo-directivos-'+data.show_tipo+'?'+datos,config)
        cargos_directivos.value =responded.data
    }

    const obtenerCargoDirectivo = async(id) => {
        let responded = await axios.get('api/cargo-directivos-mostrar?id='+id,config)
        cargo_directivo.value = responded.data
    }

    const agregarCargoDirectivo = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/cargo-directivos',data,config)

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

    const actualizarCargoDirectivo = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/cargo-directivos-actualizar',data,config)
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

    const habilitarCargoDirectivo = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/cargo-directivos-habilitar',{id:id},config)
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

    const inhabilitarCargoDirectivo = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/cargo-directivos-inhabilitar',{id:id},config)
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
        errors, cargo_directivo, cargos_directivos, respuesta,
        obtenerCargosDirectivos, agregarCargoDirectivo, obtenerCargoDirectivo,
        actualizarCargoDirectivo, inhabilitarCargoDirectivo, habilitarCargoDirectivo
    }
}
