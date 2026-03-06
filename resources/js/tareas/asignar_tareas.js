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
            buscadorTareas: null,
            
            formTarea: {
                tituloTarea: '',
                descripcionTarea: '',
                observacionTarea: '',
                editarTituloTarea: '',
                editarDescripcionTarea: '',
                editarObservacionTarea: '',
            },
            // Agrupamos los límites en un solo lugar
            limites: {
                tituloTarea: 70,
                descripcionTarea: 250,
                observacionTarea: 250,
                editarTituloTarea: 70,
                editarDescripcionTarea: 250,
                editarObservacionTarea: 250
            }
        }
    },
    mounted(){
        const self = this;
        this.inicializarDatePicker('#fecha_entrega', true);

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
                { data: "nombre_proyecto", name: "nombre_proyecto" },
                { data: "titulo_tarea", name: "titulo_tarea" },
                { data: "fecha_entrega", name: "fecha_entrega"},
                { data: "estado_tarea", name: "estado_tarea"},
                { data: "porcentaje_avance", name: "porcentaje_avance"},
                { 
                    data: "actualizado_en", 
                    name: "actualizado_en", // Corregido: El name debe coincidir con el data
                    render: function(data) { 
                        return self.formatarFechaHora(data); 
                    }
                },
                { 
                    data: "eliminado_en", 
                    name: "eliminado_en", // Corregido: El name debe coincidir con el data
                    render: function(data) { 
                        return self.formatarFechaHora(data); 
                    }
                },
                { 
                    data: "id_tarea", 
                    render: function(data, type, row) {
                        // 1. Iniciamos con el botón de "Ver Detalle" (que todos ven)
                        let html = `
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item ver-detalle" href="javascript:void(0)" data-id="${data}">
                                            <i class="fa fa-eye me-4"></i> Ver Detalle
                                        </a>
                                    </li>`;

                        // 2. Verificamos el permiso de EDITAR
                        if (window.permisosUsuario.canEditar) {
                            html += `
                                <li>
                                    <a class="dropdown-item editar-tarea" href="javascript:void(0)" data-id_tarea="${data}">
                                        <i class="fa fa-edit me-4"></i> Editar
                                    </a>
                                </li>`;
                        }

                        // 3. Verificamos el permiso de ELIMINAR
                        if (window.permisosUsuario.canEliminar) {
                            html += `
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item eliminar-tarea" href="javascript:void(0)" data-id_tarea="${data}">
                                        <i class="fa fa-trash text-gray me-4"></i> Eliminar
                                    </a>
                                </li>`;
                        }

                        html += `</ul></div>`;
                        return html;
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

        $('#listadoDeTareas tbody').on('click', '.ver-detalle', function(e) {
        e.preventDefault();
            const table = $('#listadoDeTareas').DataTable();
            const data = table.row($(this).parents('tr')).data();

            if (data) {
                // 2. Llenar los textos básicos
                $('#det_titulo').text(data.titulo_tarea || 'Sin título');
                $('#det_proyecto').text(data.nombre_proyecto || 'Sin proyecto asignado');
                $('#det_descripcion').text(data.descripcion_tarea || 'Sin descripción detallada.');
                $('#det_observaciones').text(data.observaciones_docente || 'No hay comentarios del docente aún.');

                // 3. Formatear la fecha de entrega usando tu método de Vue
                // Nota: appCategorias es el nombre de tu constante de Vue
                $('#det_entrega').text(appCategorias.formatarFechaHora ? appCategorias.formatarFechaHora(data.fecha_entrega) : data.fecha_entrega);

                // 4. Estado estilizado (Badge)
                let claseEstado = 'badge-light-primary';
                if (data.estado_tarea === 'Completado') claseEstado = 'badge-light-success';
                if (data.estado_tarea === 'Pendiente') claseEstado = 'badge-light-warning';
                
                $('#det_estado').html(`<span class="badge ${claseEstado} fw-bold px-3 py-2">${data.estado_tarea}</span>`);

                // 5. Barra de progreso animada
                let avance = parseInt(data.porcentaje_avance) || 0;
                $('#det_avance_texto').text(avance + '%');
                $('#det_avance_bar').css('width', avance + '%').attr('aria-valuenow', avance);

                // 6. Mostrar el modal
                $('#modal_ver_detalle').modal('show');
            }
        });

        $('#listadoDeTareas tbody').on('click', '.editar-tarea', function(e) {
        e.preventDefault();

            const table = $('#listadoDeTareas').DataTable();
            const rowData = table.row($(this).parents('tr')).data();

            if (rowData) {
            
                self.formTarea.editarTituloTarea = rowData.titulo_tarea || '';
                self.formTarea.editarDescripcionTarea = rowData.descripcion_tarea || '';
                self.formTarea.editarObservacionTarea = rowData.observaciones_docente || '';

                // 3. ASIGNAR EL ID AL HIDDEN (usando el nuevo ID único)
                $('#id_tarea_editar_hidden').val(rowData.id_tarea); 


                
                // 4. Mostrar el modal
                $('#modal_editar_tareas').modal('show');
            }
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
                    axios.post(`/eliminar-tarea/${id_tarea}`, {
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
    computed: {
        excedidos() {
            return {
                titulo: this.formTarea.tituloTarea.length >= this.limites.tituloTarea,
                descripcion: this.formTarea.descripcionTarea.length >= this.limites.descripcionTarea,
                observacion: this.formTarea.observacionTarea.length >= this.limites.observacionTarea,
                editarTitulo: this.formTarea.editarTituloTarea.length >= this.limites.editarTituloTarea,
                editarDescripcion: this.formTarea.editarDescripcionTarea.length >= this.limites.editarDescripcionTarea,
                editarObservacion : this.formTarea.editarObservacionTarea.length >= this.limites.editarObservacionTarea
            };
        }
    },
    methods: {
            formatarFechaHora(fechaString) {
                if (!fechaString) return "---";
                let date = new Date(fechaString);
                if (isNaN(date.getTime())) return fechaString;

                    return date.toLocaleString('es-ES', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });
            },
            asignarTarea() {
                activarLoadBtn('btn_asignar_tarea');

                const idProyecto = $('#id_proyecto').val();

                if (!idProyecto) {
                    desactivarLoadBtn('btn_asignar_tarea');
                    Swal.fire('Atención', 'Debe seleccionar un proyecto para continuar', 'warning');
                    return; // Detiene la ejecución
                }
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
                        if (this.descripcionExcedida) {
                            Swal.fire({
                                title: 'Límite excedido',
                                text: 'La descripción supera el máximo permitido.',
                                icon: 'warning'
                            });
                            return;
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
                if (!titulo_tarea && !descripcion_tarea && !observaciones_docente) {
                    Swal.fire('Error', 'Debe ingresar una descripción o una observación para actualizar.', 'error');
                    return;
                }       

                // Enviamos la solicitud de actualización con Axios
                axios.post(`/actualizar-tarea/${id_tarea}`, {
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
    