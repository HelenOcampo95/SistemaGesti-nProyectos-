import '../bootstrap'; 
import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2";
import spanish from '../data_tables/spanish.json';


const appUsuario = createApp({
    data() {
        return {
            tablaLista: {
                draw: () => {}
            },
            formUsuario: {
                editarNombre: '',
                editarApellido: '',
                editarCedula: '',
                editarCorreo: '',
            },
        }
    },
    mounted() {
        this.tablaLista = $('#listaDeUsuarios').DataTable({
            "language": spanish,
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ordering": false,
            search: {
                return: true,
            },
            "ajax": {
                url: "/listar-usuarios",
                data: function (d) {
                    return $.extend({}, d, {
                        "buscar": $('#buscador_usuarios').val().toLowerCase(),
                    });
                }
            },
            "columns": [
                { data: "nombre_usuario", name: "nombre_usuario" },
                { data: "apellido_usuario", name: "apellido_usuario"},
                { data: "cedula", name: "cedula"},
                { data: "correo_usuario", name: "correo_usuario"},
                { 
                    data: "creado_en", 
                    name: "creado_en",
                    render: function(data, type, row) {
                        if (!data) return '';
                        const date = new Date(data);
                        // Formats to DD/MM/YYYY (adjust locale 'es-ES' or 'en-US' as needed)
                        return date.toLocaleDateString('es-ES', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                { 
                    data: "actualizado_en", 
                    name: "actualizado_en",
                    render: function(data, type, row) {
                        if (!data) return '';
                        const date = new Date(data);
                        // Formats to DD/MM/YYYY (adjust locale 'es-ES' or 'en-US' as needed)
                        return date.toLocaleDateString('es-ES', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                { data: "id_usuario", name:"id_usuario", sClass:"text-center botones",
                render: function( data, type, row) {
                    return `
                            <a href="javascript:void(0)" 
                            class="btn btn-sm btn-light-success editar-usuario" 
                            data-id_usuario="${data}"
                            style="margin-right: 4px;">
                            Editar
                            </a>
                            `;
                    }
                },
                
            ],

        });

        $('#buscador_usuarios').bind('keyup', () => {

            clearTimeout( this.buscadorUsuario );
            this.buscadorUsuario = setTimeout(() => {
                this.tablaLista.draw();
            }, 380);

        }); 

        const self = this;

        $('#listaDeUsuarios tbody').on('click', '.editar-usuario', function(e) {
            e.preventDefault();

            const tr = $(this).closest('tr');
            const table = $('#listaDeUsuarios').DataTable();

            const rowData = table.row(tr).data();

            if(rowData) {

                self.formUsuario.editarNombre = rowData.nombre_usuario;
                self.formUsuario.editarApellido = rowData.apellido_usuario;
                self.formUsuario.editarCedula = rowData.cedula
                self.formUsuario.editarCorreo = rowData.correo_usuario;


                $('#id_usuario_actualizar').val(rowData.id_usuario);

                $('#modal_editar_usuario').modal('show');
            }
        });

    },
    methods: {
        editarUsuario(){

        }
        
    }
});
appUsuario.mount('#app_general');