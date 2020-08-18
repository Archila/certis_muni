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
    return view('welcome');
})->name('home');

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
Route::get('empresa/{id}/encargado', 'EmpresaController@encargado')->name('empresa.encargado');

//Encargado
Route::get('encargado', 'EncargadoController@index')->name('encargado.index');
Route::get('encargado/crear', 'EncargadoController@crear')->name('encargado.crear');
Route::get('encargado/{id}/editar', 'EncargadoController@editar')->name('encargado.editar');
Route::get('encargado/{id}/ver', 'EncargadoController@ver')->name('encargado.ver');
Route::post('encargado', 'EncargadoController@guardar')->name('encargado.guardar');
Route::put('encargado/{id}', 'EncargadoController@actualizar')->name('encargado.actualizar');
Route::delete('encargado', 'EncargadoController@eliminar')->name('encargado.eliminar');

//Area
Route::get('area', 'AreaController@index')->name('area.index');
Route::get('area/crear', 'AreaController@crear')->name('area.crear');
Route::get('area/{id}/editar', 'AreaController@editar')->name('area.editar');
Route::get('area/{id}/ver', 'AreaController@ver')->name('area.ver');
Route::post('area', 'AreaController@guardar')->name('area.guardar');
Route::put('area/{id}', 'AreaController@actualizar')->name('area.actualizar');
Route::delete('area', 'AreaController@eliminar')->name('area.eliminar');

//Practica
Route::get('practica', 'PracticaController@index')->name('practica.index');
Route::get('solicitud', 'PracticaController@solicitud')->name('practica.solicitud');
Route::post('respuesta', 'PracticaController@respuesta')->name('practica.respuesta');

//Oficio
Route::get('oficio/crear', 'OficioController@crear')->name('oficio.crear');
Route::get('oficio/{id}/editar', 'OficioController@editar')->name('oficio.editar');
Route::get('oficio/{id}/ver', 'OficioController@ver')->name('oficio.ver');
Route::get('oficio/{id}/pdf', 'OficioController@pdf')->name('oficio.pdf');
Route::get('oficio/{id}/revisar', 'OficioController@revisar')->name('oficio.revisar');
Route::get('oficio/{id}/respuesta', 'OficioController@respuesta_pdf')->name('oficio.respuesta');
Route::post('oficio', 'OficioController@guardar')->name('oficio.guardar');
Route::post('oficio/validar', 'OficioController@validar')->name('oficio.validar');
Route::post('oficio/rechazar', 'OficioController@rechazar')->name('oficio.rechazar');
Route::put('oficio/{id}', 'OficioController@actualizar')->name('oficio.actualizar');
Route::delete('oficio', 'OficioController@eliminar')->name('oficio.eliminar');

//Bitacora
Route::get('bitacora', 'BitacoraController@index')->name('bitacora.index');
Route::get('bitacora_ind', 'BitacoraController@individual')->name('bitacora.individual');
Route::get('bitacora/crear', 'BitacoraController@crear')->name('bitacora.crear');
Route::get('bitacora/{id}/editar', 'BitacoraController@editar')->name('bitacora.editar');
Route::get('bitacora/{id}/ver', 'BitacoraController@ver')->name('bitacora.ver');
Route::post('bitacora', 'BitacoraController@guardar')->name('bitacora.guardar');
Route::put('bitacora/{id}', 'BitacoraController@actualizar')->name('bitacora.actualizar');
Route::put('bitacora/fecha_extension/{id}', 'BitacoraController@fecha_extension')->name('bitacora.fecha_extension');
Route::put('bitacora/fecha_inicio/{id}', 'BitacoraController@fecha_inicio')->name('bitacora.fecha_inicio');
Route::put('bitacora/puesto/{id}', 'BitacoraController@puesto')->name('bitacora.puesto');
Route::delete('bitacora', 'BitacoraController@eliminar')->name('bitacora.eliminar');
Route::get('bitacora/{id}/folio/crear', 'BitacoraController@crear_folio')->name('bitacora.crear_folio');
Route::get('bitacora/{id}/pdf', 'BitacoraController@pdf')->name('bitacora.pdf');
Route::post('bitacora/oficio/{id}', 'BitacoraController@oficio')->name('bitacora.oficio');
Route::post('bitacora/validar/{id}', 'BitacoraController@validar')->name('bitacora.validar');
Route::get('bitacora/{id}/revisar', 'BitacoraController@revisar')->name('bitacora.revisar');
Route::post('bitacora/{id}/revision', 'BitacoraController@revision')->name('bitacora.revision');

//Folio
Route::get('folio', 'FolioController@index')->name('folio.index');
Route::get('folio/crear', 'FolioController@crear')->name('folio.crear');
Route::get('folio/{id}/editar', 'FolioController@editar')->name('folio.editar');
Route::get('folio/{id}/ver', 'FolioController@ver')->name('folio.ver');
Route::post('folio', 'FolioController@guardar')->name('folio.guardar');
Route::put('folio/{id}', 'FolioController@actualizar')->name('folio.actualizar');
Route::delete('folio', 'FolioController@eliminar')->name('folio.eliminar');

//Revision
Route::get('revision', 'RevisionController@index')->name('revision.index');
Route::get('revision/crear', 'RevisionController@crear')->name('revision.crear');
Route::get('revision/{id}/editar', 'RevisionController@editar')->name('revision.editar');
Route::get('revision/{id}/ver', 'RevisionController@ver')->name('revision.ver');
Route::post('revision', 'RevisionController@guardar')->name('revision.guardar');
Route::put('revision/{id}', 'RevisionController@actualizar')->name('revision.actualizar');
Route::delete('revision', 'RevisionController@eliminar')->name('revision.eliminar');

//PDF
Route::get('pdf', 'PDFController@index')->name('pdf.index');
Route::get('pdf/caratula/{id}', 'PDFController@caratula')->name('pdf.caratula');
Route::get('pdf/oficio/{id}', 'PDFController@oficio')->name('pdf.oficio');
Route::get('pdf/folios/{id}', 'PDFController@folios')->name('pdf.folios');
Route::get('pdf/vacios/{id}', 'PDFController@vacios')->name('pdf.vacios');

//API
Route::post('api/folios_revisar', 'ApiController@folios_revisar')->name('api.folios_revisar');
Route::post('api/areas_empresa', 'ApiController@areas_empresa')->name('api.areas_empresa');
Route::post('api/encargados_area', 'ApiController@encargados_area')->name('api.encargados_area');
Route::post('api/encargados', 'ApiController@encargados')->name('api.encargados');
Route::post('api/crear_area', 'ApiController@crear_area')->name('api.crear_area');
Route::post('api/crear_encargado', 'ApiController@crear_encargado')->name('api.crear_encargado');

Route::get('/test', function () {
    
    $user = User::findOrFail(3);
    Gate::authorize('haveaccess', '{"roles":[ 1, 4 ]}' );
    $rol = Rol::findOrFail(2);
    return $rol->usuarios;
    
});