import { createApp } from "vue/dist/vue.esm-bundler";
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2
import spanish from '../data_tables/spanish.json';


const appCategorias = createApp({
    data() {
        return {
            tablaLista: {
                draw: () => {}
            },
            buscadorCategorias: null
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
                
            ],

        });

        $('#buscador_categorias').bind('keyup', () => {

            clearTimeout( this.buscadorCategorias );
            this.buscadorCategorias = setTimeout(() => {
                this.tablaLista.draw();
            }, 380);

        });
    },
    methods: {
        registrarCategoria() {
            activarLoadBtn('btn_registrar_categoria');

            // Serializamos el formulario
            let form = $('#formulario_registrar_categoria').serialize();
                console.log("Datos enviados:", form);

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
        }
    }
});


appCategorias.mount('#app_general');
