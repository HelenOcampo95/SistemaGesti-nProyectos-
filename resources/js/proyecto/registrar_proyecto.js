import { createApp } from "vue/dist/vue.esm-bundler";
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2

const appProyectos = createApp({
    data() {
        return {
            tabla: null,
        }
    },
    mounted(){
        this.inicializarDatePicker('#fecha_inicio', false);
        this.inicializarDatePicker('#fecha_entrega', false);
        
        //select para obtener el nombre del usuario.
        $('#id_usuario').select2({
            dropdownParent: $('#modal_registrar_proyecto'),
            ajax: {
                url: '/usuarios/select-usuarios',
                dataType: 'json',
                type: 'get',
                delay: 300,
                language: 'es',
                data: params => {
                    return {
                        busqueda: params.term,
                        page: params.page
                    }
                },
                processResults: data => {

                    let results = [];

                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id_usuario,
                            text: `${item.nombre_usuario}`
                        })
                    })

                    return { results }
                },
                cache: true
            },

        });

        //Select para obtener la categoria del proyecto
        $('#id_categoria').select2({
            dropdownParent: $('#modal_registrar_proyecto'),
            ajax: {
                url: '/categoria/select-categoria',
                dataType: 'json',
                type: 'get',
                delay: 300,
                language: 'es',
                data: params => {
                    return {
                        busqueda: params.term,
                        page: params.page
                    }
                },
                processResults: data => {

                    let results = [];

                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id_categoria,
                            text: `${item.nombre_categoria}`
                        })
                    })

                    return { results }
                },
                cache: true
            },

        });

        document.addEventListener('DOMContentLoaded', function() {
            const chipsContainer = document.getElementById('chipsContainer');
            const correoInput = document.getElementById('correo_usuario');

            correoInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const correo = correoInput.value.trim();
                    if (correo === "") return;

                    // Crear chip visual
                    const chip = document.createElement('div');
                    chip.classList.add('chip', 'p-1', 'me-1', 'mb-1', 'bg-light', 'border', 'rounded');
                    chip.style.display = 'flex';
                    chip.style.alignItems = 'center';
                    chip.innerHTML = `
                        <span>${correo}</span>
                        <button type="button" style="border:none;background:none;margin-left:5px;cursor:pointer;">&times;</button>
                    `;

                    // Botón para eliminar chip
                    chip.querySelector('button').addEventListener('click', () => {
                        chipsContainer.removeChild(chip);
                    });

                    // Insertar chip antes del input
                    chipsContainer.insertBefore(chip, correoInput);

                    // Limpiar input para agregar otro correo
                    correoInput.value = '';
                }
            });
        });
    },
    methods: {
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
        crearProyecto() {
            activarLoadBtn('btn_crear_proyecto');

            // Serializamos el formulario
            let form = $('#formulario_registrar_proyecto').serialize();
            console.log("Datos enviados:", form);

            axios.post('/proyectos', form)
                .then(() => {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'El proyecto fue creado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // 🔄 Recargar la página después de aceptar
                        window.location.reload();
                    });

                    $('#modal_registrar_proyecto').modal('hide');
                    $('#formulario_registrar_proyecto')[0].reset();
                })
                .catch(error => {
                    if (error.response) {
                        console.log("Respuesta completa del servidor:", error.response);
                    } else {
                        console.log("Error sin response:", error);
                    }

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
                })
                .finally(() => {
                    desactivarLoadBtn('btn_crear_proyecto');
                });
        }

    }
});

appProyectos.mount('#app_general');
