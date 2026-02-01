import { createApp } from 'vue';
import axios from "axios";
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.css';

const app = createApp({
    methods: {
        async enviarFormularioRegistro() {
        const form = document.getElementById('form_registro');
        const formData = new FormData(form);

        try {
            const { data } = await axios.post('/registrarme', formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
            });

            await Swal.fire({
            icon: 'success',
            title: '¡Listo!',
            text: data?.message ?? 'El usuario se ha creado correctamente',
            });

            // Redirige a inicio (o dashboard)
            window.location.href = '/';
        } catch (error) {
            if (error.response?.status === 422) {
            // Errores de validación del back
            const errores = error.response.data.errors || {};
            const lista = Object.values(errores).flat().join('\n');
            Swal.fire({ icon: 'error', title: 'Revisa los datos', text: lista || 'Datos inválidos' });
            return;
            }
            Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo registrar el usuario.' });
        }
        }
    }
    });

app.mount('#app_registro');