import { createApp } from 'vue'
import axios from 'axios'
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

createApp({
    data() {
        return {
            nombre_usuario: '',
            apellido_usuario: '',
            cedula: '',
            correo_usuario: '',
            contrasena_usuario: '',
            cargando: false
        }
    },
    mounted() {
        
    },
    methods: {

async enviarFormularioRegistro() {
    
    const formulario = document.getElementById('form_registro'); 
    const datos = new FormData(formulario);
            
    try {
        const response = await axios.post('/registrarme', datos); 

        Swal.fire({
            icon: 'success',
            title: '¡Registro Exitoso!',
            text: response.data.mensaje || 'Tu cuenta ha sido creada.',
            confirmButtonText: 'Continuar'
        }).then(() => {
            formulario.reset(); 
        });


    } catch (error) {
        // ...
        if (error.response && error.response.status === 422) {
            Swal.fire({
                icon: 'warning',
                title: 'Verifique los datos',
                text: 'Hay campos que necesitan ser corregidos.',
                confirmButtonText: 'Entendido'
            });
        } else {
            // ...
        }
    }
}
    }
}).mount('#app_registro');
