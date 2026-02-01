import './bootstrap';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// Opcional: Hacerlo disponible globalmente en la ventana para scripts en Blade
window.Chart = Chart;