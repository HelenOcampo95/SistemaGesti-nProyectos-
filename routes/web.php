<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\UsuariosController;
use App\Models\Categorias;
use App\Models\Proyecto;
use App\Models\Role;
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


Route::get('/categoria/select-categoria', [ProyectoController::class, 'traerCategoria']);
Route::get('/usuarios/select-usuarios', [ProyectoController::class, 'traerUsuario']);


Route::post('/asignar-tarea', [TareasController::class, 'asignarTarea' ]);
Route::get('/listar-tareas', [TareasController::class, 'listarTareas']);
Route::delete('/eliminar-tarea/{id_tarea}', [TareasController::class, 'eliminarTarea']);
Route::post('/actualizar-tarea/{id_tarea}', [TareasController::class, 'actualizarTarea']);
Route::get('/tarea/{id_tarea}', [TareasController::class, 'detalleTarea'])->name('tarea');
Route::post('/entregar-tarea/{id_tarea}', [TareasController::class, 'entregarTarea']);

});

/** Logout (POST, protegido) */
Route::post('/logout', [AutenticacionController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
    



