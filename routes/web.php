<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareasController;
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
    return view('welcome');//Aqui puedo agregar el iniciar_session para ver el login 
});
//Proyecto
Route::get('/ver-proyecto',[ProyectoController::class, 'verProyecto'])->name('proyecto');
Route::post('/proyectos', [ProyectoController::class, 'registrarProyecto']);
//Tareas
Route::get('/ver-tareas', [TareasController::class, 'verTareas'])->name('tareas');

Route::get('/ver-categoria', [CategoriasController::class, 'verCategorias'])->name('categorias');
Route::get('/listar-categorias', [CategoriasController::class, 'listaCategorias']);
Route::post('/registrar/categoria', [CategoriasController::class, 'registrarCategoria']);

Route::get('/categoria/select-categoria', [ProyectoController::class, 'traerCategoria']);
Route::get('/usuarios/select-usuarios', [ProyectoController::class, 'traerUsuario']);


