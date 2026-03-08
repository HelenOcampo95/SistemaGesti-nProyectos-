import './bootstrap';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// Opcional: Hacerlo disponible globalmente en la ventana para scripts en Blade
window.Chart = Chart;

const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');

// 2. Usamos ese ID para conectar el canal
if (userId) {
    window.Echo.private(`notificacion.creada.${userId}`)
        .listen('.NotificacionEvent', (e) => {
            actualizarContadorNotificaciones();

            axios.get('/notificaciones/listar')
                .then(response => {
                    document.getElementById('contenedor-notificaciones').innerHTML = response.data;
                })
                .catch  (error => {
                    console.error('Error al cargar las notificaciones', error);
                });

        });
} else {
    console.log("El usuario no está autenticado, no se activaron las notificaciones.");
}