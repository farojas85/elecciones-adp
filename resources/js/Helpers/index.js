import { ref, inject } from 'vue'
export default function useHelper() {

    const Swal = inject('Swal')

    const dias = ref([])

    const defineTitle = (title) => {
        let sistema = "Prestamos";
        document.title = title +" | "+sistema
    }

    const soloNumeros = (evt) => {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode

        if((charCode > 31 && (charCode< 48 || charCode > 57)) && charCode !=48 )
        {
            evt.preventDefault()
        } else {
            return true
        }
    }
    const slugify = (text) => {
        return text
        .toString()
        .normalize()
        .toLowerCase()
        .trim()
        .replace(/\s+/g,'-')
        .replace(/[^\w\-]+/g,'')
        .replace(/\-\-+/g, '-')
    }

    const obtenerDias = () => {
        dias.value = [
            { id: 1, nombre: 'Lunes'}, {id: 2, nombre: 'Martes'}, {id: 3, nombre: 'Miércoles'}, {id: 4, nombre: 'Jueves'},{id: 5, nombre: 'Viernes'},
            {id: 6, nombre: 'Sábado'}, {id: 7, nombre: 'Domingo'}
        ];
    }

    const cargarClasesLoginLayout = () => {
        $('body').removeClass("hold-transition sidebar-mini layout-fixed")
        $('body').removeClass("hold-transition layout-top-nav")
        $('body').addClass('login-page')
    }

    const cargarClasesDefaultLayout = () => {
        $('body').removeClass('login-page')
        $('body').removeClass("hold-transition layout-top-nav")
        $('body').addClass("hold-transition sidebar-mini layout-fixed")
    }

    const cargarClasesLiveLayout = () => {
        $('body').removeClass('login-page')
        $('body').removeClass("hold-transition sidebar-mini layout-fixed")
        $('body').addClass('hold-transition layout-top-nav')
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    return {
        dias, Swal, Toast,
        obtenerDias, soloNumeros, defineTitle, slugify, cargarClasesDefaultLayout,
        cargarClasesLoginLayout, cargarClasesLiveLayout
    }
}
