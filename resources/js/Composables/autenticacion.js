import axios from "axios"
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default function useAutenticacion() {
    const errors = ref([])

    const config = {
        headers:{
            'Authorization': 'Bearer '+ localStorage.getItem('token-api')
        }
    }

    const loginUsuario = async (data) => {
        errors.value = []

        try {
            const response = await axios.post('api/login',data)

            // if(response.status == 422) {
            //     errors.value = response.data.errors
            // }

            if(response.data.token)
            {
                localStorage.setItem('token-api',response.data.token)
            }

            if(response.data.user)
            {
                localStorage.setItem('user-logged',JSON.stringify(response.data.user) )

                let user = response.data.user

                if(user && user.roles[0].slug== 'mesa')
                {
                    window.location.href = "votacion"
                }
                else {
                    window.location.href="principal"
                }
            }

        } catch (error) {
            if(error.response.status === 422){
                errors.value = error.response.data.errors
            }
        }
    }

    const logoutUsuario = async(id) => {
        const respuesta = await axios.post('api/logout',{id:id},config)

        if(respuesta.data.ok==1)
        {
            localStorage.removeItem('token-api')
            localStorage.removeItem('user-logged')

            window.location.href="/"
            //await router.push({name:'Login'})
        }
    }

    return {
        errors, loginUsuario, logoutUsuario
    }
}
