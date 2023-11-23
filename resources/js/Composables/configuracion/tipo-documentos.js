import axios from 'axios'
import { ref } from 'vue'
export default function useTipoDocumento() {
    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const errors = ref([])
    const tipoDocumentos = ref([])


    const listarTipoDocumentos = async() => {
        let respuesta = await axios.get('api/tipo-documentos-listar',config)
        tipoDocumentos.value =respuesta.data
    }

    return {
        errors, tipoDocumentos, listarTipoDocumentos
    }

}
