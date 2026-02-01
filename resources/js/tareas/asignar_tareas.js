import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2
import spanish from '../data_tables/spanish.json';


const appCategorias = createApp({
    data() {
        return {
            tablaLista: {
                draw: () => {}
            },
            buscadorTareas: null
        }
    },
    mounted(){
        this.inicializarDatePicker('#fecha_entrega', false);

        this.tablaLista = $('#listadoDeTareas').DataTable({
            "language": spanish,
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ordering": false,
            search: {
                return: true,
            },
            "ajax": {
                url: "/listar-tareas",
                data: function (d) {
                    return $.extend({}, d, {
                        "buscar": $('#buscador_tareas').val().toLowerCase(),
                    });
                }
            },
            "columns": [
                {data: "nombre_proyecto", name: "nombre_proyecto" },
                { data: "titulo_tarea", name: "titulo_tarea" },
                { data: "descripcion_tarea", name: "descripcion_tarea" },
                { data: "fecha_entrega", name: "fecha_entrega"},
                { data: "estado_tarea", name: "estado_tarea"},
                { data: "observaciones_docente", name: "observaciones_docente"},
                { data: "porcentaje_avance", name: "porcentaje_avance"},
                { data: "id_tarea", name:"id_tarea", sClass:"text-center botones",
                render: function( data, type, row) {
                    return `
                        <a href="#" 
                            class="btn btn-sm btn-light-success editar-tarea" 
                            data-id_tarea="${data}" 
                            data-descripcion="${row.descripcion_tarea}"
                            style="margin-right: 4px;">
                            Editar
                        </a>
                            `;
                    }
                },
                { 
                data: "id_tarea", name:"id_tarea", sClass:"text-center botones",
                        render: function(data, type, row) {
                            return `
                                    <a href="#" class="btn btn-sm btn-light-danger eliminar-tarea" data-id_tarea="${data}" style="margin-right: 4px;">Eliminar</a>
                                `;
                        }
                }
            ],

        });

        $('#buscador_tareas').bind('keyup', () => {

            clearTimeout( this.buscadorTareas );
            this.buscadorTareas = setTimeout(() => {
                this.tablaLista.draw();
            }, 380);

        });

        $('#listadoDeTareas tbody').on('click', '.editar-tarea', function(e) {
        e.preventDefault();

                const id_tarea      = $(this).data('id_tarea');
                const titulo        = $(this).data('titulo');
                const descripcion   = $(this).data('descripcions');
                const observaciones = $(this).data('observaciones');


                $('#id_tarea_editar').val(id_tarea); 
                $('#titulo_tarea_editar').val(titulo)
                $('#descripcion_tarea_editar').val(descripcion);
                $('#observaciones_tarea_editar').val(observaciones);
            
                $('#modal_editar_tareas').modal('show');
        });

        $('#listadoDeTareas tbody').on('click', '.eliminar-tarea', function (e) {
            e.preventDefault();

            const id_tarea = $(this).data('id_tarea');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/eliminar-tarea/${id_tarea}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        Swal.fire(
                            '¡Eliminado!',
                            response.data.message || 'Tarea eliminada correctamente',
                            'success'
                        );
                        $('#listadoDeTareas').DataTable().ajax.reload(null, false); 
                    })
                    .catch(error => {
                        console.error("Error al eliminar:", error.response || error);
                        let mensaje = "No se pudo eliminar la tarea.";
                        if (error.response && error.response.data) {
                            mensaje = error.response.data.error || error.response.data.message || mensaje;
                        }
                        Swal.fire('Error', mensaje, 'error');
                    });
                }
            });

        });

        

        $('#id_proyecto').select2({
            dropdownParent: $('#modal_asignar_tarea'),
            ajax: {
                url: '/select-proyecto',
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
                            id: item.id_proyecto,
                            text: `${item.nombre_proyecto}`
                        })
                    })

                    return { results }
                },
                cache: true
            },

        });

        
    },
    methods: {
            asignarTarea() {
                activarLoadBtn('btn_asignar_tarea');
    
                // Serializamos el formulario
                let form = $('#formulario_asignar_tarea').serialize();

                axios.post('/asignar-tarea', form)
                    .then(() => {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'La categoria fue creada correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
    
                        $('#modal_asignar_tarea').modal('hide');
                        $('#formulario_asignar_tarea')[0].reset();
                        
                        this.tablaLista.ajax.reload(); 
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
                        desactivarLoadBtn('btn_asignar_tarea');
                    });
            },

            editarTarea(){
                // Obtenemos los datos del formulario de edición
                const id_tarea = $('#id_tarea_editar').val(); 
                const titulo_tarea = $('#titulo_tarea_editar').val();
                const descripcion_tarea = $('#descripcion_tarea_editar').val();
                const observaciones_docente = $('#observaciones_tarea_editar').val();
                // Validaciones básicas (opcional)
                if (!descripcion_tarea && !observaciones_docente) {
                    Swal.fire('Error', 'Debe ingresar una descripción o una observación para actualizar.', 'error');
                    return;
                }       

                // Enviamos la solicitud de actualización con Axios
                axios.post(`actualizar-tarea/${id_tarea}`, {
                    titulo_tarea: titulo_tarea,
                    descripcion_tarea: descripcion_tarea,
                    observaciones_docente: observaciones_docente
                })
                .then(response => {
                    // Manejamos la respuesta exitosa del servidor
                    Swal.fire('¡Éxito!', response.data.message, 'success');
                    $('#modal_editar_tareas').modal('hide');
                    this.tablaLista.ajax.reload(); 
                })
                .catch(error => {
                    // Manejamos los errores
                    console.error('Error al actualizar la categoría:', error);
                    const errorMessage = error.response.data.message || 'Hubo un problema al actualizar la tarea.';
                    Swal.fire('Error', errorMessage, 'error');
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
    
    
    
    appCategorias.mount('#app_general');
    