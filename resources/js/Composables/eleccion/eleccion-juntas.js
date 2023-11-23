import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useEleccionJunta() {
    const errors = ref([]);
    const eleccion_junta = ref({});
    const elecciones_juntas = ref([]);
    const periodo_juntas = ref([]);
    const junta_directivas = ref([]);
    const cargo_directivos = ref([]);
    const respuesta= ref('');
    const router = useRouter();
    const candidatos = ref([]);
    const ministros = ref([]);

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const obtenerEleccionJuntas = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion
        let responded = await axios.get('api/eleccion-juntas-'+data.show_tipo+'?'+datos,config)
        elecciones_juntas.value =responded.data
    }

    const obtenerEleccionJunta = async(id) => {
        let responded = await axios.get('api/eleccion-juntas-mostrar?id='+id,config)
        eleccion_junta.value = responded.data
    }

    const obtenerPeriodoJuntas = async(data) => {
        let responded = await axios.get('api/periodo-juntas-listar',config)
        periodo_juntas.value =responded.data
    }

    const obtenerCargoDirectivos = async(data) => {
        let responded = await axios.get('api/cargo-directivos-listar',config)
        cargo_directivos.value =responded.data
    }

    const obtenerJuntaDirectivas = async(data) => {
        let responded = await axios.get('api/junta-directivas-listar',config)
        junta_directivas.value =responded.data
    }

    const agregarEleccionJunta = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/eleccion-juntas',data,config)

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

    const actualizarEleccionJunta = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/eleccion-juntas-actualizar',data,config)

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

    const habilitarEleccionJunta = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/eleccion-juntas-habilitar',{id:id},config)
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

    const inhabilitarEleccionJunta = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/eleccion-juntas-inhabilitar',{id:id},config)
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

    const agregarCargoDirectivo = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/eleccion-juntas-agregar-cargo-directivo',data,config)
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

    const eliminarCargoDirectivo = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/eleccion-juntas-eliminar-cargo-directivo',data,config)
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

    const agregarCandidato = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/eleccion-juntas-agregar-candidato',data,config)
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

    const eliminarCandidato = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/eleccion-juntas-eliminar-candidato',data,config)
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


    const obtenerCandidatos = async(data) => {
        let responded = await axios.get('api/eleccion-juntas-candidatos?id='+data,config)
        // console.log(responded.data)
        candidatos.value =responded.data
    }

    const buscarMinistro = async(data) => {
        let responded = await axios.get('api/ministros-buscar?buscar='+data,config)
        ministros.value = responded.data
    }

    return {
        errors, eleccion_junta, elecciones_juntas, respuesta, periodo_juntas,
        junta_directivas, cargo_directivos, candidatos, ministros,
        obtenerEleccionJuntas, obtenerPeriodoJuntas, obtenerJuntaDirectivas,
        agregarEleccionJunta, obtenerEleccionJunta, actualizarEleccionJunta,
        inhabilitarEleccionJunta, habilitarEleccionJunta, obtenerCargoDirectivos,
        agregarCargoDirectivo, eliminarCargoDirectivo, obtenerCandidatos,
        buscarMinistro, agregarCandidato, eliminarCandidato
    }
}
