<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Carreras
Route::get('carrera', 'CarreraController@index')->name('carrera.index');
Route::get('carrera/crear', 'CarreraController@crear')->name('carrera.crear');
Route::get('carrera/{id}/editar', 'CarreraController@editar')->name('carrera.editar');
Route::get('carrera/{id}/ver', 'CarreraController@ver')->name('carrera.ver');
Route::post('carrera', 'CarreraController@guardar')->name('carrera.guardar');
Route::put('carrera/{id}', 'CarreraController@actualizar')->name('carrera.actualizar');
Route::delete('carrera', 'CarreraController@eliminar')->name('carrera.eliminar');

//Estudiantes
Route::get('estudiante', 'EstudianteController@index')->name('estudiante.index');
Route::get('estudiante/crear', 'EstudianteController@crear')->name('estudiante.crear');
Route::get('estudiante/{id}/editar', 'EstudianteController@editar')->name('estudiante.editar');
Route::get('estudiante/{id}/ver', 'EstudianteController@ver')->name('estudiante.ver');
Route::post('estudiante', 'EstudianteController@guardar')->name('estudiante.guardar');
Route::put('estudiante/{id}', 'EstudianteController@actualizar')->name('estudiante.actualizar');
Route::delete('estudiante', 'EstudianteController@eliminar')->name('estudiante.eliminar');

//Roles
Route::get('rol', 'RolController@index')->name('rol.index');
Route::get('rol/crear', 'RolController@crear')->name('rol.crear');
Route::get('rol/{id}/editar', 'RolController@editar')->name('rol.editar');
Route::get('rol/{id}/ver', 'RolController@ver')->name('rol.ver');
Route::post('rol', 'RolController@guardar')->name('rol.guardar');
Route::put('rol/{id}', 'RolController@actualizar')->name('rol.actualizar');
Route::delete('rol', 'RolController@eliminar')->name('rol.eliminar');
