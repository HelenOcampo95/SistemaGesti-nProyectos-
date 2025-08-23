import { createStore } from "vuex";
import { activarLoadBtn, desactivarLoadBtn }  from './ayudas/Load'
import axios from "axios";

export default createStore({

    state: {
        // Modificar la OPF y demás objetivos
        idSolicitud: '',

        // Modificar la cantidad real producida de una producción
        cantidadRealProducida: '',
        materiasPrimasDevueltas: [],
        idProceso: '',
        unidadMedida: ''

    },

    mutations: {
        setIdSolicitud(state, idSolicitud) {
            state.idSolicitud = idSolicitud;
        },
        setIdProceso(state, idProceso) {
            state.idProceso = idProceso;
        },
        setMateriasPrimasDevueltas(state, materiasPrimasDevueltas) {
            state.materiasPrimasDevueltas = materiasPrimasDevueltas;
        },
        setCantidadRealProducida(state, cantidadRealProducida) {
            state.cantidadRealProducida = cantidadRealProducida;
        },
        agregarMateriaPrimaDevuelta(state, materiaPrimaDevuelta) {
           state.materiasPrimasDevueltas.push( materiaPrimaDevuelta );
        },
        eliminarMateriaPrimaDevuelta(state, index) {
            state.materiasPrimasDevueltas.splice(index, 1);
        }
    },

    actions: {
        setIdSolicitud(context, idSolicitud) {
            context.commit('setIdSolicitud', idSolicitud)
        },
        mostrarModalModificacionResultadoProduccion({ state, commit }, idBtn) {

            activarLoadBtn(idBtn);

            axios.get('/obtener-resultado-produccion-actual', {
                    params: {
                        idSolicitud: state.idSolicitud
                    }
                })
                .then( res => {

                    const datos = res.data;

                    commit('setCantidadRealProducida', datos.proceso_principal.cantidad_real_formateada );

                    const materiasPrimasDevueltasActualmente = datos.devolucion_materias_primas.map( materiaPrima => {

                        const cantidad = parseFloat(materiaPrima.pivot.cantidad_devuelta.replace('.', ','));

                        return {
                            id: materiaPrima.id,
                            cantidad: isNaN(cantidad) ? "NaN" : cantidad.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                            codigo: materiaPrima.codigo,
                            nombre: materiaPrima.nombre
                        }

                    })

                    commit('setMateriasPrimasDevueltas', materiasPrimasDevueltasActualmente)

                    $('#modal_modificar_resultado_produccion_component').modal('show');

                })
                .catch(() => {})
                .finally( () => {
                    desactivarLoadBtn(idBtn)
                })


        },
        setIdProceso(context, idProceso) {
            context.commit('setIdProceso', idProceso);
        },
        agregarMateriaPrimaDevuelta({ commit }, nuevaMateriaPrimaDevuelta ) {
            commit('agregarMateriaPrimaDevuelta', nuevaMateriaPrimaDevuelta)
        },
        eliminarMateriaPrimaDevuelta({ commit }, materiaPrimaDevueltaAEliminar) {
            commit('eliminarMateriaPrimaDevuelta', materiaPrimaDevueltaAEliminar)
        },
        guardarActualizacionFinalizacionProceso({commit, state}, idBtn)
        {

            activarLoadBtn(idBtn);

            axios.post('/supervisor/modificar-finalizacion-opf', {
                    idSolicitudProduccion: state.idSolicitud,
                    idProceso: state.idProceso,
                    cantidadRealProducida: state.cantidadRealProducida,
                    materiasPrimasDevueltas: state.materiasPrimasDevueltas
                })
                .then( res => {
                    swal({
                        title: '¡Perfecto!',
                        text: 'Los datos de producción han sido actualizados con éxito. ¡Excelente trabajo!',
                        icon: 'success',
                        button: 'Ver ordenes de produccion',
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then( res => {
                        if( res ) {
                            $('#modal_modificar_resultado_produccion_component').modal('hide');
                        }
                    })
                })
                .catch( error => {

                    let er = error.response;

                    if ( er.hasOwnProperty('data') ) {
                        if (er.data.hasOwnProperty('codigo')) {
                            switch (er.data.codigo) {

                                case 1000:

                                        swal({
                                            title: '¡Oops!',
                                            text: 'Almacén ya recibió el producto terminado, por ende no podemos actualizar el resultado de producción',
                                            icon: 'error',
                                            button: 'Cerrar este mensaje',
                                            closeOnClickOutside: false,
                                            closeOnEsc: false
                                        }).then( res => {
                                            if( res ) {
                                                $('#modal_modificar_resultado_produccion_component').modal('hide');
                                            }
                                        });
                                        return;

                                    break

                            }

                        }
                    }

                    swal({
                        title: '¡Oops!',
                        text: 'No pudimos continuar con la solicitud',
                        icon: 'error',
                        button: 'Cerrar este mensaje'
                    });

                })
                .finally( () => {
                    desactivarLoadBtn( idBtn );
                })


        }
    },

    getters: {
        // NO ELIMINAR, ya que la asignación de OPF utiliza el getter "getIdSolicitud"
        getIdSolicitud(state) {
            return state.idSolicitud;
        },
    }

});
