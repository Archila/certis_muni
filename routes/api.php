<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Funciores con usuarios
Route::prefix('usuario')->name('usuario/')->group(static function() {
    Route::get('/',                                 'UsuarioController@index')->name('show');
    Route::post('/',                                'UsuarioController@store')->name('store');
    Route::delete('/{id}',                          'UsuarioController@destroy')->name('destroy');
    Route::get('/logout',                           'LoginNewController@logout')->name('logout');
    Route::post('/login',                           'LoginNewController@authenticate')->name('login');
});
