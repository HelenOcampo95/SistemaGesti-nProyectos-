import '../bootstrap'; 
import { createApp } from 'vue';
import Swal from "sweetalert2";

const appVersion = createApp({
    data() {
        return {
            
            versiones: [],
            estado_version: '',
            
        }
    },
    mounted() {
    },
    methods: {
        aceptarVersion(id_version){
            axios.post(`/aceptar-version/${id_version}`)
            .then(response => {
                Swal.fire({
                title: '¡Versión aceptada!',
                text: response.data.message || 'Se ha aceptado la versión correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                const errorMessage = error.response?.data?.message || 'Hubo un problema al aprobar la versión.';
                Swal.fire('Error', errorMessage, 'error');
            });                            
            
        },
        rechazarVersion(){
            axios.post(`/rechazar-version/${id_version}`)
                .then(response => {
                    Swal.fire({
                    title: '¡Versión aceptada!',
                    text: response.data.message || 'Se ha rechazado la versión correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorMessage = error.response?.data?.message || 'Hubo un problema al rechazar la versión.';
                    Swal.fire('Error', errorMessage, 'error');
                });         
        }
    } 
});

appVersion.mount('#app_general');