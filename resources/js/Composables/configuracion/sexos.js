import axios from 'axios'
import { ref } from 'vue'
export default function useSexo() {
    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const errors = ref([])
    const sexos = ref([])


    const listarSexos = async() => {
        let respuesta = await axios.get('api/sexos-listar',config)
        sexos.value =respuesta.data
    }

    return {
        errors, sexos, listarSexos
    }

}
