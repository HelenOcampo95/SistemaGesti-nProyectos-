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
                text: response.data.message || 'Se ha aceptado la entrega correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                const errorMessage = error.response?.data?.message || 'Hubo un problema al realizar la entrega.';
                Swal.fire('Error', errorMessage, 'error');
            });                            
            
        },
        rechazarVersion(){

        }
    } 
});

appVersion.mount('#app_general');