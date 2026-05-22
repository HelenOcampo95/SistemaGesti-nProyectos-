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
        this.inicializarDatePicker('#modalidad_evento_editar', false);
    },
    methods: {
        aceptarVersion(id_version){
            Swal.fire({
                title: '¿Está seguro?',
                text: 'La versión será aceptada',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/aceptar-version/${id_version}`)
                        .then(response => {
                            Swal.fire({
                                title: '¡Versión aceptada!',
                                text: response.data.message || 
                                    'Se ha aceptado la versión correctamente.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location.reload();
                            });

                        })
                        .catch(error => {
                            console.error('Error:', error);
                            const errorMessage = error.response?.data?.message || 
                                'Hubo un problema al aprobar la versión.';
                            Swal.fire({
                                title: 'Error',
                                text: errorMessage,
                                icon: 'error'
                            });

                        });
                }
            });
        },
        rechazarVersion(id_version){

            Swal.fire({
                title: '¿Está seguro?',
                text: 'La versión será rechazada',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.isConfirmed) {

                    axios.post(`/rechazar-version/${id_version}`)
                        .then(response => {

                            Swal.fire({
                                title: '¡Versión rechazada!',
                                text: response.data.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });

                        })
                        .catch(error => {

                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al rechazar la versión.',
                                icon: 'error'
                            });

                        });

                }

            });

        },
        inicializarDatePicker( elemento, minDateToday = false) {

            if( minDateToday ) {

                const nowDate = new Date();
                let today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                let maxLimitDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate()+60, 0, 0, 0, 0)

                $( elemento ).daterangepicker({
                    singleDatePicker: true,
                    // showDropdowns: true,
                    minYear: 1901,
                    maxYear: parseInt(moment().format("YYYY"),12),
                    minDate: today,
                    maxDate: maxLimitDate,
                    locale: {
                        format: "YYYY/MM/DD",
                        "separator": " - ",
                        "applyLabel": "Seleccionar fecha",
                        "cancelLabel": "Cerrar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Personalizar",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                });

                return;
            }


            $( elemento ).daterangepicker({
                singleDatePicker: true,
                // showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),12),
                locale: {
                    format: "YYYY/MM/DD",
                    "separator": " - ",
                    "applyLabel": "Seleccionar fecha",
                    "cancelLabel": "Cerrar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Personalizar",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            });

            },
    } 
});

appVersion.mount('#app_general');