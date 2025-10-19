<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareasController;
use App\Models\Categorias;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('iniciar_sesion.formulario_login');
});


Route::post('/iniciar-sesion', [ AutenticacionController::class, 'iniciarSesion'])->name('iniciar.sesion');
Route::get('/registrarme', [AutenticacionController::class, 'vistaRegistrarme'])->name('registrarme');

Route::post('/registrarme', [AutenticacionController::class, 'registrarme'])->name('registrarme.registrarme');


//Proyecto
Route::get('/ver-proyecto',[ProyectoController::class, 'verProyecto'])->name('proyecto');
Route::post('/proyectos', [ProyectoController::class, 'registrarProyecto']);
Route::get('/detalle/{id_proyecto}', [ProyectoController::class, 'detalleProyecto'])->name('detalle');
Route::post('/actualizar-proyecto', [ProyectoController::class, 'actualizarProyecto'])->name('proyecto.actualizar');
Route::get('/select-proyecto', [ProyectoController::class, 'selectProyecto']);

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


