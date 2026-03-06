import '../bootstrap'; 
import { createApp } from 'vue';
import Swal from "sweetalert2";

const appDashboard = createApp({
    data() {
        return {
            // Variables de estado
            totalProyectos: 0, 
            totalAsignadas: 0,
            totalEntregadas: 0,
            totalFinalizadas: 0,
            totalCorregidas: 0,
            idDocente: null,

            totalTareas: 0,
            proyectosAtrasados: 0,
            proyectosAvalados: 0,
            proyectosActivos: 0,
            proyectosFinalizados:0,
            participacion: [],
            estudiantes: 0,
            proyectosGeneral: 0,
            tareas: [],
            listarProyectos: [],
            versiones: [],
            porcentajeProyecto: [],
            // Instancias de Chart.js
            graficoDona: null,
            graficoFacultades: null,
            
        }
    },
    mounted() {

        const input = document.getElementById('id_docente_sesion');
        this.idDocente = input.value;

        
        this.cargarDashboard();

        Echo.channel('dashboard.creada')
            .listen('.DashboardDataEvent', (e) => {
                this.cargarDashboard(); 

            this.actualizarGraficoDona(
                e.dashboard.totalAsignadas,
                e.dashboard.totalEntregadas,
                e.dashboard.totalFinalizadas,
                e.dashboard.totalCorregidas
            );
            
                this.initGraficoFacultades();
            });
    },
    methods: {
        initGraficoDona() {
            const ctx = document.getElementById('graficoDonaTareas');
            if (!ctx || this.totalTareas === 0) {
                return;
            }

            this.graficoDona = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Asignadas', 'Entregadas', 'Finalizadas', 'Corregir'],
                    datasets: [{
                        data: [this.totalAsignadas, this.totalEntregadas, this.totalFinalizadas, this.totalCorregidas],
                        backgroundColor: ['#dbd9d9', '#cff4fc', '#e1fccf', '#e2ab91'],
                        borderColor: ['#424141', '#055160', '#226005', '#602e05'],
                        borderWidth: 1.5,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Vital para controlar el tamaño con el div padre
                    cutout: '70%', // Grosor de la dona
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 20, usePointStyle: true }
                        }
                    },
                    layout: {
                        padding: { top: 10, bottom: 10 }
                    }
                },
                plugins: [{
                    id: 'textoCentro',
                    beforeDraw: (chart) => {
                        const { width, height, ctx } = chart;
                        ctx.save();

                        ctx.font = 'bold 22px Arial';
                        ctx.fillStyle = '#333';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        ctx.font = 'bold 45px Arial';
                    ctx.fillStyle = '#424141';
                    ctx.fillText(this.totalTareas, width / 2, height / 2 -25);

                    ctx.font = '12px Arial';
                    ctx.fillStyle = '#999';
                    ctx.fillText('Tareas totales', width / 2, height / 2 + 0);

                        ctx.restore();
                    }
                }]

            });
        },

        actualizarGraficoDona(asignadas, entregadas, finalizada, corregir) {
            // 1. Actualizamos las variables de Vue para que las tarjetas cambien
            this.totalAsignadas     = asignadas;
            this.totalEntregadas    = entregadas;
            this.totalFinalizadas   = finalizada;
            this.totalCorregidas    = corregir

            // 2. Verificamos que el gráfico exista
            if (this.graficoDona) {
                // 3. Actualizamos los datos internos de Chart.js
                this.graficoDona.data.datasets[0].data = [asignadas, entregadas, finalizada, corregir];
                
                // 4. Renderizamos los cambios
                this.graficoDona.update();
            } else {
                // Si el evento llega antes de que el gráfico se cree, lo inicializamos
                this.initGraficoDona();
            }
        },

        cargarDashboard() {
            axios.get('/dashboard/data')
                .then(res => {
                    this.estudiantes            = res.data.estudiantes;
                    this.totalProyectos         = res.data.totalProyectos;
                    this.totalAsignadas         = res.data.totalAsignadas;
                    this.totalEntregadas        = res.data.totalEntregadas;
                    this.totalFinalizadas       = res.data.totalFinalizadas;
                    this.totalCorregidas        = res.data.totalCorregidas;
                    this.proyectosActivos       = res.data.proyectosActivos;
                    this.proyectosFinalizados   = res.data.proyectosFinalizados;
                    this.proyectosAtrasados     = res.data.proyectosAtrasados;
                    this.proyectosAvalados      = res.data.proyectosAvalados;
                    this.participacion          = res.data.participacion;
                    this.proyectosGeneral       = res.data.totalProyectosGeneral;
                    this.totalTareas            = res.data.totalTareas;
                    this.tareas                 = res.data.tareas;
                    this.listarProyectos        = res.data.listarProyectos;
                    this.versiones              = res.data.versiones;
                    this.porcentajeProyecto     = res.data.porcentajeProyecto;
                    this.$nextTick(() => {
                        this.actualizarGraficoDona(
                            res.data.totalAsignadas,
                            res.data.totalEntregadas,
                            res.data.totalFinalizadas,
                            res.data.totalCorregidas
                        );
                        this.initGraficoFacultades();
                    });
                })
                .catch(error => {
                    console.error("Error al refrescar el dashboard:", error);
                });
        },

        initGraficoFacultades() {
            const ctx = document.getElementById('graficoFacultades');
            if (!ctx) return;

            const labels = this.participacion.map(p => p.facultad);
            const data = this.participacion.map(p => p.porcentaje);

            if (this.graficoFacultades) {
                this.graficoFacultades.data.labels = labels;
                this.graficoFacultades.data.datasets[0].data = data;
                this.graficoFacultades.update();
                return;
            }

            this.graficoFacultades = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        borderRadius: 5,
                        barThickness: 5,
                        backgroundColor: '#b3eb8b',
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                            tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(71, 71, 71, 0.8)', 
                            titleFont: { size: 12 },
                            bodyFont: { size: 12 },
                            callbacks: {
                                title: (items) => {
                                    
                                    return this.participacion[items[0].dataIndex].facultad;
                                },
                                label: (context) => {
                                    return ` Participación: ${context.raw}%`;
                                }
                            }
                        } },
                    scales: {
                        x: { display: false, beginAtZero: true },
                        y: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { 
                                weight: 'bold',
                                size: 10 
                            } }
                        }
                    },
                    layout: { padding: { right: 32 } }
                },
                plugins: [{
                    id: 'labelsAlFinal',
                    afterDatasetsDraw(chart) {
                        const { ctx, data } = chart;
                        ctx.save();
                        ctx.font = 'bold 10px Arial';
                        ctx.fillStyle = '#333';
                        ctx.textAlign = 'left';
                        ctx.textBaseline = 'middle';
                        
                        chart.getDatasetMeta(0).data.forEach((bar, index) => {
                            const valor = data.datasets[0].data[index];
                            ctx.fillText(`${valor}%`, bar.x + 5, bar.y);
                        });
                    }
                }]
            });
        },
        

    } 
});

appDashboard.mount('#app_general');