<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/principal" class="brand-link">
            <img src="adminlte/dist/img/ADP_128.jpg" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: 0.8" />
            <span class="brand-text font-weight-bold">SufragioADP</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img class="img-circle elevation-2" alt="User Image"
                        :src="'images/'+datoSession.foto" />
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ datoSession.name }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <!-- <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input
                        class="form-control form-control-sidebar"
                        type="search"
                        placeholder="Buscar..."
                        aria-label="Search"
                    />
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div> -->

            <!-- Sidebar Menu -->
            <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview" role="menu" data-accordion="false" >
                    <li class="nav-header">MEN&Uacute; PRINCIPAL</li>
                    <li class="nav-item" v-for="menu in menus" :key="menu.id">
                        <a :href="menu.slug" class="nav-link" :class="{ 'active': menu.slug == ruta }">
                            <i class="nav-icon" :class="menu.icono"></i>
                            <p> {{ menu.nombre }} </p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
import { inject } from 'vue'
import { useRoute } from 'vue-router'

export default {
    setup() {
        const datoSession = JSON.parse(localStorage.getItem('user-logged'))

        const route = useRoute()

        const menus = inject('auth').menus()
        //const menus = []

        const ruta = (String(route.path).toLowerCase()).substring(1)

        return {
            datoSession, menus, ruta
        }
    },
};
</script>
