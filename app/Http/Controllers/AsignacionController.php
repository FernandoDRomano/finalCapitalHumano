<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Departamento;
use App\Organizacion;
use App\Persona;
use App\PuestoDeTrabajo;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class AsignacionController extends Controller
{

    public function index(Request $request, $organizacion_id)
    {
        $organizacion = Organizacion::FindOrFail($organizacion_id);
        $personas = $organizacion->personas()->orderBy('apellido', 'ASC')->get();
        $puestosDeTrabajos = $organizacion->puestosDeTrabajos()->orderBy('nombre', 'ASC')->get();
        $departamentos = $organizacion->departamentos()->orderBy('id', 'ASC')->get();

        if ($request->buscar == null) {
            $asignaciones = DB::table('persona_puesto_trabajo')
            ->join('personas', 'persona_puesto_trabajo.persona_id', '=', 'personas.id')
            ->join('puestos_de_trabajos', 'persona_puesto_trabajo.puesto_de_trabajo_id', '=', 'puestos_de_trabajos.id')
            ->join('departamentos', 'puestos_de_trabajos.departamento_id', '=', 'departamentos.id')
            ->join('organizaciones', 'departamentos.organizacion_id', '=', 'organizaciones.id')
            ->select('persona_puesto_trabajo.id', 'personas.apellido as personaApellido', 'personas.nombre as personaNombre', 'puestos_de_trabajos.nombre as puesto', 'departamentos.nombre as departamento')
            ->where('organizaciones.id' , $organizacion_id)
            ->orderBy('persona_puesto_trabajo.id', 'DESC')->paginate(10);
        }else{
            $asignaciones = DB::table('persona_puesto_trabajo')
            ->join('personas', 'persona_puesto_trabajo.persona_id', '=', 'personas.id')
            ->join('puestos_de_trabajos', 'persona_puesto_trabajo.puesto_de_trabajo_id', '=', 'puestos_de_trabajos.id')
            ->join('departamentos', 'puestos_de_trabajos.departamento_id', '=', 'departamentos.id')
            ->join('organizaciones', 'departamentos.organizacion_id', '=', 'organizaciones.id')
            ->select('persona_puesto_trabajo.id', 'personas.apellido as personaApellido', 'personas.nombre as personaNombre', 'puestos_de_trabajos.nombre as puesto', 'departamentos.nombre as departamento')
            ->where('organizaciones.id' , $organizacion_id)
            ->where('personas.nombre' , 'Like', '%' .$request->buscar .'%')
            ->orWhere('personas.apellido' , 'Like', '%' .$request->buscar .'%')
            ->orWhere('puestos_de_trabajos.nombre' , 'Like', '%' .$request->buscar .'%')
            ->orWhere('departamentos.nombre' , 'Like', '%' .$request->buscar .'%')
            ->orderBy('persona_puesto_trabajo.id', 'DESC')->paginate(10);
        }



        return view('asignaciones.index')->with([
            'organizacion' => $organizacion,
            'asignaciones' => $asignaciones,
            'personas' => $personas,
            'puestosDeTrabajos' => $puestosDeTrabajos,
            'departamentos' => $departamentos
        ]);
    }

    public function store(Request $request, $organizacion_id)
    {
        //dd($request->all());
        //Busco el puesto de trabajo
        $puesto = PuestoDeTrabajo::findOrFail($request->selectPuestoDeTrabajo);
        $personas = $request->selectPersona;
        //Grabo los registros
        $puesto->personas()->attach($personas);

        $mensaje = "Las Asignaciones fueron registradas con Exito.";
        Alert::success('Asignaciones Registradas!', $mensaje);
        //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
        return redirect()->route('asignaciones.index', $organizacion_id);
    }

    public function storeDesdePersona(Request $request, $organizacion_id){
        //Buscar al puesto de trabajo
        $puesto = PuestoDeTrabajo::findOrFail($request->selectPuestoDeTrabajo);
        //Asigno el puesto a la persona
        $puesto->personas()->attach($request->persona_id);
        $mensaje = "El Puesto de Trabajo " . $puesto->nombre . " fue Asignado con Exito!";
        Alert::success('Asignación Registrada!', $mensaje);
        //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
        return redirect()->route('personas.show', [$organizacion_id, $request->persona_id]);
    }

    public function show($id)
    {

    }

    public function update(Request $request, $organizacion_id, $asignacion_id)
    {
        $asignacion = Asignacion::findOrFail($asignacion_id);
        if ($request->selectPersona) {
            $asignacion->persona_id = $request->selectPersona;
        }

        $asignacion->save();

        if ($asignacion->save()) {
            $mensaje = "La Asignación del Puesto de Trabajo fue actualizada con Exito.";
            Alert::success('Asignación Actualizada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('asignaciones.index', $organizacion_id);
        }


    }

    public function destroy($organizacion_id, $asignacion_id)
    {
        $asignacion = Asignacion::findOrFail($asignacion_id);
        //Guardamos el msj
        $mensaje = "La Asignación de Puesto de Trabajo de: " . $asignacion->puesto->nombre . " - " . $asignacion->persona->apellido . ', ' . $asignacion->persona->nombre  . " fue eliminado correctamente.";
        //Eliminamos al Departamento
        $asignacion->delete();
        //Imprimos el msj
        Alert::warning('Asignación Eliminada!', $mensaje);
        //Redireccionamos
        return redirect()->route('asignaciones.index', $organizacion_id);
    }

    public function destroyDesdePersona(Request $request, $organizacion_id, $puestoDeTrabajo_id){
        //Buscar el puesto
        $puestoDetrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        //Quito la relacion con la persona
        $persona = Persona::findOrFail($request->persona_id);
        $puestoDetrabajo->personas()->detach($persona->id);
        //Elimino la persona del puesto de trabajo
        //Retorno a la vista
        $mensaje = $persona->apellido . ', ' . $persona->nombre . " ya no tiene asignado el puesto de trabajo " . $puestoDetrabajo->nombre;
        Alert::warning('Asignación Eliminada!', $mensaje);
        //Redireccionamos
        return redirect()->route('personas.show', [$organizacion_id, $persona->id]);
    }

    public function getPuestosDeTrabajos($organizacion_id, $departamento_id){
        $puestosDeTrabajos = PuestoDeTrabajo::where('departamento_id', $departamento_id)->with('nivelPuesto')->orderBy('nombre', 'ASC')->get();
        return response()->json($puestosDeTrabajos);
    }

    public function getPersonas($organizacion_id, $puestoDeTrabajo_id){
        //Busco la organizacion para obtener las personas
        $organizacion = Organizacion::findOrFail($organizacion_id);
        //Obtengo el puesto de trabajo para identificar a las personas ocupadas en el mismo
        $puestoDetrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        //Obtengo la persona que tiene ocupada en el puesto
        $personasOcupadas = $puestoDetrabajo->personas;
        $personasOrganizacion = $organizacion->personas;
        //Calculo la diferencia
        if($personasOcupadas != null){
            $personasLibres = $personasOrganizacion->diff($personasOcupadas);
        }else{
            $personasLibres = $personasOrganizacion;
        }

        return response()->json($personasLibres);
    }

    public function getPuestosDeTrabajosLibres($organizacion_id, $persona_id, $departamento_id){
        //Busco la organizacion para obtener las personas
        $departamento = Departamento::findOrFail($departamento_id);
        //obtengo todos los puestos de trabajos de la organizacion
        $puestoDetrabajoOrganizacion = $departamento->puestos()->with('nivelPuesto')->orderBy('nombre', 'ASC')->get();
        //Obtengo la persona
        $persona = Persona::findOrFail($persona_id);
        //Obtengo los puestos que tenga asignada esta persona
        $puestosDeTrabajosOcupados = $persona->puestosDeTrabajos()->with('nivelPuesto')->orderBy('nombre', 'ASC')->get();;
        //Calculo la diferencia
        if($puestoDetrabajoOrganizacion != null){
            $puestosDeTrabajosLibres = $puestoDetrabajoOrganizacion->diff($puestosDeTrabajosOcupados);
        }else{
            $puestosDeTrabajosLibres = $puestoDetrabajoOrganizacion;
        }

        return response()->json($puestosDeTrabajosLibres);
    }


    public function getAsignacion($organizacion_id, $asignacion_id){
        //Busco la asiganacion para devolverla con la persona y el puesto
        $asignacion = Asignacion::where('id', $asignacion_id)->with('persona', 'puesto')->get();
        return response()->json($asignacion);
    }

}

