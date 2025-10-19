import { createApp } from 'vue'
import swal from 'sweetalert'
import axios from 'axios'

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
        console.log("✅ Vue montado correctamente");
    },
    methods: {
        enviarFormularioInicioSesion() {

            this.cargando = true;

            if( this.verificarCamposInicioSesion() ) {
                this.cargando = false;
                return;
            }

            axios.post('/iniciar-sesion', {
                    correo_usuario: this.correo_usuario,
                    contrasena_usuario: this.contrasena_usuario
                })
                .then( respuestaServidor => {
                    window.location.href = respuestaServidor.data.redireccion
                })
                .catch( errorServidor => {
                    swal({
                        title: "",
                        text: "Al parecer esas credenciales no son correctas",
                        icon: "info",
                        button: "Lo intentaré de nuevo"
                    });
                })
                .finally( () => {
                    this.cargando = false;
                })


        },
        verificarCamposInicioSesion() {

            let errores = false;

            if( this.correo_usuario.trim() === '') {
                this.errores.correo_usuario.estado = true;
                this.correo_usuario = '';
                errores = true;
            }

            if( this.contrasena_usuario.trim() === '') {
                this.errores.contrasena_usuario.estado = true;
                this.contrasena_usuario = '';
                errores = true;
            }

            return errores;
        }
    },
}).mount('#app_inicio');
