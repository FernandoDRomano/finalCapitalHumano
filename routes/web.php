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
    Route::resource('personas', 'PersonaController');
    Route::get('getPersona/{id}' , [
        'uses' => 'PersonaController@getPersona'
    ]);

    /*

    //GRUPO DE RUTAS PARA CRUD DEPARTAMENTOS
    Route::resource('departamentos', 'DepartamentoController');
    Route::get('departamento/{id}' , [
        'uses' => 'DepartamentoController@getDepartamento'
    ]);

    ROUTA CREATE QUE ACEPTA EL PARAMETRO
    Route::get('departamentos/create/{id}' , [
        'uses' => 'DepartamentoController@create'
    ]);

    Route::get('departamentos/{nivel_id}', function (\App\Departamento $departamento) {
        return $departamento->only('id', 'nombre', 'dependeDe');
    });


    //GRUPO DE RUTAS PARA CRUD PUESTOS DE TRABAJOS
    Route::resource('puestosTrabajos', 'PuestoTrabajoController');
    Route::get('puestoTrabajo/{id}' , [
        'uses' => 'PuestoTrabajoController@getPuestoTrabajo'
    ]);

     */
