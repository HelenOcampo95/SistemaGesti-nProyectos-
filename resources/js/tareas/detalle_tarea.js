import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2
import spanish from '../data_tables/spanish.json';


const appTareas = createApp({
    data() {
        return {
            mostrarFormVersion: false, // Por defecto oculto
            nuevaVersion: {
                tag: '',
                descripcion_cambios: '',
                archivo: null,
                urlTarea: ''
            },
            
            limites: {
                urlTarea: 100,
                tag: 20,
                descripcion_cambios:45
            }
        }
    },
    mounted(){
        
    },
    computed: {
        excedidos(){
            return {
                url: this.nuevaVersion.urlTarea.length >= this.limites.urlTarea,
                version: this.nuevaVersion.tag.length  >= this.limites.tag,
                descripcion: this.nuevaVersion.descripcion_cambios.length >= this.limites.descripcion_cambios
            }
        }
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
                if (this.mostrarFormVersion) {
                    if (!this.nuevaVersion.tag || !this.nuevaVersion.descripcion_cambios) {
                        Swal.fire('Atención', 'Si activaste "Registrar versión", debes llenar el tag y la descripción.', 'warning');
                        return;
                    }
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
                url_tarea: url_tarea,
                "es_version": this.mostrarFormVersion, // <--- Laravel recibirá esto
                "tag": this.nuevaVersion.tag,
                "descripcion_cambios": this.nuevaVersion.descripcion_cambios
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
        },

        calificarTarea(){
            const id_tarea = $('#id_tarea').val();
            
            const estado = $('#estado_tarea').val();
            const avance = $('#porcentaje_avance').val();
            const observaciones = $('#observaciones_docente').val();
            
            if (!estado || !avance || !observaciones.trim()) {
                Swal.fire({
                    title: '¡Atención!',
                    text: 'Todos los campos son obligatorios',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            axios.post(`/calificar-tarea/${id_tarea}`, {
                estado_tarea: estado,
                porcentaje_avance: avance,
                observaciones_docente: observaciones,
            })
            .then( res => {
                toastr.success('La calificación se guardo correctamente');
                window.location.reload();
            })
            .catch( error => {
                Swal.fire({
                    title: '¡Ups!',
                    text: 'No pudimos guardar la calificación',
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                }); 

            })
            .finally( () => {
                desactivarLoadBtn('btn_calificar_tarea');
            })
        },
        
        
    }
});
appTareas.mount('#app_general');
        