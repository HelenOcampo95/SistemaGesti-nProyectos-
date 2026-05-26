<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VersionesController;
use App\Models\Categorias;
use App\Models\Proyecto;
use App\Models\Role;
use App\Models\Tareas;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\PermissionRegistrar;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/limpiar-cache', function () {

    try {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        return 'Caché reestablecido';
    }catch (Exception $exception) {
        return $exception->getMessage();
    }

});

Route::get('/', function () {
    return view('iniciar_sesion.formulario_login');
})->name('login');

Route::post('/iniciar-sesion', [ AutenticacionController::class, 'iniciarSesion'])->name('iniciar.sesion');
Route::get('/registrarme', [AutenticacionController::class, 'vistaRegistrarme'])->name('registrarme');

Route::post('/registrarme', [AutenticacionController::class, 'registrarme'])->name('registrarme.registrarme');
Route::post('/logout', [AutenticacionController::class, 'logout'])->name('logout');

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'verDashboard'])->name('dashboard');
Route::get('/dashboard/data', [DashboardController::class, 'obtenerDashboardData']);

//Roles
Route::get('/select-rol', [UsuariosController::class, 'selectRol']);

Route::middleware(['auth', 'nocache'])->group(function () {

Route::middleware('permisos:Crear_proyecto')->group( function() {
    //Proyecto
    Route::post('/proyectos', [ProyectoController::class, 'registrarProyecto']);
});
Route::get('/ver-proyecto',[ProyectoController::class, 'verProyecto'])->name('proyecto');
Route::get('/detalle/{id_proyecto}', [ProyectoController::class, 'detalleProyecto'])->name('detalle');
Route::post('/actualizar-proyecto', [ProyectoController::class, 'actualizarProyecto'])->name('proyecto.actualizar');
Route::get('/select-proyecto', [ProyectoController::class, 'selectProyecto']);
Route::post('/vincular-estudiante', [ProyectoController::class, 'vincularEstudiante']);
Route::post('/finalizar-proyecto/{id_proyecto}', [ProyectoController::class, 'finalizarProyecto']);
Route::post('/avalar-proyecto/{id_proyecto}', [ProyectoController::class, 'avalarProyecto']);
Route::get('/validar-correo/{correo}', [ProyectoController::class, 'validarCorreo']);
Route::get('/select-docentes-director', [ProyectoController::class, 'selectListarDocentesDirector']);
Route::get('/select-docentes-lider', [ProyectoController::class, 'selectListarDocentesLider']);
Route::post('/reasignarDocente', [ProyectoController::class, 'reasignarDocente']);

//Listar todos los proyectos para lideres y directores
Route::get('/ver-proyectos', [ProyectoController::class, 'verListadoProyecto'])->name('listarProyectos');
Route::get('/listar-proyectos', [ProyectoController::class, 'listarProyecto']);


//Tareas
Route::get('/ver-tareas', [TareasController::class, 'verTareas'])->name('tareas');

Route::get('/ver-categoria', [CategoriasController::class, 'verCategorias'])->name('categorias');
Route::get('/listar-categorias', [CategoriasController::class, 'listaCategorias']);
Route::post('/registrar/categoria', [CategoriasController::class, 'registrarCategoria']);
Route::get('/ver-categoria/{id_categoria}', [CategoriasController::class, 'categoriaPorId']);
Route::post('/actualizar-categoria/{id_categoria}', [CategoriasController::class, 'actualizarCategoria'] );
Route::post('/eliminar-categoria/{id_categoria}', [CategoriasController::class, 'eliminarCategoria']);
Route::post('/asignar-docente', [CategoriasController::class, 'asignarCategoriaDocente']);


Route::get('/categoria/select-categoria', [ProyectoController::class, 'traerCategoria']);
Route::get('/usuarios/select-usuarios', [ProyectoController::class, 'traerUsuario']);
Route::get('/docentes/select-docentes-director', [CategoriasController::class, 'selectListarDocentesDirector']);
Route::get('/docentes/select-docentes-lider', [CategoriasController::class, 'selectListarDocentesLider']);

Route::post('/asignar-tarea', [TareasController::class, 'asignarTarea' ]);
Route::get('/listar-tareas', [TareasController::class, 'listarTareas']);
Route::post('/eliminar-tarea/{id_tarea}', [TareasController::class, 'eliminarTarea']);
Route::post('/actualizar-tarea/{id_tarea}', [TareasController::class, 'actualizarTarea']);
Route::get('/tarea/{id_tarea}', [TareasController::class, 'detalleTarea'])->name('tarea');
Route::post('/entregar-tarea/{id_tarea}', [TareasController::class, 'entregarTarea']);
Route::post('/calificar-tarea/{id_tarea}', [TareasController::class, 'calificarTarea']);

Route::get('/version/{id_version}', [VersionesController::class, 'verVersion']);
Route::post('/aceptar-version/{id_version}', [VersionesController::class, 'aceptarVersion']);
Route::post('/rechazar-version/{id_version}', [VersionesController::class, 'rechazarVersion']);
Route::post('/registrar-version/{id_proyecto}', [VersionesController::class, 'registrarVersion']);

Route::get('/notificaciones/listar', [NotificacionController::class, 'getNotificaciones']);
Route::post('/notificaciones/leer/{id}', [NotificacionController::class, 'marcarComoLeida']);

Route::get('/eventos', [EventosController::class, 'verEventos'])->name('eventos');
Route::post('/registrar-evento', [EventosController::class, 'registrarEvento']);
Route::get('/seleccionar-categoria', [EventosController::class, 'verCategorias']);

Route::get('/listar-evento', [EventosController::class, 'listaEventos']);
Route::post('/actualizar-evento/{id_evento}', [EventosController::class, 'actualizarEvento'] );
Route::post('/eliminar-evento/{id_evento}', [EventosController::class, 'eliminarEvento']);

Route::get('/usuarios', [UsuariosController::class, 'verUsuarios'])->name('usuarios');
Route::get('/listar-usuarios', [UsuariosController::class, 'listarUsuarios']);
});

/** Logout (POST, protegido) */
Route::post('/logout', [AutenticacionController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
    



