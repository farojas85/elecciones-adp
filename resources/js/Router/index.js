import { createRouter, createWebHistory } from "vue-router";

import LayoutDefault from '@/Layouts/AppLayoutDefault.vue'
import LayoutLogin from '@/Layouts/AppLoginLayout.vue'
import LayoutLive from '@/Layouts/AppLayoutLive.vue'

import Login from '@/Pages/Auth/Login.vue'
import Principal from '@/Pages/Principal.vue'
import Sistema from '@/Pages/sistema/Inicio.vue'
import Configuracion from '@/Pages/Configuraciones/Inicio.vue'
import Eleccion from '@/Pages/Elecciones/Inicio.vue'
import Proceso from '@/Pages/Procesos/Inicio.vue'
import EleccionVivo from '@/Pages/Procesos/eleccion-envivo/Inicio.vue'
import Votacion from '@/Pages/Procesos/votacion/Inicio.vue';
// import Profile from '@/components/views/perfil/Inicio'
// import Organizacion from '../components/views/organizacion/Inicio'

const routes = [
    {
        path: '/',name: 'Login', component: Login,
        meta: { layout: LayoutLogin}
    },
    {
        path: '/principal', name:'Principal', component: Principal ,
        meta:{ layout: LayoutDefault, icono:'fas fa-tachometer-alt fa-fw'}
    },
    {
        path: '/sistema', name:'Sistema', component: Sistema ,
        meta:{ layout: LayoutDefault, icono: 'fab fa-windows fa-fw'}
    },
    {
        path: '/configuracion-juntas', name:'Configuración Juntas', component: Configuracion,
        meta:{ layout: LayoutDefault, icono: 'fas fa-gears fa-fw'}
    },
    {
        path: '/configuracion-elecciones', name:'Configuración Elecciones', component: Eleccion,
        meta:{ layout: LayoutDefault, icono: 'fas fa-user-gear fa-fw'}
    },
    {
        path: '/proceso-electoral', name:'Proceso Electoral', component: Proceso ,
        meta:{ layout: LayoutDefault}
    },
    {
        path: '/eleccion-live', name:'Elección En Vivo', component: EleccionVivo ,
        meta:{ layout: LayoutLive}
    },
    {
        path: '/votacion', name:'Votación', component: Votacion ,
        meta:{ layout: LayoutLive}
    },
    // {
    //     path: '/organizacion', name:'Organizacion', component: Organizacion ,
    //     meta:{ layout: 'AppLayoutDefault'}
    // }
]

export default createRouter({
    history: createWebHistory(),
    routes
})
