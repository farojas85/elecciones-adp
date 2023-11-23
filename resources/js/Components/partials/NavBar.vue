<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/principal" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/eleccion-live" class="nav-link">
                    <i class="fas fa-eye text-danger"></i>
                    Elección En Vivo
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Buscar..."
                                aria-label="Search" />
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <img :src="'images/'+datoSession.foto"  class="img-circle img-sm mr-1"/>{{ datoSession.name }}
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
            await logoutUsuario()
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
