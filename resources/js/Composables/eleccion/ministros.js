import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useMinistro() {
    const errors = ref([])
    const ministro = ref({})
    const ministros = ref([])
    const tipo_documentos = ref([])
    const sexos = ref([])
    const respuesta= ref('')
    const router = useRouter()

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerMinistros = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion+
                    '&buscar='+data.buscar
        let responded = await axios.get('api/ministros-'+data.show_tipo+'?'+datos,config)
        ministros.value =responded.data
    }

    const obtenerTipoDocumentos = async(data) => {
        let responded = await axios.get('api/tipo-documentos-listar',config)
        tipo_documentos.value =responded.data
    }

    const obtenerSexos = async(data) => {
        let responded = await axios.get('api/sexos-listar',config)
        sexos.value =responded.data
    }

    const obtenerMinistro = async(id) => {
        let responded = await axios.get('api/ministros-mostrar?id='+id,config)
        ministro.value = responded.data
    }


    const agregarMinistro = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/ministros',data,config)

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

    const actualizarMinistro = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/ministros-actualizar',data,config)

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

    const habilitarMinistro = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/ministros-habilitar',{id:id},config)
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

    const inhabilitarMinistro = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/ministros-inhabilitar',{id:id},config)
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
        errors, ministro, ministros, respuesta, tipo_documentos,sexos,
        obtenerMinistros, obtenerTipoDocumentos, obtenerSexos, agregarMinistro,
        obtenerMinistro, actualizarMinistro, habilitarMinistro, inhabilitarMinistro
    }



}
