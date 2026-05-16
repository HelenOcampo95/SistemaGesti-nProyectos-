import '../bootstrap'; 
import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2";
import spanish from '../data_tables/spanish.json';


const appEvento = createApp({
    data() {
        return {
            tablaLista: {
                draw: () => {}
            },
            id_categoria: null, 
            buscadorEvento: null,
            formEvento: {
                nombreEvento: '',
                editarEvento: '',

            },
        }
    },
    mounted() {
        
        this.tablaLista = $('#listaDeEventos').DataTable({
            "language": spanish,
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ordering": false,
            search: {
                return: true,
            },
            "ajax": {
                url: "/listar-evento",
                data: function (d) {
                    return $.extend({}, d, {
                        "buscar": $('#buscador_eventos').val().toLowerCase(),
                    });
                }
            },
            "columns": [
                { data: "nombre_evento", name: "nombre_evento" },
                { data: "fecha_evento", name: "fecha_evento"},
                { data: "hora_evento", name: "hora_evento"},
                { data: "modalidad_evento", name: "modalidad_evento"},
                { data: "ubicacion_url", name: "ubicacion_url"},
                { data: "actualizado_en", name: "actualizado_en"},
                { data: "eliminado_en", name: "eliminado_en"},
                { data: "id_evento", name:"id_evento", sClass:"text-center botones",
                render: function( data, type, row) {
                    return `
                            <a href="javascript:void(0)" 
                            class="btn btn-sm btn-light-success editar-evento" 
                            data-id_evento="${data}"
                            style="margin-right: 4px;">
                            Editar
                            </a>
                            `;
                    }
                },
                { 
                data: "id_evento", name:"id_evento", sClass:"text-center botones",
                        render: function(data, type, row) {
                            return `
                                    <a href="#" class="btn btn-sm btn-light-danger eliminar-evento" data-id_evento="${data}" style="margin-right: 4px;">Eliminar</a>
                                `;
                        }
                }
            ],

        });

        $('#buscador_eventos').bind('keyup', () => {

            clearTimeout( this.buscadorEvento );
            this.buscadorEvento = setTimeout(() => {
                this.tablaLista.draw();
            }, 380);

        });

        const self = this;
        $('#listaDeEventos tbody').on('click', '.editar-evento', function(e) {
            e.preventDefault();
            
            const tr = $(this).closest('tr');
            const table = $('#listaDeEventos').DataTable();
            
            // rowData obtendrá los datos del objeto original (nombre, descripción, etc.)
            const rowData = table.row(tr).data();

            if(rowData) {
                // Asignación a Vue (asegúrate que 'self' esté definido arriba como 'const self = this')
                self.formEvento.editarEvento = rowData.nombre_evento;

                $('#id_evento_actualizar').val(rowData.id_evento);
                
                // Abrir el modal
                $('#modal_editar_evento').modal('show');
            }
            
        });

        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        // Delegación de evento en DataTable para el botón eliminar
        $('#listaDeEventos tbody').on('click', '.eliminar-evento', function (e) {
            e.preventDefault();

            const id_evento = $(this).data('id_evento');

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
                    axios.post(`/eliminar-evento/${id_evento}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        Swal.fire(
                            '¡Eliminado!',
                            response.data.message || 'Evento eliminado correctamente',
                            'success'
                        );
                        $('#listaDeEventos').DataTable().ajax.reload(null, false); // recargar sin resetear página
                    })
                    .catch(error => {
                        console.error("Error al eliminar:", error.response || error);
                        let mensaje = "No se pudo eliminar la categoría.";
                        if (error.response && error.response.data) {
                            mensaje = error.response.data.error || error.response.data.message || mensaje;
                        }
                        Swal.fire('Error', mensaje, 'error');
                    });
                }
            });

        });

        $('#id_categoria').select2({
            dropdownParent: $('#modal_registrar_evento'),
            ajax: {
                url: '/seleccionar-categoria',
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

    },
    methods: {
        registrarEvento() {

        activarLoadBtn('btn_registrar_evento');

        let form = $('#formulario_registrar_evento').serialize();

        axios.post('/registrar-evento', form)

            .then(() => {

                Swal.fire({
                    title: '¡Éxito!',
                    text: 'El evento fue creado correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });

                $('#modal_registrar_evento').modal('hide');

                $('#formulario_registrar_evento')[0].reset();

                if (this.tablaLista) {
                    this.tablaLista.ajax.reload();
                }

            })

            .catch(error => {

                console.log(error);

                if (error.response?.status === 422) {

                    Swal.fire({
                        title: 'Hace falta información',
                        text: 'Por favor completa todos los campos requeridos',
                        icon: 'error'
                    });

                    return;
                }

                Swal.fire({
                    title: '¡Vaya!',
                    text: 'Ocurrió un error, contacta soporte',
                    icon: 'error'
                });

            })

            .finally(() => {

                desactivarLoadBtn('btn_registrar_evento');

            });

        }, 
        editarEvento(){
            const id_evento = $('#id_evento_actualizar').val(); 
            const nombre_evento = $('#nombre_evento_editar').val(); 

            if (!nombre_evento) {
                Swal.fire('Error', 'El nombre del evento es obligatorio.', 'error');
                return;
            }

            axios.post(`/actualizar-evento/${id_evento}`, {
                nombre_evento: nombre_evento,
                
            })
            .then(response => {
                
                Swal.fire('¡Éxito!', response.data.message, 'success');
                $('#modal_editar_evento').modal('hide');
                this.tablaLista.ajax.reload(); 
            })
            .catch(error => {
                
                console.error('Error al actualizar el evento:', error);
                const errorMessage = error.response.data.message || 'Hubo un problema al actualizar el evento.';
                Swal.fire('Error', errorMessage, 'error');
            });
        }
    }
});
appEvento.mount('#app_general');