<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Funcion;
use App\Organizacion;
use App\PuestoDeTrabajo;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class FuncionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $organizacion_id)
    {

        //Busco la organizacion
        $organizacion = Organizacion::findOrFail($organizacion_id);
        $departamentos = $organizacion->departamentos;

        if ($request->buscar == null) {

            $funciones = DB::table('funciones')
            ->join('puestos_de_trabajos', 'funciones.puesto_de_trabajo_id', '=', 'puestos_de_trabajos.id')
            ->join('departamentos', 'puestos_de_trabajos.departamento_id', '=', 'departamentos.id')
            ->join('organizaciones', 'departamentos.organizacion_id', '=', 'organizaciones.id')
            ->select('funciones.*', 'puestos_de_trabajos.nombre as puestoDeTrabajo', 'departamentos.nombre as departamento', 'organizaciones.nombre as organizacion')
            ->where('organizaciones.id' , $organizacion_id)
            ->orderBy('funciones.id', 'DESC')->paginate(10);

        }else{

            $funciones = DB::table('funciones')
            ->join('puestos_de_trabajos', 'funciones.puesto_de_trabajo_id', '=', 'puestos_de_trabajos.id')
            ->join('departamentos', 'puestos_de_trabajos.departamento_id', '=', 'departamentos.id')
            ->join('organizaciones', 'departamentos.organizacion_id', '=', 'organizaciones.id')
            ->select('funciones.*', 'puestos_de_trabajos.nombre as puestoDeTrabajo', 'departamentos.nombre as departamento', 'organizaciones.nombre as organizacion')
            ->where('organizaciones.id' , $organizacion_id)
            ->where('funciones.nombre' , 'Like', '%' .$request->buscar .'%')
            ->orderBy('funciones.id', 'DESC')->paginate(10);

        }

        return view('funciones.index')->with(['funciones' => $funciones, 'organizacion' => $organizacion, 'departamentos' => $departamentos]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $organizacion_id)
    {
        //Creo la funcion
        $funcion = new Funcion;
        //Asigno los valores
        $funcion->nombre = $request->nombre;
        $funcion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;
        //Guardo
        $funcion->save();

        if($funcion->save()){
            $mensaje = "La Función " . $funcion->nombre . " fue registrada con Exito.";
            Alert::success('Función Registrada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('funciones.index', $organizacion_id);
        }
    }

    public function storeDesdePuestoDeTrabajo(Request $request, $organizacion_id){
        //Creo la funcion
        $funcion = new Funcion;
        //Asigno los valores
        $funcion->nombre = $request->nombre;
        $funcion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;
        //Guardo
        $funcion->save();

        $puestoDeTrabajo_id = $funcion->puesto_de_trabajo_id;

        if($funcion->save()){
            $mensaje = "La Función " . $funcion->nombre . " fue registrada con Exito.";
            Alert::success('Función Registrada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('puestosDeTrabajos.show', [$organizacion_id, $puestoDeTrabajo_id]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $organizacion_id, $funcion_id)
    {
        //Busco la funcion
        $funcion = Funcion::findOrFail($funcion_id);
        //Asigno los valores
        $funcion->nombre = $request->nombre;
        $funcion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;

        //Guardo
        $funcion->save();

        if($funcion->save()){
            $mensaje = "La Función " . $funcion->nombre . " fue actualizada con Exito.";
            Alert::success('Función Actualizada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('funciones.index', $organizacion_id);
        }
    }

    public function updateDesdePuestoDeTrabajo(Request $request, $organizacion_id, $funcion_id){
        //Busco la funcion
        $funcion = Funcion::findOrFail($funcion_id);
        //Asigno los valores
        $funcion->nombre = $request->nombre;
        $funcion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;

        //Guardo
        $funcion->save();

        $puestoDeTrabajo_id = $funcion->puesto_de_trabajo_id;

        if($funcion->save()){
            $mensaje = "La Función " . $funcion->nombre . " fue actualizada con Exito.";
            Alert::success('Función Actualizada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('puestosDeTrabajos.show', [$organizacion_id, $puestoDeTrabajo_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($organizacion_id, $funcion_id)
    {
        //Buscar el puesto de trabajo
        $funcion = Funcion::findOrFail($funcion_id);
        //Guardamos el msj
        $mensaje = $funcion->nombre . " fue eliminado correctamente.";
        //Eliminamos al Departamento
        $funcion->delete();
        //Imprimos el msj
        Alert::warning('Función Eliminada!', $mensaje);
        //Redireccionamos
        return redirect()->route('funciones.index', $organizacion_id);
    }

    public function destroyDesdePuestoDeTrabajo($organizacion_id, $funcion_id){
        //Buscar el puesto de trabajo
        $funcion = Funcion::findOrFail($funcion_id);
        //Guardamos el msj
        $mensaje = $funcion->nombre . " fue eliminado correctamente.";

        $puestoDeTrabajo_id = $funcion->puesto_de_trabajo_id;

        //Eliminamos al Departamento
        $funcion->delete();
        //Imprimos el msj
        Alert::warning('Función Eliminada!', $mensaje);
        //Redireccionamos
        return redirect()->route('puestosDeTrabajos.show', [$organizacion_id, $puestoDeTrabajo_id]);
    }

    public function getPuestosDeTrabajos($organizacion_id, $departamento_id){
        $departamento = Departamento::findOrFail($departamento_id);
        $puestos = $departamento->puestos;
        return response()->json($puestos);
    }

    public function getFuncion($organizacion_id, $funcion_id){
        $funcion = Funcion::findOrFail($funcion_id);
        return response()->json($funcion);
    }

    public function getPuesto($organizacion_id, $puesto_id){
        $puesto = PuestoDeTrabajo::findOrFail($puesto_id);
        return response()->json($puesto);
    }

}
