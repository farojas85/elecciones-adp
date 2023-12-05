import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { jsPDF } from 'jspdf'
import dayjs from 'dayjs'
import { es } from 'dayjs/locale/es';

dayjs.locale("es");

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

    const obtenerProcesoElectoralDetalles = async(id) => {
        let responded = await axios.get('api/proceso-electorales-detalles?id='+id,config)

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

    const imprimirActaElectoral = async(id) => {

        await obtenerProcesoElectoralDetalles(id);

        const doc = new jsPDF({ orientation: "p", unit: "mm", format: "A4" });


        let fecha = proceso_electoral.value.fecha;
        // de MMMM de YYYY
        fecha = dayjs(fecha).locale("es").format("DD")+" de "+
                dayjs(fecha).locale("es").format("MMMM")+" de "+
                dayjs(fecha).locale("es").format("YYYY")
        ;

        let candidatos = proceso_electoral.value.candidatos;


        doc.addFont('/fonts/arial-black-normal.ttf','Arial Black','normal')

        doc.addImage('/images/Logo_adp.png','PNG',15,5,14,25);
        doc.setFontSize(12).setFont("times","normal");
        doc.text('ELECCIONES PERIODO '+proceso_electoral.value.periodo,105,10,'center');

        doc.setFontSize(18).setFont("times","bold");
        doc.text(proceso_electoral.value.cargo_directivo+ ' - '+ proceso_electoral.value.vuelta_proceso,105,16,'center');

        doc.setFontSize(24).setFont("Arial Black","normal");
        doc.text('ACTA ELECTORAL',105,24,'center');

        doc.setFontSize(11).setFont("times","normal");
        doc.text('Siendo las ',15,40,'left');
        doc.setFontSize(11).setFont("times","bold");
        doc.text(proceso_electoral.value.hora_inicio,42,40,'center');
        doc.setLineDash([1, 0.5], 0).line(32, 41, 52, 41);
        doc.setFontSize(11).setFont("times","italic");
        doc.text('del '+fecha+", se inició el ACTO DE ESCRUTINIO.",53,40,'left');

        doc.setLineDash([1, 0], 0).setLineWidth(0.2);
        doc.setFillColor(121,121,121);
        doc.rect(15,50,10,7,'DF');
        doc.rect(25,50,145,7,'DF');
        doc.rect(170,50,25,7,'DF');
        // doc.rect(145,60,30,7,'D')

        doc.setTextColor(0,0,0)
        doc.setFontSize(12).setFont("times",'bold');
        doc.text("CANDIDATOS",105,55,'center');
        doc.text("VOTOS",182,55,'center');

        doc.setLineDash([1, 0], 0).setLineWidth(0.2);
        doc.setFillColor(0,0,0);
        let y=57;
        let fila=1;

        doc.setTextColor(0,0,0)
        doc.setFontSize(12).setFont("times",'normal');
        candidatos.forEach(item => {
            //Rectángulos
            doc.rect(15,y,10,8,'D');
            doc.rect(25,y,145,8,'D');
            doc.rect(160,y,10,8,'D');
            doc.rect(170,y,25,8,'D');

            //Textos
            //Fila
            doc.setFontSize(12).setFont("times",'normal');
            doc.text(""+fila,20,y+5.5,'center');
            //Candidato
            doc.setFontSize(14).setFont("times",'normal');
            doc.text(item.candidato,35,y+5.5,'left');
            //Número Candidato
            doc.setFontSize(14).setFont("times","normal");
            doc.text(item.numero_candidato,165,y+5.8,'center')
            //Cantidad Votos
            doc.setFontSize(14).setFont("Arial Black","normal");
            doc.text(""+item.cantidad_votos,182,y+5.8,'center')

            y+=8;
            fila+=1;
        });

        let total_emitidos = parseInt(proceso_electoral.value.votos_validos + proceso_electoral.value.votos_blancos);
        //TOTAL VOTOS VÁLIDOS
        doc.rect(25,y,145,8,'D');
        doc.rect(170,y,25,8,'D');
        doc.setFontSize(14).setFont("times","bold");
        doc.text("TOTAL DE VOTOS VÁLIDOS",35,y+5.8,'left')
        doc.setFontSize(14).setFont("Arial Black","normal");
        doc.text(""+proceso_electoral.value.votos_validos,182,y+5.8,'center')
        //VOTOS BLANCOS
        doc.rect(25,y+8,145,8,'D');
        doc.rect(170,y+8,25,8,'D');
        doc.setFontSize(14).setFont("times","bold");
        doc.text("VOTOS EN BLANCO",35,y+13.8,'left')
        doc.setFontSize(14).setFont("Arial Black","normal");
        doc.text(""+proceso_electoral.value.votos_blancos,182,y+13.8,'center')

        //TOTAL EMITIDOS
        doc.rect(25,y+16,145,8,'D');
        doc.rect(170,y+16,25,8,'D');
        doc.setFontSize(14).setFont("times","bold");
        doc.text("TOTAL DE VOTOS EMITIDOS",35,y+21.8,'left');
        doc.setFontSize(14).setFont("Arial Black","normal");
        doc.text(""+total_emitidos,182,y+21.8,'center');


        doc.setFontSize(11).setFont("times","normal");
        doc.text('Siendo las ',15,y+35,'left');
        doc.setFontSize(11).setFont("times","bold");
        doc.text(proceso_electoral.value.hora_finaliza,42,y+35,'center');
        doc.setLineDash([1, 0.5], 0).line(32, y+36, 52, y+36);
        doc.setFontSize(11).setFont("times","italic");
        doc.text("finalizó el ACTO DE ESCRUTINIO.",53,y+35,'left');


        doc.setLineDash([1, 0], 0).setLineWidth(0.2);

        doc.setLineDash([1, 0], 0).line(15, 270, 55, 270);
        doc.setLineDash([1, 0], 0).line(85, 270, 125, 270);
        doc.setLineDash([1, 0], 0).line(155, 270, 195, 270);

        doc.setFontSize(11).setFont("times","bold");
        doc.text("PRESIDENTE",35,274,'center');
        doc.setFontSize(9).setFont("times","normal");
        doc.text("NOMBRES:",15,280,'left');
        doc.setLineDash([1, 0.4], 0).line(33, 281, 70,281 );
        doc.text("APELLIDOS:",15,285,'left');
        doc.setLineDash([1, 0.4], 0).line(33, 286, 70,286);
        doc.text("DNI:",15,290,'left');
        doc.setLineDash([1, 0.4], 0).line(33, 291, 70,291);

        doc.setFontSize(11).setFont("times","bold");
        doc.text("SECRETARIO",105,274,'center');
        doc.setFontSize(9).setFont("times","normal");
        doc.text("NOMBRES:",85,280,'left');
        doc.setLineDash([1, 0.4], 0).line(103, 281, 140,281 );
        doc.text("APELLIDOS:",85,285,'left');
        doc.setLineDash([1, 0.4], 0).line(103, 286, 140,286);
        doc.text("DNI:",85,290,'left');
        doc.setLineDash([1, 0.4], 0).line(103, 291, 140,291);

        doc.setFontSize(11).setFont("times","bold");
        doc.text("TERCER MIEMBRO",175,274,'center');
        doc.setFontSize(9).setFont("times","normal");
        doc.text("NOMBRES:",155,280,'left');
        doc.setLineDash([1, 0.4], 0).line(173, 281, 205,281 );
        doc.text("APELLIDOS:",155,285,'left');
        doc.setLineDash([1, 0.4], 0).line(173, 286, 205,286);
        doc.text("DNI:",165,290,'left');
        doc.setLineDash([1, 0.4], 0).line(173, 291, 205,291);

        doc.save('ACTA.pdf');
    }

    return {
        errors, respuesta, procesos_electorales, proceso_electoral,
        junta_directivas, periodo_juntas, cargo_directivos, vuelta_procesos,
        obtenerProcesosElectorales, obtenerDatosIniciales, agregarProcesoElectoral,
        obtenerProcesosElectoral, actualizarProcesoElectoral, obtenerProcesoElectoralActivo,
        habilitarProcesoElectoral, inhabilitarProcesoElectoral, registrarCandidatoProceso,
        registrarVotacion,pasarSiguienteVotacion, registroDeGanador, imprimirActaElectoral
    }
}
