<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organizacion;
use App\Departamento;
use App\Http\Requests\SaveOrganizacionRequest;
use Illuminate\Auth\Access\Response;
use RealRashid\SweetAlert\Facades\Alert;

class OrganizacionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->buscar == null) {
            $organizaciones = Organizacion::orderBy('id', 'DESC')->paginate(10);
        }else{
            $organizaciones = Organizacion::search($request->buscar)->orderBy('id', 'ASC')->paginate(10);
        }

        return view('organizaciones.index')->with('organizaciones', $organizaciones);

    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        //PARA ALMACENAR LOS DATOS
        $organizacion = new Organizacion;
        //ASIGNO LOS VALORES
        $organizacion->nombre = $request->nombre;
        //ALMACENO EN LA BD
        $organizacion->save();

        //REDIRECCIONO AL INDEX DE LAS CATEGORIAS
        if ($organizacion->save()) {
            //MENSAJE FLASH
            $mensaje = "La Organización " . $organizacion->nombre . " fue registrada con Exito.";
            Alert::success('Organización Registrada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->action('OrganizacionController@index');
        }
    }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }


    public function update(SaveOrganizacionRequest $request, $id)
    {
        //Busco
        $organizacion = Organizacion::findOrFail($id);
        //Actualizo
        $organizacion->nombre = $request->nombre;
        $organizacion->save();

        if($organizacion->save()){
            $mensaje = "La Organización " . $organizacion->nombre . " fue actualizada correctamente.";
            Alert::info('Organización Actualizada!', $mensaje);
            return redirect()->action('OrganizacionController@index');
        }
    }


    public function destroy($id)
    {
        $organizacion = Organizacion::findOrFail($id);
        $mensaje = "La Organización " . $organizacion->nombre . " fue eliminada correctamente.";

        $organizacion->delete();

        Alert::warning('Organización Eliminada!', $mensaje);
        return redirect()->action('OrganizacionController@index');
    }

    public function getOrganizacion($id){
        //Busco la organización
        $organizacion = Organizacion::findOrFail($id);
        //la retorno al fetch
        return response()->json($organizacion);
    }


}
