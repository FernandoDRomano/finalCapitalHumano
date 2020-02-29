<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Obligacion;
use App\Organizacion;
use App\PuestoDeTrabajo;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class ObligacionController extends Controller
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

            $obligaciones = DB::table('obligaciones')
            ->join('puestos_de_trabajos', 'obligaciones.puesto_de_trabajo_id', '=', 'puestos_de_trabajos.id')
            ->join('departamentos', 'puestos_de_trabajos.departamento_id', '=', 'departamentos.id')
            ->join('organizaciones', 'departamentos.organizacion_id', '=', 'organizaciones.id')
            ->select('obligaciones.*', 'puestos_de_trabajos.nombre as puestoDeTrabajo', 'departamentos.nombre as departamento', 'organizaciones.nombre as organizacion')
            ->where('organizaciones.id' , $organizacion_id)
            ->orderBy('obligaciones.id', 'DESC')->paginate(10);

        }else{

            $obligaciones = DB::table('obligaciones')
            ->join('puestos_de_trabajos', 'obligaciones.puesto_de_trabajo_id', '=', 'puestos_de_trabajos.id')
            ->join('departamentos', 'puestos_de_trabajos.departamento_id', '=', 'departamentos.id')
            ->join('organizaciones', 'departamentos.organizacion_id', '=', 'organizaciones.id')
            ->select('obligaciones.*', 'puestos_de_trabajos.nombre as puestoDeTrabajo', 'departamentos.nombre as departamento', 'organizaciones.nombre as organizacion')
            ->where('organizaciones.id' , 1)
            ->where('obligaciones.nombre' , 'Like', '%' .$request->buscar .'%')
            ->orderBy('obligaciones.id', 'DESC')->paginate(10);

        }

        return view('obligaciones.index')->with(['obligaciones' => $obligaciones, 'organizacion' => $organizacion, 'departamentos' => $departamentos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $organizacion_id)
    {
        //Creo la obligacion
        $obligacion = new Obligacion;
        //Asigno los valores
        $obligacion->nombre = $request->nombre;
        $obligacion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;
        //Guardo
        $obligacion->save();

        if($obligacion->save()){
            $mensaje = "La Obligación " . $obligacion->nombre . " fue registrada con Exito.";
            Alert::success('Obligación Registrada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('obligaciones.index', $organizacion_id);
        }
    }

    public function storeDesdePuestoDeTrabajo(Request $request, $organizacion_id){
        //Creo la obligacion
        $obligacion = new Obligacion;
        //Asigno los valores
        $obligacion->nombre = $request->nombre;
        $obligacion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;
        //Guardo
        $obligacion->save();

        $puestoDeTrabajo_id = $obligacion->puesto_de_trabajo_id;

        if($obligacion->save()){
            $mensaje = "La Obligación " . $obligacion->nombre . " fue registrada con Exito.";
            Alert::success('Obligación Registrada!', $mensaje);
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
    public function update(Request $request, $organizacion_id, $obligacion_id)
    {
        //Busco la obligacion
        $obligacion = Obligacion::findOrFail($obligacion_id);
        //Asigno los valores
        $obligacion->nombre = $request->nombre;
        $obligacion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;

        //Guardo
        $obligacion->save();

        if($obligacion->save()){
            $mensaje = "La Obligación " . $obligacion->nombre . " fue actualizada con Exito.";
            Alert::success('Obligación Actualizada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('obligaciones.index', $organizacion_id);
        }
    }

    public function updateDesdePuestoDeTrabajo(Request $request, $organizacion_id, $obligacion_id){
        //Busco la obligacion
        $obligacion = Obligacion::findOrFail($obligacion_id);
        //Asigno los valores
        $obligacion->nombre = $request->nombre;
        $obligacion->puesto_de_trabajo_id = $request->selectPuestoDeTrabajo;

        //Guardo
        $obligacion->save();

        $puestoDeTrabajo_id = $obligacion->puesto_de_trabajo_id;

        if($obligacion->save()){
            $mensaje = "La Obligación " . $obligacion->nombre . " fue actualizada con Exito.";
            Alert::success('Obligación Actualizada!', $mensaje);
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
    public function destroy($organizacion_id, $obligacion_id)
    {
        //Buscar el puesto de trabajo
        $obligacion = Obligacion::findOrFail($obligacion_id);
        //Guardamos el msj
        $mensaje = $obligacion->nombre . " fue eliminado correctamente.";
        //Eliminamos al Departamento
        $obligacion->delete();
        //Imprimos el msj
        Alert::warning('Obligación Eliminada!', $mensaje);
        //Redireccionamos
        return redirect()->route('obligaciones.index', $organizacion_id);
    }

    public function destroyDesdePuestoDeTrabajo($organizacion_id, $obligacion_id){
        //Buscar el puesto de trabajo
        $obligacion = Obligacion::findOrFail($obligacion_id);
        //Guardamos el msj
        $mensaje = $obligacion->nombre . " fue eliminado correctamente.";

        $puestoDeTrabajo_id = $obligacion->puesto_de_trabajo_id;

        //Eliminamos al Departamento
        $obligacion->delete();
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

    public function getObligacion($organizacion_id, $obligacion_id){
        $obligacion = Obligacion::findOrFail($obligacion_id);
        return response()->json($obligacion);
    }

    public function getPuesto($organizacion_id, $puesto_id){
        $puesto = PuestoDeTrabajo::findOrFail($puesto_id);
        return response()->json($puesto);
    }

}
