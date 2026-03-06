import { createApp } from 'vue';
import { activarLoadBtn, desactivarLoadBtn } from "@/store/ayudas/Load";
import Swal from "sweetalert2"; // 👈 Importamos SweetAlert2

const appProyectos = createApp({
    data() {
        return {
            colaboradores: [],
            nuevo_correo: '',
            formProyecto : {
                editNomProyecto: '',
                editDesProyecto: '',
                id_proyecto: '',
                nombre_proyecto: '',
                descripcion_proyecto: '',
                fecha_inicio: '',
                fecha_entrega: '',
                estado_proyecto: '',
                id_categoria: '',
                nombre_categoria: ''
            },
            limites: {
                editNomProyecto: 45,
                editDesProyecto: 200
            },
            
        }
    },
    

    mounted() {
    
    },
    computed:{
        excedidos(){
            return {
                nombre: this.formProyecto.editNomProyecto.length >= this.limites.editNomProyecto,
                descripcion: this.formProyecto.editDesProyecto.length >= this.limites.editDesProyecto
            }
        }
    },
    methods: {
        prepararEdicion(proyecto){
            if (!proyecto) {
                console.error("No se recibió información del proyecto");
                return;
            }

            this.formProyecto.nombre_proyecto       = proyecto.nombre_proyecto;
            this.formProyecto.descripcion_proyecto  = proyecto.descripcion_proyecto;
            this.formProyecto.fecha_inicio          = proyecto.fecha_inicio ? proyecto.fecha_inicio.substring(0, 10) : '';
            this.formProyecto.fecha_entrega         = proyecto.fecha_entrega ? proyecto.fecha_entrega.substring(0, 10) : '';
            this.formProyecto.estado_proyecto       = proyecto.estado_proyecto;
            this.formProyecto.id_categoria          = proyecto.id_categoria;
            this.formProyecto.nombre_categoria      = proyecto.categoria.nombre_categoria;
        },
        actualizarProyecto() {
        let id_proyecto = document.getElementById('id_proyecto').value;
            
        const formData = new FormData(document.getElementById('formulario_editar_proyecto'));
        formData.append('id_proyecto', id_proyecto);

            axios.post('/actualizar-proyecto', formData)
                .then(res => {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'La categoria fue actualizada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.reload(); 
                    });

                    $('#modal_editar_proyecto').modal('hide');
                    $('#formulario_editar_proyecto')[0].reset();
                })
                .catch(error => {
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
            });
            
        },
        agregarColaborador() {
            const correo = this.nuevo_correo.trim().toLowerCase();
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
            if (correo === '') return;
                    
                if (!regex.test(correo)) {
                    return Swal.fire('Correo inválido', 'Por favor ingresa un email real', 'warning');
                }
        
                if (this.colaboradores.includes(correo)) {
                    return Swal.fire('Repetido', 'Este correo ya está en la lista', 'info');
                }
        
                this.colaboradores.push(correo);
                this.nuevo_correo = '';
        },
        
        eliminarColaborador(index) {
            this.colaboradores.splice(index, 1);
        },
        vincularEstudiante() {
            let id_proyecto = $('#id_proyecto').val();
            activarLoadBtn('btn_vincular_estudiante');
            
            // Recolectamos datos manualmente para incluir el array de colaboradores
            const datos = {
                id_proyecto: id_proyecto,
                colaboradores: this.colaboradores // <--- Array de Vue
            };
        
            axios.post('/vincular-estudiante', datos)
                .then(response => {
                    Swal.fire('¡Éxito!', 'El colaborador fue registrado con éxito', 'success')
                        .then(() => window.location.reload());
                    })
                .catch(error => {
                    console.error(error);
                        Swal.fire('Error', 'No se pudo vincular el proyecto', 'error');
                    })
                .finally(() => {
                    desactivarLoadBtn('btn_vincular_estudiante');
                });
            }
        
    }

});
appProyectos.mount('#app_general');