import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useEleccionJunta() {
    const errors = ref([])
    const proceso_electoral = ref({})
    const procesos_electorales = ref([])
    const eleccion_junta = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerEleccionJuntas = async() => {
        let respond =await axios.get('api/eleccion-live-eleccion-junta-listar',config)
        eleccion_junta.value = respond.data
    }

    return {
        eleccion_junta,
        obtenerEleccionJuntas
    }
}
