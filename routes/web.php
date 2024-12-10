<?php

use Lib\Route;
use App\Controllers\HomeController;
use App\Controllers\RegistroController;
use App\Controllers\UsuarioController;

// Indicaremos la clase del controlador y el método a ejecutar. Solo algunas rutas están implementadas
// Tendremos rutas para get y pst, así como parámetros opcionales indicados con : que podrán
// ser recuperados por un mismo controlador. Por ejemplo, /curso/:variable y /curso/ruta1 usan el mismo controlador
// y :variable se trata como un parámetro ajeno a la ruta
Route::get('/', [HomeController::class, 'index']);
Route::post('/', [HomeController::class, 'index']);
Route::get('cerrar', [UsuarioController::class, 'cerrarSesion']);
Route::get('/base', [UsuarioController::class, 'crearBase']);
Route::post('/registro', [RegistroController::class, 'registro']);
Route::get('/usuario/:id', [UsuarioController::class, 'show']);
Route::post('/usuario/:id', [UsuarioController::class, 'show']);
Route::get('/gestion', [UsuarioController::class, 'gestionUser']);
Route::post('/gestion', [UsuarioController::class, 'gestionUser']);
Route::get('/usuario/borrar/:id', [UsuarioController::class, 'borrar']);
Route::get('/usuario/editar/:id', [UsuarioController::class, 'editar']);
Route::post('/usuario/editar/:id', [UsuarioController::class, 'editar']);
 
Route::dispatch();