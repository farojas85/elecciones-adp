import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useProcesoElectoral() {
    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const errors = ref([]);
    const respuesta= ref('');
    const router = useRouter();
    const procesos_electorales = ref({});
    const proceso_electoral = ref([]);
    const periodo_juntas = ref([]);
    const junta_directivas = ref([]);
    const cargo_directivos = ref([]);
    const vuelta_procesos = ref([]);

    const obtenerProcesosElectorales = async(data) => {
        let datos = 'page='+data.page+'&paginacion='+data.paginacion
        let responded = await axios.get('api/proceso-electorales-'+data.show_tipo+'?'+datos,config)

        procesos_electorales.value =responded.data
    }

    const obtenerDatosIniciales = async() => {
        let responded = await axios.get('api/proceso-electorales-datos-iniciales',config)

        let dato = responded.data;
        periodo_juntas.value = dato.periodo_juntas;
        junta_directivas.value = dato.junta_directivas;
        cargo_directivos.value = dato.cargo_directivos;
        vuelta_procesos.value = dato.vuelta_procesos;
    }

    const agregarProcesoElectoral = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/proceso-electorales',data,config)

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

    const obtenerProcesosElectoral = async(data) => {
        let responded = await axios.get('api/proceso-electorales-mostrar?id='+data,config)

        proceso_electoral.value =responded.data
    }

    const actualizarProcesoElectoral = async(data) => {
        errors.value = ''
        try {
            let responsed = await axios.post('api/proceso-electorales-actualizar',data,config)

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

    const obtenerProcesoElectoralActivo = async() => {
        let responded = await axios.get('api/proceso-electorales-activo',config)

        proceso_electoral.value =responded.data
    }

    const habilitarProcesoElectoral = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/proceso-electorales-habilitar',{id:id},config)
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

    const inhabilitarProcesoElectoral = async(id) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/proceso-electorales-inhabilitar',{id:id},config)
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

    const registrarCandidatoProceso = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/proceso-electorales-registrar-candidato-proceso',data,config)
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

    const registrarVotacion = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/proceso-electorales-registro-votacion',data,config)
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

    const pasarSiguienteVotacion = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/proceso-electorales-siguiente-votacion',data,config)
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

    const registroDeGanador = async(data) => {
        errors.value = ''
        try {
            let responded = await axios.post('api/proceso-electorales-registro-ganador',data,config)
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
        errors, respuesta, procesos_electorales, proceso_electoral,
        junta_directivas, periodo_juntas, cargo_directivos, vuelta_procesos,
        obtenerProcesosElectorales, obtenerDatosIniciales, agregarProcesoElectoral,
        obtenerProcesosElectoral, actualizarProcesoElectoral, obtenerProcesoElectoralActivo,
        habilitarProcesoElectoral, inhabilitarProcesoElectoral, registrarCandidatoProceso,
        registrarVotacion,pasarSiguienteVotacion, registroDeGanador
    }
}
