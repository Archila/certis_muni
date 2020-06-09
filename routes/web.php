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

Route::get('/home', function () {
    return view('home');
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

//Supervisores
Route::get('supervisor', 'SupervisorController@index')->name('supervisor.index');
Route::get('supervisor/crear', 'SupervisorController@crear')->name('supervisor.crear');
Route::get('supervisor/{id}/editar', 'SupervisorController@editar')->name('supervisor.editar');
Route::get('supervisor/{id}/ver', 'SupervisorController@ver')->name('supervisor.ver');
Route::post('supervisor', 'SupervisorController@guardar')->name('supervisor.guardar');
Route::put('supervisor/{id}', 'SupervisorController@actualizar')->name('supervisor.actualizar');
Route::delete('supervisor', 'SupervisorController@eliminar')->name('supervisor.eliminar');

//Supervisores
Route::get('supervisor', 'SupervisorController@index')->name('supervisor.index');
Route::get('supervisor/crear', 'SupervisorController@crear')->name('supervisor.crear');
Route::get('supervisor/{id}/editar', 'SupervisorController@editar')->name('supervisor.editar');
Route::get('supervisor/{id}/ver', 'SupervisorController@ver')->name('supervisor.ver');
Route::post('supervisor', 'SupervisorController@guardar')->name('supervisor.guardar');
Route::put('supervisor/{id}', 'SupervisorController@actualizar')->name('supervisor.actualizar');
Route::delete('supervisor', 'SupervisorController@eliminar')->name('supervisor.eliminar');

//TipoEmpresa
Route::get('tipo_empresa', 'TipoEmpresaController@index')->name('tipo_empresa.index');
Route::get('tipo_empresa/crear', 'TipoEmpresaController@crear')->name('tipo_empresa.crear');
Route::get('tipo_empresa/{id}/editar', 'TipoEmpresaController@editar')->name('tipo_empresa.editar');
Route::get('tipo_empresa/{id}/ver', 'TipoEmpresaController@ver')->name('tipo_empresa.ver');
Route::post('tipo_empresa', 'TipoEmpresaController@guardar')->name('tipo_empresa.guardar');
Route::put('tipo_empresa/{id}', 'TipoEmpresaController@actualizar')->name('tipo_empresa.actualizar');
Route::delete('tipo_empresa', 'TipoEmpresaController@eliminar')->name('tipo_empresa.eliminar');

//Empresas
Route::get('empresa', 'EmpresaController@index')->name('empresa.index');
Route::get('empresa/crear', 'EmpresaController@crear')->name('empresa.crear');
Route::get('empresa/{id}/editar', 'EmpresaController@editar')->name('empresa.editar');
Route::get('empresa/{id}/ver', 'EmpresaController@ver')->name('empresa.ver');
Route::post('empresa', 'EmpresaController@guardar')->name('empresa.guardar');
Route::put('empresa/{id}', 'EmpresaController@actualizar')->name('empresa.actualizar');
Route::delete('empresa', 'EmpresaController@eliminar')->name('empresa.eliminar');