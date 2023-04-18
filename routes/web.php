<?php

use App\User;
use App\Models\Rol;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Gate;

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

Route::get('/', 'InicioController@index')->name('inicio.index');

Route::get('/home', function () {
    return redirect('/');
})->name('home');

Auth::routes();

//Roles
Route::get('rol', 'RolController@index')->name('rol.index');
Route::get('rol/crear', 'RolController@crear')->name('rol.crear');
Route::get('rol/{id}/editar', 'RolController@editar')->name('rol.editar');
Route::get('rol/{id}/ver', 'RolController@ver')->name('rol.ver');
Route::post('rol', 'RolController@guardar')->name('rol.guardar');
Route::put('rol/{id}', 'RolController@actualizar')->name('rol.actualizar');
Route::delete('rol', 'RolController@eliminar')->name('rol.eliminar');

//Usuario
Route::get('user/cambiar', 'UsuarioController@cambiar')->name('usuario.cambiar');
Route::post('user/confirmar', 'UsuarioController@confirmar')->name('usuario.confirmar');
Route::get('user/nueva', 'UsuarioController@nueva')->name('usuario.nueva');
Route::post('user/actualizar', 'UsuarioController@actualizar')->name('usuario.actualizar');

//CERTIFICACIONES
Route::post('certi/subir-archivo', 'CertiController@subir_archivo')->name('certi.subir_archivo');
Route::get('certi/ver/{id}', 'CertiController@ver')->name('certi.ver');
Route::get('certi/inicio/{id}', 'CertiController@index')->name('certi.index');
Route::post('certi/aprobar', 'CertiController@aprobar')->name('certi.aprobar');


Route::get('/test', function () {
    
    $user = User::findOrFail(3);
    Gate::authorize('haveaccess', '{"roles":[ 1, 4 ]}' );
    $rol = Rol::findOrFail(2);
    return $rol->usuarios;
    
});