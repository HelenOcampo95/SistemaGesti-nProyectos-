import '../bootstrap'; 
import { createApp } from 'vue';
import Swal from "sweetalert2";

const appDashboard = createApp({
    data() {
        return {
            // Variables de estado
            totalProyectos: 0, 
            totalPendientes: 0,
            totalEnProceso: 0,
            totalFinalizado: 0,
            idDocente: null,

            proyectosAtrasados: 0,
            proyectosAvalados: 0,
            proyectosActivos: 0,
            proyectosFinalizados:0,
            participacion: [],
            estudiantes: 0,

            // Instancias de Chart.js
            graficoDona: null,
            graficoFacultades: null
        }
    },
    mounted() {

        const input = document.getElementById('id_docente_sesion');
        this.idDocente = input.value;

        
        this.cargarDashboard();

        Echo.channel('dashboard.institucional')
            .listen('.DashboardDataEvent', (e) => {
                this.cargarDashboard(); 

            this.actualizarGraficoDona(
                e.dashboard.totalPendientes,
                e.dashboard.totalEnProceso,
                e.dashboard.totalFinalizado
            );
            this.participacion = e.dashboard.participacion;
            this.estudiantes = e.dashboard.estudiantes;
            this.initGraficoFacultades();

            // this.totalProyectos       = e.dashboard.totalProyectos;
            // this.proyectosActivos     = e.dashboard.proyectosActivos;
            // this.proyectosFinalizados = e.dashboard.proyectosFinalizados;
            // this.proyectosAtrasados   = e.dashboard.proyectosAtrasados;
            // this.proyectosAvalados    = e.dashboard.proyectosAvalados;
        });
    },
    methods: {
        initGraficoDona() {
            const ctx = document.getElementById('graficoDonaTareas');
            if (!ctx) return;

            this.graficoDona = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pendientes', 'En Proceso', 'Finalizadas'],
                    datasets: [{
                        data: [this.totalPendientes, this.totalEnProceso, this.totalFinalizado],
                        backgroundColor: ['#f8d7da', '#cff4fc', '#e1fccf'],
                        borderColor: ['#842029', '#055160', '#226005'],
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
                }
            });
        },

        actualizarGraficoDona(pendientes, enProceso, finalizadas) {
            // 1. Actualizamos las variables de Vue para que las tarjetas cambien
            this.totalPendientes = pendientes;
            this.totalEnProceso = enProceso;
            this.totalFinalizado = finalizadas;

            // 2. Verificamos que el gráfico exista
            if (this.graficoDona) {
                // 3. Actualizamos los datos internos de Chart.js
                this.graficoDona.data.datasets[0].data = [pendientes, enProceso, finalizadas];
                
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
                    // Esto actualiza las variables de Vue
                    Object.assign(this, res.data);

                    // Esto fuerza la creación o actualización del gráfico
                    this.actualizarGraficoDona(
                        res.data.totalPendientes, 
                        res.data.totalEnProceso, 
                        res.data.totalFinalizado
                    );
                    this.initGraficoFacultades(); 
                    
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
                        barThickness: 10,
                        backgroundColor: '#d3ebc2',
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
                    layout: { padding: { right: 30 } }
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
        }

    } 
});

appDashboard.mount('#app_general');