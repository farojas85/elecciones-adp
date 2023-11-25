<script setup>
import { onMounted } from 'vue'
import NavBarLive from '@/Components/partials/NavBarMesa.vue'
import Footer from '@/Components/partials/Footer.vue'
// import Aside from '@/Components/partials/Aside.vue'
import useHelper from '@/Helpers'

const { cargarClasesLiveLayout } = useHelper()

onMounted(() => {
    cargarClasesLiveLayout()
})

</script>
<template>
    <NavBarLive></NavBarLive>
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
    </div>
    <!-- <Aside />-->
    <Footer></Footer>
</template>
