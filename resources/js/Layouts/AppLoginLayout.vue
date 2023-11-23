<template>
    <div class="login-page">
        <div class="login-box">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { onMounted } from 'vue'
import useHelper from '@/Helpers'
export default {
    setup() {
        const { cargarClasesLoginLayout } = useHelper()
        onMounted(() => {
            cargarClasesLoginLayout()
        })
    },
}
</script>
