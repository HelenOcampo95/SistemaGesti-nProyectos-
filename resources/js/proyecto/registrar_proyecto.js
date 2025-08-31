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
    },
    methods: {
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
