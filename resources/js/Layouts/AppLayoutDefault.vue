<script setup>
    import { onMounted } from 'vue'
    import PreLoader from '@/Components/partials/PreLoader.vue'
    import NavBar from '@/Components/partials/NavBar.vue'
    import SideBar from '@/Components/partials/SideBar.vue'
    import Footer from '@/Components/partials/Footer.vue'
    import Aside from '@/Components/partials/Aside.vue'
    import useHelper from '@/Helpers'

    const { cargarClasesDefaultLayout } = useHelper()

    onMounted(() => {
        cargarClasesDefaultLayout()
    })
</script>

<template>
    <pre-loader></pre-loader>
    <nav-bar></nav-bar>
    <side-bar></side-bar>
    <div class="content-wrapper">
        <router-view></router-view>
    </div>
    <Footer></Footer>
    <Aside></Aside>
</template>

