import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useVistaElegidos() {
    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const errors = ref([]);
    const respuesta= ref('');
    const router = useRouter();
    const eleccion_junta = ref({});

    const obtenerEleccionJuntaActual = async(data) => {

        let responded = await axios.get('api/eleccion-juntas-actual-elejidos',config)

        eleccion_junta.value =responded.data
    }

    return {
        errors, respuesta, eleccion_junta,
        obtenerEleccionJuntaActual
    }

}
