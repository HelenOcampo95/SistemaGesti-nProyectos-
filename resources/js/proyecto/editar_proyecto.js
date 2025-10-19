import { createApp } from "vue/dist/vue.esm-bundler";
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2

const appProyectos = createApp({
    data() {
        return {
        
        }
    },
    

    mounted() {
    
    },
    methods: {
        actualizarProyecto() {
    let id_proyecto = document.getElementById('id_proyecto').value;

    const formData = new FormData(document.getElementById('formulario_editar_proyecto'));
    formData.append('id_proyecto', id_proyecto);

        axios.post('/actualizar-proyecto', formData)
            .then(res => {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'La categoria fue actualizada correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.reload(); 
                });

                $('#modal_editar_proyecto').modal('hide');
                $('#formulario_editar_proyecto')[0].reset();
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    Swal.fire({
                        title: 'Hace falta información',
                        text: 'Por favor completa todos los campos requeridos',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }

                Swal.fire({
                    title: '¡Vaya!',
                    text: 'Ocurrió un error, contacta soporte',
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                });
            });
    }

    }

});
appProyectos.mount('#app_general');