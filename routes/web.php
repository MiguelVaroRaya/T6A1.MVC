<?php

use Lib\Route;
use App\Controllers\HomeController;
use App\Controllers\UsuarioController;

// Indicaremos la clase del controlador y el método a ejecutar. Solo algunas rutas están implementadas
// Tendremos rutas para get y pst, así como parámetros opcionales indicados con : que podrán
// ser recuperados por un mismo controlador. Por ejemplo, /curso/:variable y /curso/ruta1 usan el mismo controlador
// y :variable se trata como un parámetro ajeno a la ruta
Route::get('/', [HomeController::class, 'index']);
Route::post('/', [HomeController::class, 'index']);
Route::get('cerrar', [UsuarioController::class, 'cerrarSesion']);
Route::get('/base', [UsuarioController::class, 'crearBase']);
Route::post('/registro', [UsuarioController::class, 'registro']);
Route::get('/gestion', [UsuarioController::class, 'gestionUser']);
Route::post('/gestion', [UsuarioController::class, 'gestionUser']);
Route::get('/usuario/nuevo', [UsuarioController::class, 'create']);
Route::get('/usuario', [UsuarioController::class, 'index']);
Route::get('/usuario/pruebas', [UsuarioController::class, 'pruebasSQLQueryBuilder']);
Route::get('/usuario/:id', [UsuarioController::class, 'show']);
Route::post('/usuario/:id', [UsuarioController::class, 'show']);
Route::get('/usuario/borrar/:id', [UsuarioController::class, 'borrar']);
Route::post('/usuario', [UsuarioController::class, 'store']);
Route::get('/contacto', [ContactoController::class, 'index']);
Route::get('/formulario', [FormularioController::class, 'index']);
Route::get('/curso', [CursoController::class, 'index']);
Route::get('/curso/ruta1', [CursoController::class, 'index']);
Route::get('/curso/:variable', [CursoController::class, 'index']);
Route::get('/otro/:variable1/:variable2/:variable3', [OtroController::class, 'index']);
 
Route::dispatch();