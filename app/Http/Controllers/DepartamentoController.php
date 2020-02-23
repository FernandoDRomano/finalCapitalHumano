<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\NivelDepartamento;
use App\Organizacion;
use App\Http\Requests\SaveDepartamentoRequest;
use App\Http\Controllers\OrganizacionController;
use RealRashid\SweetAlert\Facades\Alert;

class DepartamentoController extends Controller
{

    public function index(Request $request, $organizacion_id)
    {
        //Busco la organizacion
        $organizacion = Organizacion::findOrFail($organizacion_id);

        if ($request->buscar == null) {
            //Si el request es nulo traigo todas los departamentos que pertenezcan a la organizacion
            $departamentos = Departamento::where('organizacion_id', $organizacion->id)->orderBy('nivel_departamento_id', 'ASC')->paginate(10);
        }else{
            //Si el request trae una busqueda, busco la Departamento que pertenece a la organizacion y la devuelvo
            $departamentos = Departamento::search($request->buscar)->where('organizacion_id', $organizacion->id)->orderBy('id', 'ASC')->paginate(10);
        }

        return view('departamentos.index')->with(['departamentos' => $departamentos, 'organizacion' => $organizacion]);

    }

    public function store(Request $request, $organizacion_id)
    {
        //Creo el departamento
        $departamento = New Departamento;
        $dependeDe = null;
        //Asigno los valores
        $departamento->nombre = $request->nombre;
        $departamento->organizacion_id = $request->organizacion_id;
        $departamento->nivel_departamento_id = $request->selectNivelDepartamento;

        if ($request->selectDependeDe != "null") {
            $dependeDe = $request->selectDependeDe;
        }

        $departamento->depende_departamento_id = $dependeDe;

        $departamento->save();

        if ($departamento->save()) {
            $mensaje = "El Departamento " . $departamento->nombre . " fue registrado con Exito.";
            Alert::success('Departamento Registrado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('departamentos.index', $organizacion_id);
        }

    }


    public function show($organizacion_id, $departamento_id)
    {
        dd($departamento_id);
    }


    public function update(Request $request, $organizacion_id, $departamento_id)
    {
        //Creo el departamento
        $departamento = Departamento::findOrFail($departamento_id);
        $dependeDe = null;
        //Asigno los valores
        $departamento->nombre = $request->nombre;
        /*
            COMO NO VOY A MODIFICAR EL NIVEL NO LO ACTUALIZO, ADEMAS NO LLEGA ESTE VALOR
            YA QUE EN EL FRONTEND PUSE disabled EL SELECT DE NIVELES
            $departamento->nivel_departamento_id = $request->selectNivelDepartamento;

        */

        if ($request->selectDependeDe != "null") {
            $dependeDe = $request->selectDependeDe;
        }

        $departamento->depende_departamento_id = $dependeDe;

        $departamento->save();

        if ($departamento->save()) {
            $mensaje = "El Departamento " . $departamento->nombre . " fue actualizado con Exito.";
            Alert::success('Departamento Actualizado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('departamentos.index', $organizacion_id);
        }
    }


    public function destroy($organizacion_id, $departamento_id)
    {
        //Buscar Departamento
        $departamento = Departamento::findOrFail($departamento_id);
        //Guardamos el msj
        $mensaje = $departamento->nombre . " fue eliminado correctamente.";
        //Eliminamos al Departamento
        $departamento->delete();
        //Imprimos el msj
        Alert::warning('Departamento Eliminado!', $mensaje);
        //Redireccionamos
        return redirect()->route('departamentos.index', $organizacion_id);
    }

    public function getDepartamento($organizacion_id, $departamento_id){
        //Busco el departamento
        $departamento = Departamento::findOrFail($departamento_id);
        return response()->json($departamento);
    }

    public function getDepartamentosDependientes($organizacion_id, $departamento_id){
        //Busco el departamento
        $departamento = Departamento::findOrFail($departamento_id);
        return response()->json($departamento->departamentos);
    }

    //Para obtener el nivel Superior
    public function getNivelSuperior($organizacion_id, $nivelDepartamento_id){
        //Busco el nivel
        $nivel = NivelDepartamento::findOrFail($nivelDepartamento_id);
        $nivelSuperior = NivelDepartamento::where('jerarquia', $nivel->jerarquia - 1)->get();
        return response()->json($nivelSuperior);
    }

    //Para obtener todos los departamentos de un nivel determinado
    public function getDepartamentosPorNivel($organizacion_id, $nivelDepartamento_id){
        //busco los departamentos
        $departamentos = Departamento::where('nivel_departamento_id', $nivelDepartamento_id)->where('organizacion_id', $organizacion_id)->get();
        return response()->json($departamentos);
    }

    //Para obtener todos los nivesles departamentales
    public function getNivelesDepartamentales($organizacion_id){
        //Busco los niveles
        $niveles = NivelDepartamento::orderBy('jerarquia', 'ASC')->get();
        //Retorno los niveles departamentales
        return response()->json($niveles);
    }

}
