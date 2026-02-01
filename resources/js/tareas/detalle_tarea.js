import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2
import spanish from '../data_tables/spanish.json';


const appTareas = createApp({
    data() {
            return {
                
            }
        },
        mounted(){
        },
        methods: {
            entregarTarea() {
    const id_tarea = $('#id_tarea').val();
    const url_tarea = $('#url_tarea').val();

    // 1. Validación rápida
    if (!url_tarea) {
        Swal.fire('Error', 'Debe ingresar la url para realizar la entrega.', 'error');
        return;
    }

    // 2. Bloqueamos el botón o mostramos un estado de carga (opcional pero recomendado)
    // Esto evita que el usuario haga doble clic mientras Axios responde
    Swal.fire({
        title: 'Enviando...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 3. Envío directo con Axios
    axios.post(`/entregar-tarea/${id_tarea}`, {
        url_tarea: url_tarea
    })
    .then(response => {
        // 4. EL ÚNICO MODAL: Notificación de éxito
        Swal.fire({
            title: '¡Tarea Entregada!',
            text: response.data.message || 'Se ha registrado la entrega correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Cerramos el modal de Bootstrap y recargamos
            $('#modal_entregar_tarea').modal('hide');
            window.location.reload();
        });
    })
    .catch(error => {
        console.error('Error:', error);
        const errorMessage = error.response?.data?.message || 'Hubo un problema al realizar la entrega.';
        Swal.fire('Error', errorMessage, 'error');
    });
}
        }
    });
appTareas.mount('#app_general');
        