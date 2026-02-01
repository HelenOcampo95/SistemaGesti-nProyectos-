import { createApp } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.css';

// Config global de Axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''

createApp({
    data() {
        return {
        correo_usuario: '',
        contrasena_usuario: '',
        cargando: false,
        errores: {
            correo_usuario: {
            estado: false,
            mensaje: 'El correo electrónico es obligatorio'
            },
            contrasena_usuario: {
            estado: false,
            mensaje: 'La contraseña es obligatoria'
            }
        }
        }
    },
    mounted() {
        console.log('✅ Vue montado correctamente en #app_inicio')
    },
    methods: {
        async enviarFormularioInicioSesion() {
        this.cargando = true     
        // Validación simple
        let errores = false
        if (!this.correo_usuario.trim()) {
            this.errores.correo_usuario.estado = true
            errores = true
        }
        if (!this.contrasena_usuario.trim()) {
            this.errores.contrasena_usuario.estado = true
            errores = true
        }
        if (errores) {
            this.cargando = false
            return
        }

        try {
            const { data } = await axios.post('/iniciar-sesion', {
            correo_usuario: this.correo_usuario,
            contrasena_usuario: this.contrasena_usuario
            }, {
            headers: { Accept: 'application/json' }
            })
            console.log('estoy aqui, pero no puedo')
            window.location.href = data?.redireccion || '/ver-proyecto'
        } catch (error) {
            const mensaje = error.response?.data?.mensaje || 'Credenciales incorrectas'
            await Swal.fire({
            icon: 'error',
            title: 'Ups...',
            text: mensaje
            })
        } finally {
            this.cargando = false
        }
        }
    }
}).mount('#app_inicio')