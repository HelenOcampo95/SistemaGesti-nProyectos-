import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2

const appProyectos = createApp({
    data() {
        return {
            tabla: null,
            colaboradores: [],
            nuevo_correo: '',
            formProyecto: {
                nombreProyecto: '',
                descripcionProyecto: '',

            },
            limites: {
                nombreProyecto: 45,
                descripcionProyecto: 200,

            }
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

        $('#id_rol').select2({
            placeholder: 'Seleccione un usuario',
            allowClear: true,
            ajax: {
                url: '/select-rol',
                dataType: 'json',
                type: 'get',
                delay: 300,
                data: params => {
                    return {
                        busqueda: params.term, // Lo que el usuario escribe
                        page: params.page
                    }
                },
                processResults: data => {
                    // Transformamos los datos para que Select2 los entienda (id y text)
                    return {
                        results: data.map(item => ({
                            id: item.id_rol,
                            text: item.name // Puedes concatenar: item.nombre_usuario + ' ' + item.apellido_usuario
                        }))
                    };
                },
                cache: true
            }
        });

        $(document).ready(function() {
        // Función para dar formato a las opciones
        function formatRol(item) {
            // Si no hay ID (como el placeholder), devolver el texto normal
            if (!item.id) {
                return item.text;
            }

            // Extraer datos de los atributos 'data-' del <option>
            var icon = $(item.element).data('icon');
            var color = $(item.element).data('color');
            var desc = $(item.element).data('desc');

            // Construir el HTML "bonito"
            var $result = $(
                '<div class="d-flex align-items-center">' +
                    '<div class="symbol symbol-30px me-3">' +
                        '<span class="symbol-label bg-light">' +
                            '<i class="bi ' + icon + ' ' + color + ' fs-3"></i>' +
                        '</span>' +
                    '</div>' +
                    '<div class="d-flex flex-column">' +
                        '<span class="fw-bold fs-6">' + item.text + '</span>' +
                        '<span class="text-muted fs-7">' + desc + '</span>' +
                    '</div>' +
                '</div>'
            );

            return $result;
        }

        $('#id_rol').select2({
            placeholder: 'Seleccione un rol',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            templateResult: formatRol,      // Formato en la lista desplegable
            templateSelection: formatRol   // Formato cuando ya está seleccionado
        });
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
    computed: {
        excedidos(){
            return {
                nombre: this.formProyecto.nombreProyecto.length >= this.limites.nombreProyecto,
                descripcion: this.formProyecto.descripcionProyecto.length >= this.limites.descripcionProyecto,
            }
        }
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
                    // autoUpdateInput: false,
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
                // autoUpdateInput: false,
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
        agregarColaborador() {
            const correo = this.nuevo_correo.trim().toLowerCase();

            if (!correo) return;

            // 1. Verificar si ya está en la lista local para no repetirlo
            if (this.colaboradores.includes(correo)) {
                Swal.fire('Atención', 'Este correo ya fue agregado', 'warning');
                return;
            }

            // 2. Consultamos al servidor si el correo existe
            // Reutilizamos una ruta de búsqueda o creamos una simple
            axios.get(`/validar-correo/${correo}`)
                .then(response => {
                    // SI EXISTE: Lo agregamos a la lista de "badges"
                    this.colaboradores.push(correo);
                    this.nuevo_correo = ''; 
                })
                .catch(error => {
                    // SI NO EXISTE: Mostramos la alerta en rojo que pides
                    Swal.fire({
                        title: 'Usuario no encontrado',
                        text: `El correo "${correo}" no está registrado en el sistema.`,
                        icon: 'error',
                        confirmButtonColor: '#f27474'
                    });
                    // Opcional: limpiar el input si quieres que lo intente de nuevo
                    this.nuevo_correo = '';
                });
        },

        eliminarColaborador(index) {
            this.colaboradores.splice(index, 1);
        },

        crearProyecto() {
            activarLoadBtn('btn_crear_proyecto');

            // Recolectamos datos manualmente para incluir el array de colaboradores
            const datos = {
                nombre_proyecto: $('#nombre_proyecto').val(),
                descripcion_proyecto: $('#descripcion_proyecto').val(),
                fecha_inicio: $('#fecha_inicio').val(),
                fecha_entrega: $('#fecha_entrega').val(),
                estado_proyecto: $('#estado_proyecto').val(),
                id_categoria: $('#id_categoria').val(),
                colaboradores: this.colaboradores // <--- Array de Vue
            };
            
            if (!datos.fecha_inicio || !datos.fecha_entrega) {
                desactivarLoadBtn('btn_crear_proyecto');
                Swal.fire('Atención', 'Debe completar las fechas', 'warning');
                return;
            }

            if (datos.fecha_entrega < datos.fecha_inicio) {
                desactivarLoadBtn('btn_crear_proyecto');
                Swal.fire('Error en fechas', 'La fecha de entrega no puede ser anterior a la fecha de inicio', 'error');
                return;
            }
            if (!datos.id_categoria) {
                    desactivarLoadBtn('btn_crear_proyecto');
                    Swal.fire('Atención', 'Debe seleccionar una categoria para continuar', 'warning');
                    return; // Detiene la ejecución
            }
            
            axios.post('/proyectos', datos)
                .then(response => {
                    Swal.fire('¡Éxito!', 'Proyecto y colaboradores registrados', 'success')
                        .then(() => window.location.reload());
                })
                .catch(error => {
                    // 1. Extraemos el mensaje de error enviado por el backend (el Exception)
                    let mensajeError = 'No se pudo crear el proyecto';
                    
                    if (error.response && error.response.data && error.response.data.detalle) {
                        // Aquí capturamos: "El colaborador con correo '...' no está registrado"
                        mensajeError = error.response.data.detalle;
                    } else if (error.response && error.response.data.message) {
                        // Captura errores de validación por defecto de Laravel
                        mensajeError = error.response.data.message;
                    }

                    // 2. Mostramos el error específico al usuario
                    Swal.fire('Error', mensajeError, 'error');
                })
                .finally(() => {
                    desactivarLoadBtn('btn_crear_proyecto');
                });
        }

    }
});

appProyectos.mount('#app_general');
