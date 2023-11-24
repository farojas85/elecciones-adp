<template>
    <nav class="main-header navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <a href="/eleccion-live" class="navbar-brand">
                <img src="adminlte/dist/img/ADP_128.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-bold">SufragioADP</span>
            </a>
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/principal" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block active">
                        <a href="/eleccion-live" class="nav-link active">
                            <i class="fas fa-eye text-danger"></i>
                            Elección En Vivo
                        </a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <img :src="'images/'+datoSession.foto"  class="img-circle img-sm mr-1"/> {{ datoSession.name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- <span class="dropdown-item dropdown-header">15 Notifications</span> -->
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-id-badge fa-fw mr-2"></i> Mi Perfil
                                <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="" class="dropdown-item" @click.prevent="cerrarSesion">
                                <i class="fas fa-power-off fa-fw mr-2"></i> Cerrar Sesi&oacute;n
                                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
                            </a>
                            <!-- <div class="dropdown-divider"></div> -->
                            <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                            role="button">
                            <i class="fas fa-th-large"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
</template>

<script>
import { watchEffect, ref } from 'vue'
import { useRoute } from 'vue-router'
import useAutenticacion from '@/Composables/autenticacion'

export default {
    setup() {
        const datoSession = JSON.parse(localStorage.getItem('user-logged'))

        const { logoutUsuario } = useAutenticacion()

        const route = useRoute()

        const ruta = String(route.name).toLowerCase()

        const t = ref('')

        const cerrarSesion = async ()  => {
            await logoutUsuario(datoSession.id)
        }


        const idleLogout = () => {
            var t
            window.onload = resetTimer;
            window.onmousemove = resetTimer;
            window.onmousedown = resetTimer;  // catches touchscreen presses as well
            window.ontouchstart = resetTimer; // catches touchscreen swipes as well
            window.onclick = resetTimer;      // catches touchpad clicks as well
            window.onkeypress = resetTimer;
            window.addEventListener('scroll', resetTimer, true); // improved; see comments

            function yourFunction(){
                cerrarSesion()
            }

            function resetTimer() {
                clearTimeout(t);
                t = setTimeout(yourFunction, 120000);  // time is in milliseconds
            }

        }

        watchEffect(() => {
            //idleLogout()
        })

        return {
            datoSession, ruta, cerrarSesion
        }
    },
}
</script>
