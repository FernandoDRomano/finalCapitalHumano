<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organizacion;
use App\Departamento;
use App\Http\Requests\SaveOrganizacionRequest;
use App\NivelDepartamento;
use Illuminate\Auth\Access\Response;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

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
        $organizacion = Organizacion::findOrFail($id);
        return view('organizaciones.show')->with('organizacion', $organizacion);
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

    public function getDatosDependientes($organizacion_id){
        $organizacion = Organizacion::findOrFail($organizacion_id);
        $departamentos = $organizacion->departamentos;
        $puestosDeTrabajos = $organizacion->puestosDeTrabajos;
        $personas = $organizacion->personas;
        return response()->json(['departamentos' => $departamentos,'personas' => $personas,'puestosDeTrabajos' => $puestosDeTrabajos]);
    }

    //PARA REALIZAR EL ORGANIGRAMA
    public function getOrganigrama($organizacion_id){
        //Busco los niveles departamentales
        $nivelesDepartamentales = NivelDepartamento::orderBy('jerarquia', 'ASC')->get();
        return response()->json($nivelesDepartamentales);
    }

    public function getHijos($organizacion_id){
        $departamentos = Departamento::where('organizacion_id', $organizacion_id)->select('id','nombre','depende_departamento_id')->get();
        return response()->json($departamentos);
    }

    /*
    public function getHijos($organizacion_id){
        //Busco el departamento del primer nivel
        $departamentos = Departamento::where('organizacion_id', $organizacion_id)->get();
        $departamentosPadres = [];

        foreach ($departamentos as $key => $departamento) {
            if($departamento->nivelDepartamento->jerarquia == 1){
                array_push($departamentosPadres, $departamento);
            }
        }

        //Recorro los departamentos hijos
        $departamentos = $this->recorrerHijos($departamentosPadres);

        //Retorno
        return response()->json($departamentos);
    }

    //Funcion recursiva para devolver todos los departamentos
    public function recorrerHijos($departamentoPadre){
            //Recorro el departamento
            foreach ($departamentoPadre as $value) {
                //Por cada departamento que viene en el arreglo vuelvo a llamar a la funcion recursiva
                $this->recorrerHijos($value->departamentos);
            }

        //Retorno el departamento con los hijos que va encontrando
        return $departamentoPadre;

    }
    */


}
