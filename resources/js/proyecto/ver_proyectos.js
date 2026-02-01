import { createApp } from 'vue';
import spanish from '../data_tables/spanish.json';


const appCategorias = createApp({
    data() {
        return {
            tablaLista: {
                draw: () => {}
            },
            buscadorProyecto: null
        }
    },
    mounted(){

            this.tablaLista = $('#listaDeProyectos').DataTable({
                "language": spanish,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ordering": false,
                search: {
                    return: true,
                },
                "ajax": {
                    url: "/listar-proyectos",
                    data: function (d) {
                        return $.extend({}, d, {
                            "buscar": $('#buscador_proyectos').val().toLowerCase(),
                        });
                    }
                },
                "columns": [
                    {data: "nombre_proyecto", name: "nombre_proyecto" },
                    {data: "estado_proyecto", name: "estado_proyecto" },
                    {data: "fecha_inicio", name: "fecha_inicio" },
                    {data: "nombre_categoria", name: "nombre_categoria" },
                    { data: "id_proyecto", name:"id_proyecto", sClass:"text-center botones",
                        render: function( data, type, row) {
                            return `
                                    <a href="/detalle/${data}" class="btn btn-light-success btn-sm" style="margin-right: 4px;">Detalles</a>
                                `;

                        }
                    }
                ],

            });
            $('#buscador_proyectos').bind('keyup', () => {

            clearTimeout( this.buscadorProyecto );
            this.buscadorProyecto = setTimeout(() => {
                this.tablaLista.draw();
            }, 380);

        });

        },

    });
    
    
    // <a href="/precios-productos/detalle-lista-precios-socio/${ data }" class="btn btn-light-success btn-sm" style="margin-right: 4px;">Detalles</a>
    appCategorias.mount('#app_general');