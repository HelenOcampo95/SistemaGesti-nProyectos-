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
                        <a href="#" 
                            class="btn btn-sm btn-light-success editar-categoria" 
                            data-id_categoria="${data}" 
                            data-nombre="${row.nombre_categoria}" 
                            data-descripcion="${row.descripcion_categoria}"
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

        $('#listadoDeCategorias tbody').on('click', '.editar-categoria', function(e) {
        e.preventDefault();


                const id_categoria = $(this).data('id_categoria');
                const nombre = $(this).data('nombre');
                const descripcion = $(this).data('descripcion');
                
                $('#nombre_categoria_editar').val(nombre);
                $('#descripcion_categoria_editar').val(descripcion);
                $('#id_categoria_actualizar').val(id_categoria);
                
                $('#modal_editar_categoria').modal('show');
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
        }
    }
});


appCategorias.mount('#app_general');
