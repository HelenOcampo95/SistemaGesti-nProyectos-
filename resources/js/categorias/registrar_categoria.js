import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2
import spanish from '../data_tables/spanish.json';
import axios from "axios";

const appCategorias = createApp({
    data() {
        return {
            tablaLista: {
                draw: () => {}
            },
            buscadorCategorias: null,
            id_categoria: null, 
            nombre_categoria: '',
            descripcion_categoria: '',
            formCategoria: {
                nombreCategoria: '',
                descripcionCategoria: '',
                editarCategoria: '',
                editarDescripcion: '',

            },
            limites: {
                nombreCategoria: 70,
                descripcionCategoria: 200,
                editarCategoria: 70,
                editarDescripcion: 200
            }
        }
    },
    mounted(){

        this.tablaLista = $('#listadoDeCategorias').DataTable({
            "language": spanish,
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ordering": false,
            search: {
                return: true,
            },
            "ajax": {
                url: "/listar-categorias",
                data: function (d) {
                    return $.extend({}, d, {
                        "buscar": $('#buscador_categorias').val().toLowerCase(),
                    });
                }
            },
            "columns": [
                { data: "nombre_categoria", name: "nombre_categoria" },
                { data: "descripcion_categoria", name: "descripcion_categoria"},
                { data: "eliminado_en", name: "eliminado_en"},
                { data: "id_categoria", name:"id_categoria", sClass:"text-center botones",
                render: function( data, type, row) {
                    return `
                            <a href="javascript:void(0)" 
                            class="btn btn-sm btn-light-success editar-categoria" 
                            data-id_categoria="${data}"
                            style="margin-right: 4px;">
                            Editar
                            </a>
                            `;
                    }
                },
                { 
                data: "id_categoria", name:"id_categoria", sClass:"text-center botones",
                        render: function(data, type, row) {
                            return `
                                    <a href="#" class="btn btn-sm btn-light-danger eliminar-categoria" data-id_categoria="${data}" style="margin-right: 4px;">Eliminar</a>
                                `;
                        }
                }

            ],

        });

        $('#buscador_categorias').bind('keyup', () => {

            clearTimeout( this.buscadorCategorias );
            this.buscadorCategorias = setTimeout(() => {
                this.tablaLista.draw();
            }, 380);

        });

        const self = this;

        $('#listadoDeCategorias tbody').on('click', '.editar-categoria', function(e) {
            e.preventDefault();
            
            // 'this' es el botón, buscamos la fila (tr) más cercana
            const tr = $(this).closest('tr');
            const table = $('#listadoDeCategorias').DataTable();
            
            // rowData obtendrá los datos del objeto original (nombre, descripción, etc.)
            const rowData = table.row(tr).data();

            if(rowData) {
                // Asignación a Vue (asegúrate que 'self' esté definido arriba como 'const self = this')
                self.formCategoria.editarCategoria = rowData.nombre_categoria;
                self.formCategoria.editarDescripcion = rowData.descripcion_categoria;

                $('#id_categoria_actualizar').val(rowData.id_categoria);
                
                // Abrir el modal
                $('#modal_editar_categoria').modal('show');
            }
        });

        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        // Delegación de evento en DataTable para el botón eliminar
        $('#listadoDeCategorias tbody').on('click', '.eliminar-categoria', function (e) {
            e.preventDefault();

            const id_categoria = $(this).data('id_categoria');

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
                    axios.post(`/eliminar-categoria/${id_categoria}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        Swal.fire(
                            '¡Eliminado!',
                            response.data.message || 'Categoría eliminada correctamente',
                            'success'
                        );
                        $('#listadoDeCategorias').DataTable().ajax.reload(null, false); // recargar sin resetear página
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
            dropdownParent: $('#modal_asignar_docente'),
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

        $('#id_docente_director').select2({
            dropdownParent: $('#modal_asignar_docente'),
            ajax: {
                url: '/docentes/select-docentes-director',
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
                            text: `${item.nombre_usuario} ${item.apellido_usuario}`
                        })
                    })

                    return { results }
                },
                cache: true
            },

        });

        $('#id_docente_lider').select2({
            dropdownParent: $('#modal_asignar_docente'),
            ajax: {
                url: '/docentes/select-docentes-lider',
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
                            text: `${item.nombre_usuario} ${item.apellido_usuario}`
                        })
                    })

                    return { results }
                },
                cache: true
            },

        });
    
    },
    computed: {
        excedidos(){
            return{
                nombre: this.formCategoria.nombreCategoria.length >= this.limites.nombreCategoria,
                descripcion: this.formCategoria.descripcionCategoria.length >= this.limites.descripcionCategoria,
                editarNombreCategoria: this.formCategoria.editarCategoria.length >= this.limites.editarCategoria,
                editarDescripcionCategoria: this.formCategoria.editarDescripcion.length >= this.limites.editarDescripcion
            }
        }
    },
    methods: {
        registrarCategoria() {
            activarLoadBtn('btn_registrar_categoria');

            let form = $('#formulario_registrar_categoria').serialize();

            axios.post('/registrar/categoria', form)
                .then(() => {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'La categoria fue creada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });

                    $('#modal_registrar_categoria').modal('hide');
                    $('#formulario_registrar_categoria')[0].reset();
                    
                    // ¡Aquí es donde debes recargar la tabla!
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
                    desactivarLoadBtn('btn_registrar_categoria');
                });
        },
        editarCategoria(){
            // Obtenemos los datos del formulario de edición
            const id_categoria = $('#id_categoria_actualizar').val(); 
            const nombre_categoria = $('#nombre_categoria_editar').val(); 
            const descripcion_categoria = $('#descripcion_categoria_editar').val();

            // Validaciones básicas (opcional)
            if (!nombre_categoria) {
                Swal.fire('Error', 'El nombre de la categoría es obligatorio.', 'error');
                return;
            }

            // Enviamos la solicitud de actualización con Axios
            axios.post(`/actualizar-categoria/${id_categoria}`, {
                nombre_categoria: nombre_categoria,
                descripcion_categoria: descripcion_categoria
            })
            .then(response => {
                // Manejamos la respuesta exitosa del servidor
                Swal.fire('¡Éxito!', response.data.message, 'success');
                $('#modal_editar_categoria').modal('hide');
                this.tablaLista.ajax.reload(); // Recargamos la tabla para ver los cambios
            })
            .catch(error => {
                // Manejamos los errores
                console.error('Error al actualizar la categoría:', error);
                const errorMessage = error.response.data.message || 'Hubo un problema al actualizar la categoría.';
                Swal.fire('Error', errorMessage, 'error');
            });
        },
        asignarCategoriaDocente(){

            const datos = {
                id_categoria:        $('#id_categoria').val(),
                id_docente_director: $('#id_docente_director').val(),
                id_docente_lider:    $('#id_docente_lider').val()

            };

            if (!datos.id_categoria) {
                desactivarLoadBtn('btn_asignar_docente');
                Swal.fire('Atención', 'Debe seleccionar una categoria para continuar', 'warning');
                return;
            }
            if (!datos.id_docente_director) {
                desactivarLoadBtn('btn_asignar_docente');
                Swal.fire('Atención', 'Debe seleccionar un Docente Director', 'warning');
                return;
            }

            if (!datos.id_docente_lider) {
                desactivarLoadBtn('btn_asignar_docente');
                Swal.fire('Atención', 'Debe seleccionar un Docente Líder', 'warning');
                return;
            }

            axios.post('/asignar-docente', datos)
                .then(() => {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'el docente fue asignado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });

                    $('#modal_asignar_docente').modal('hide');
                    $('#formulario_asignar_docente')[0].reset();
                    
                    // ¡Aquí es donde debes recargar la tabla!
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
                    desactivarLoadBtn('btn_asignar_docente');
            });
        }
    }
});


appCategorias.mount('#app_general');
