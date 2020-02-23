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

//GRUPO DE RUTAS PARA CRUD NIVELES DEPARTAMENTALES
Route::resource('nivelesDepartamentales', 'NivelDepartamentoController');
Route::get('getNivelDepartamental/{id}' , [
    'uses' => 'NivelDepartamentoController@getNivelDepartamental'
]);
Route::get('getNivelesDepartamentales' , [
    'uses' => 'NivelDepartamentoController@getNivelesDepartamentales'
]);

//GRUPO DE RUTAS PARA CRUD NIVELES PUESTOS
Route::resource('nivelesPuestos', 'NivelPuestoController');
Route::get('getNivelPuesto/{id}' , [
    'uses' => 'NivelPuestoController@getNivelPuesto'
]);
Route::get('getNivelesPuestos' , [
    'uses' => 'NivelPuestoController@getNivelesPuestos'
]);

//GRUPO DE RUTAS PARA CRUD PERSONAS
Route::resource('organizacion/{id}/personas', 'PersonaController');
Route::get('organizacion/{organizacion}/getPersona/{id}' , [
    'uses' => 'PersonaController@getPersona'
]);

//GRUPO DE RUTAS PARA CRUD PERSONAS
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
