<?php

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
    return view('inicio');
});

//GRUPO DE RUTAS PARA CRUD ORGANIZACIONES
Route::resource('organizaciones', 'OrganizacionController');
Route::get('getOrganizacion/{id}' , [
    'uses' => 'OrganizacionController@getOrganizacion'
]);
Route::get('getDatosDependientes/{id}' , [
    'uses' => 'OrganizacionController@getDatosDependientes'
]);

//GRUPO DE RUTAS PARA CRUD NIVELES DEPARTAMENTALES
Route::resource('nivelesDepartamentales', 'NivelDepartamentoController');
Route::get('getNivelDepartamental/{id}' , [
    'uses' => 'NivelDepartamentoController@getNivelDepartamental'
]);
Route::get('getNivelesDepartamentales' , [
    'uses' => 'NivelDepartamentoController@getNivelesDepartamentales'
]);
Route::get('getDepartamentosDependientes/{id}' , [
    'uses' => 'NivelDepartamentoController@getDepartamentosDependientes'
]);

//GRUPO DE RUTAS PARA CRUD NIVELES PUESTOS
Route::resource('nivelesPuestos', 'NivelPuestoController');
Route::get('getNivelPuesto/{id}' , [
    'uses' => 'NivelPuestoController@getNivelPuesto'
]);
Route::get('getNivelesPuestos' , [
    'uses' => 'NivelPuestoController@getNivelesPuestos'
]);
Route::get('getPuestosDependientes/{id}' , [
    'uses' => 'NivelPuestoController@getPuestosDependientes'
]);

//GRUPO DE RUTAS PARA CRUD PERSONAS
Route::resource('organizacion/{id}/personas', 'PersonaController');
Route::get('organizacion/{organizacion}/getPersona/{id}' , [
    'uses' => 'PersonaController@getPersona'
]);
Route::post('organizacion/{organizacion}/personas/crear', [
    'uses' => 'PersonaController@storeDesdePuestoDeTrabajo'
]);
Route::delete('organizacion/{organizacion}/personas/eliminar/{idPersona}', [
    'uses' => 'PersonaController@destroyDesdePuestoDeTrabajo'
]);

//GRUPO DE RUTAS PARA CRUD DEPARTAMENTOS
Route::resource('organizacion/{id}/departamentos', 'DepartamentoController');
Route::get('organizacion/{organizacion}/getDepartamento/{id}' , [
    'uses' => 'DepartamentoController@getDepartamento'
]);
Route::get('organizacion/{organizacion}/getNivelSuperior/{nivel}', [
    'uses' => 'DepartamentoController@getNivelSuperior'
]);
Route::get('organizacion/{organizacion}/getNivelesDepartamentales', [
    'uses' => 'DepartamentoController@getNivelesDepartamentales'
]);
Route::get('organizacion/{organizacion}/getDepartamentosPorNivel/{nivel}', [
    'uses' => 'DepartamentoController@getDepartamentosPorNivel'
]);
Route::get('organizacion/{organizacion}/getDepartamentosDependientes/{nivel}', [
    'uses' => 'DepartamentoController@getDepartamentosDependientes'
]);

//GRUPO DE RUTAS PARA CRUD DE PUESTOS DE TRABAJOS
Route::resource('organizacion/{organizacion}/puestosDeTrabajos', 'PuestoTrabajoController');
Route::get('organizacion/{organizacion}/getNivelesDePuestosDeTrabajos', [
    'uses' => 'PuestoTrabajoController@getNivelesDePuestosDeTrabajos'
]);
Route::get('organizacion/{organizacion}/getDepartamentos', [
    'uses' => 'PuestoTrabajoController@getDepartamentos'
]);
Route::get('organizacion/{organizacion}/getPuestoDeTrabajo/{id}', [
    'uses' => 'PuestoTrabajoController@getPuestoDeTrabajo'
]);
Route::get('organizacion/{organizacion}/getObligacionesDependientes/{id}', [
    'uses' => 'PuestoTrabajoController@getObligacionesDependientes'
]);
Route::get('organizacion/{organizacion}/getFuncionesDependientes/{id}', [
    'uses' => 'PuestoTrabajoController@getFuncionesDependientes'
]);
Route::post('organizacion/{organizacion}/puestosDeTrabajos/crear', [
    'uses' => 'PuestoTrabajoController@storeDesdeDepartamento'
]);
Route::delete('organizacion/{organizacion}/puestosDeTrabajos/eliminar/{id}', [
    'uses' => 'PuestoTrabajoController@destroyDesdeDepartamento'
]);
Route::put('organizacion/{organizacion}/puestosDeTrabajos/editar/{id}', [
    'uses' => 'PuestoTrabajoController@updateDesdeDepartamento'
]);

