import {createApp} from "vue/dist/vue.esm-bundler";

const appProyecto = createApp({
    data() {
        return {
            form: {
                nombre_proyecto: '',
                descripcion_proyecto: '',
                fecha_inicio: '',
                fecha_entrega: '',
                estado_proyecto: ''
            }
        }
    },
    methods: {

        registrarProyecto(){

            activarLoadBtn('btn_registrar_proyecto');

            axios.post('/proyectos', {
                    nombre: nombreProyecto
                })
                .then( res => {
                    toastr.success(`El cliente ${nombreProyecto} ha sido creado correctamente`);
                    $('#nombre_proyecto').val('');
                    $('#modal_registrar_proyecto').modal('hide');

                    this.tablaListadoDeClientes.draw();

                })
                .catch( error => {

                    const er = error.response;

                    if ( er.hasOwnProperty('data') ) {

                        if (er.data.hasOwnProperty('cliente_existe')) {
                            swal({
                                title: 'El cliente ya existe',
                                text: 'El cliente que ingresaste ya se encuentra registrado',
                                icon: 'error'
                            });

                            return;
                        }

                    }

                    swal({
                        title: '¡Ups!',
                        text: 'Por favor ingresa el nombre del nuevo cliente',
                        icon: 'error'
                    });

                })
                .finally( () => {
                    desactivarLoadBtn('btn_crear_nuevo_cliente');
                })
        }
    }
})

appProyecto.mount('#kt_app_main')