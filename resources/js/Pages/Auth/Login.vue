<script setup>
    import { reactive } from 'vue'
    import useAutenticacion from '@/Composables/autenticacion'

    const { errors, loginUsuario } = useAutenticacion()

    const usuario = reactive({
        email: '',
        password: ''
    })

    const autenticar = async () => {
        await loginUsuario({...usuario})
    }

</script>

<template>
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><b>Sufragio</b>ADP</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Iniciar Sesi&oacute;n</p>
            <form action="" @submit.prevent="autenticar">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Correo Electrónico"
                                v-model="usuario.email"
                                :class="{ 'is-invalid' : errors.email }"/>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <small class="text-danger" v-for="error in errors.email"
                            :key="error">{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Contraseña"
                                v-model="usuario.password"
                                :class="{ 'is-invalid' : errors.password }" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <small class="text-danger" v-for="error in errors.password"
                            :key="error">{{ error }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Recordarme
                        </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            Acceder
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>
</template>