//GRUPO DE RUTAS PARA CRUD DE FUNCIONES
Route::resource('organizacion/{organizacion}/funciones', 'FuncionController');
Route::get('organizacion/{organizacion}/getPuestosDeTrabajos/{departamento}', [
    'uses' => 'FuncionController@getPuestosDeTrabajos'
]);
Route::get('organizacion/{organizacion}/getFuncion/{funcion}', [
    'uses' => 'FuncionController@getFuncion'
]);
Route::get('organizacion/{organizacion}/getPuesto/{puesto}', [
    'uses' => 'FuncionController@getPuesto'
]);
Route::post('organizacion/{organizacion}/funciones/crear', [
    'uses' => 'FuncionController@storeDesdePuestoDeTrabajo'
]);
Route::delete('organizacion/{organizacion}/funciones/eliminar/{id}', [
    'uses' => 'FuncionController@destroyDesdePuestoDeTrabajo'
]);
Route::put('organizacion/{organizacion}/funciones/editar/{id}', [
    'uses' => 'FuncionController@updateDesdePuestoDeTrabajo'
]);
//GRUPO DE RUTAS PARA CRUD DE OBLIGACIONES
Route::resource('organizacion/{organizacion}/obligaciones', 'ObligacionController');
Route::get('organizacion/{organizacion}/getPuestosDeTrabajos/{departamento}', [
    'uses' => 'ObligacionController@getPuestosDeTrabajos'
]);
Route::get('organizacion/{organizacion}/getObligacion/{funcion}', [
    'uses' => 'ObligacionController@getObligacion'
]);
Route::get('organizacion/{organizacion}/getPuesto/{puesto}', [
    'uses' => 'ObligacionController@getPuesto'
]);
Route::post('organizacion/{organizacion}/obligaciones/crear', [
    'uses' => 'ObligacionController@storeDesdePuestoDeTrabajo'
]);
Route::delete('organizacion/{organizacion}/obligaciones/eliminar/{id}', [
    'uses' => 'ObligacionController@destroyDesdePuestoDeTrabajo'
]);
Route::put('organizacion/{organizacion}/obligaciones/editar/{id}', [
    'uses' => 'ObligacionController@updateDesdePuestoDeTrabajo'
]);

//GRUPO DE RUTAS PARA ASIGNAR LAS PERSONAS A LOS PUESTOS DE TRABAJOS
Route::resource('organizacion/{organizacion}/asignaciones', 'AsignacionController');
Route::get('organizacion/{organizacion}/getPuestosDeTrabajos/{departamento}', [
    'uses' => 'AsignacionController@getPuestosDeTrabajos'
]);
Route::get('organizacion/{organizacion}/getAsignacion/{asignacion}', [
    'uses' => 'AsignacionController@getAsignacion'
]);
Route::get('organizacion/{organizacion}/getPersonas/{puestoDeTrabajo}', [
    'uses' => 'AsignacionController@getPersonas'
]);

Route::post('organizacion/{organizacion}/asignaciones/crear', [
    'uses' => 'AsignacionController@storeDesdePersona'
]);
Route::delete('organizacion/{organizacion}/asignaciones/eliminar/{id}', [
    'uses' => 'AsignacionController@destroyDesdePersona'
]);
Route::get('organizacion/{organizacion}/personas/{persona}/getPuestosDeTrabajosLibres/{departamento_id}', [
    'uses' => 'AsignacionController@getPuestosDeTrabajosLibres'
]);

//Organigrama
Route::get('organizacion/{organigrama}/getOrganigrama', [
    'uses' => 'OrganizacionController@getOrganigrama'
]);

Route::get('organizaciones/{organizacion}/getHijos', [
    'uses' => 'OrganizacionController@getHijos'
]);
