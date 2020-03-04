<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PuestoDeTrabajo;
use App\NivelPuesto;
use App\Departamento;
use App\Organizacion;
use App\Http\Requests\SavePuestoTrabajoRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;


class PuestoTrabajoController extends Controller
{

    public function index(Request $request, $organizacion_id)
    {
        //Busco la organizacion
        $organizacion = Organizacion::findOrFail($organizacion_id);
        //Busco los puestos de trabajos, utilizando la relacion 1 a muchos a traves de

        if ($request->buscar == null) {
            //Si el request es nulo traigo todas los puestos de trabajos que pertenezcan a la organizacion
            $puestosDeTrabajos = $organizacion->puestosDeTrabajos()->orderBy('id', 'ASC')->paginate(10);
        }else{
            /**
             * NO ENCONTRE OTRA FORMA DE BUSCAR, MAS QUE PASANDO EL NOMBRE DE LA TABLA
             */
            //$puestosDeTrabajos = $organizacion->puestosDeTrabajos()->where('puestos_de_trabajos.nombre' , 'like' , '%' .$request->buscar . '%')->get();
            $puestosDeTrabajos = $organizacion->puestosDeTrabajos()->where('puestos_de_trabajos.nombre' , 'like' , '%' .$request->buscar . '%')->orderBy('id', 'ASC')->paginate(10);
        }

        return view('puestosDeTrabajos.index')->with(['puestosDeTrabajos' => $puestosDeTrabajos, 'organizacion' => $organizacion]);

    }


    public function store(Request $request, $organizacion_id)
    {
        //Creo el puesto de trabajo
        $puestoDeTrabajo = new PuestoDeTrabajo;
        //Asigno los valores
        $puestoDeTrabajo->nombre = $request->nombre;
        $puestoDeTrabajo->nivel_puesto_id = $request->selectNivelPuestoDeTrabajo;
        $puestoDeTrabajo->departamento_id = $request->selectDepartamento;
        //Grabo
        $puestoDeTrabajo->save();

        if($puestoDeTrabajo->save()){
            $mensaje = "El Puesto de Trabajo " . $puestoDeTrabajo->nombre . " fue registrado con Exito.";
            Alert::success('Puesto de Trabajo Registrado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('puestosDeTrabajos.index', $organizacion_id);
        }
    }

    public function storeDesdeDepartamento(Request $request, $organizacion_id){
        //Creo el puesto de trabajo
        $puestoDeTrabajo = new PuestoDeTrabajo;
        //Asigno los valores
        $puestoDeTrabajo->nombre = $request->nombre;
        $puestoDeTrabajo->nivel_puesto_id = $request->selectNivelPuestoDeTrabajo;
        $puestoDeTrabajo->departamento_id = $request->selectDepartamento;
        //Grabo
        $puestoDeTrabajo->save();

        $deparmento_id = $puestoDeTrabajo->departamento_id;

        if($puestoDeTrabajo->save()){
            $mensaje = "El Puesto de Trabajo " . $puestoDeTrabajo->nombre . " fue registrado con Exito.";
            Alert::success('Puesto de Trabajo Registrado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('departamentos.show', [$organizacion_id, $deparmento_id]);
        }
    }

    public function show(Request $request, $organizacion_id, $puestoDeTrabajo_id)
    {
        $organizacion = Organizacion::findOrFail($organizacion_id);
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        $departamento = $puestoDeTrabajo->departamento;
        //$funciones = $puestoDeTrabajo->funciones()->orderBy('id', 'DESC')->paginate(5);
        //$obligaciones = $puestoDeTrabajo->obligaciones()->orderBy('id', 'DESC')->paginate(5);

        if($request->buscarFunciones != null ){
            $personas = $puestoDeTrabajo->personas()->orderBy('id', 'DESC')->paginate(7);
            $funciones = $puestoDeTrabajo->funciones()->search($request->buscarFunciones)->orderBy('id', 'DESC')->paginate(5);
            $obligaciones = $puestoDeTrabajo->obligaciones()->orderBy('id', 'DESC')->paginate(5);
        }else if($request->buscarObligaciones != null){
            $personas = $puestoDeTrabajo->personas()->orderBy('id', 'DESC')->paginate(7);
            $funciones = $puestoDeTrabajo->funciones()->orderBy('id', 'DESC')->paginate(5);
            $obligaciones = $puestoDeTrabajo->obligaciones()->search($request->buscarObligaciones)->orderBy('id', 'DESC')->paginate(5);
        }else if($request->buscarPersonas != null){

            $personas = DB::table('persona_puesto_trabajo')
            ->join('personas', 'persona_puesto_trabajo.persona_id', '=', 'personas.id')
            ->join('puestos_de_trabajos', 'persona_puesto_trabajo.puesto_de_trabajo_id', '=', 'puestos_de_trabajos.id')
            ->select('personas.*')
            ->where('puestos_de_trabajos.id', $puestoDeTrabajo_id)
            ->where('personas.nombre' , 'Like', '%' . $request->buscarPersonas .'%')
            ->orderBy('personas.id', 'DESC')->paginate(7);

            $funciones = $puestoDeTrabajo->funciones()->orderBy('id', 'DESC')->paginate(5);
            $obligaciones = $puestoDeTrabajo->obligaciones()->orderBy('id', 'DESC')->paginate(5);
        }else{
            $personas = $puestoDeTrabajo->personas()->orderBy('id', 'DESC')->paginate(7);
            $funciones = $puestoDeTrabajo->funciones()->orderBy('id', 'DESC')->paginate(5);
            $obligaciones = $puestoDeTrabajo->obligaciones()->orderBy('id', 'DESC')->paginate(5);
        }

        return view('puestosDeTrabajos.show')->with([
            'organizacion' => $organizacion,
            'departamento' => $departamento,
            'puestoDeTrabajo' => $puestoDeTrabajo,
            'funciones' => $funciones,
            'obligaciones' => $obligaciones,
            'personas' => $personas
        ]);
    }


    public function update(Request $request, $organizacion_id, $puestoDeTrabajo_id)
    {
        //Busco el puesto de trabajo
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        //Asigno los valores
        $puestoDeTrabajo->nombre = $request->nombre;
        $puestoDeTrabajo->nivel_puesto_id = $request->selectNivelPuestoDeTrabajo;
        /*
            NO DEJARE QUE SE ACTUALICE EL DEPARTAMENTO
            $puestoDeTrabajo->departamento_id = $request->selectDepartamento;
        */
        //Guardo
        $puestoDeTrabajo->save();

        if($puestoDeTrabajo->save()){
            $mensaje = "El Puesto de Trabajo " . $puestoDeTrabajo->nombre . " fue actualizado con Exito.";
            Alert::success('Puesto de Trabajo Actualizado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('puestosDeTrabajos.index', $organizacion_id);
        }
    }

    public function updateDesdeDepartamento(Request $request, $organizacion_id, $puestoDeTrabajo_id){
        //Busco el puesto de trabajo
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        //Asigno los valores
        $puestoDeTrabajo->nombre = $request->nombre;
        $puestoDeTrabajo->nivel_puesto_id = $request->selectNivelPuestoDeTrabajo;
        /*
            NO DEJARE QUE SE ACTUALICE EL DEPARTAMENTO
            $puestoDeTrabajo->departamento_id = $request->selectDepartamento;
        */
        //Guardo
        $puestoDeTrabajo->save();

        $departamento_id = $puestoDeTrabajo->departamento_id;

        if($puestoDeTrabajo->save()){
            $mensaje = "El Puesto de Trabajo " . $puestoDeTrabajo->nombre . " fue actualizado con Exito.";
            Alert::success('Puesto de Trabajo Actualizado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('departamentos.show', [$organizacion_id, $departamento_id]);
        }
    }


    public function destroy($organizacion_id, $puestoDeTrabajo_id)
    {
        //Buscar el puesto de trabajo
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        //Guardamos el msj
        $mensaje = $puestoDeTrabajo->nombre . " fue eliminado correctamente.";
        //Eliminamos al Departamento
        $puestoDeTrabajo->delete();
        //Imprimos el msj
        Alert::warning('Puesto de Trabajo Eliminado!', $mensaje);
        //Redireccionamos
        return redirect()->route('puestosDeTrabajos.index', $organizacion_id);
    }

    public function destroyDesdeDepartamento($organizacion_id, $puestoDeTrabajo_id){
        //Buscar el puesto de trabajo
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        //Guardamos el msj
        $mensaje = $puestoDeTrabajo->nombre . " fue eliminado correctamente.";
        //Tomo el id del departamento
        $departamento_id = $puestoDeTrabajo->departamento_id;
        //Eliminamos al Departamento
        $puestoDeTrabajo->delete();
        //Imprimos el msj
        Alert::warning('Puesto de Trabajo Eliminado!', $mensaje);
        //Redireccionamos
        return redirect()->route('departamentos.show', [$organizacion_id, $departamento_id]);
    }

    public function getNivelesDePuestosDeTrabajos($organizacion_id){
        $nivelesPuesto = NivelPuesto::orderBy('id', 'ASC')->get();
        return response()->json($nivelesPuesto);
    }

    public function getDepartamentos($organizacion_id){
        $organizacion = Organizacion::findOrFail($organizacion_id);
        $departamentos = $organizacion->departamentos;
        return response()->json($departamentos);
    }

    public function getPuestoDeTrabajo($organizacion_id, $puestoDeTrabajo_id){
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        return response()->json($puestoDeTrabajo);
    }

    public function getObligacionesDependientes($organizacion_id, $puestoDeTrabajo_id){
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        $obligaciones = $puestoDeTrabajo->obligaciones;
        return response()->json($obligaciones);
    }

    public function getFuncionesDependientes($organizacion_id, $puestoDeTrabajo_id){
        $puestoDeTrabajo = PuestoDeTrabajo::findOrFail($puestoDeTrabajo_id);
        $funciones = $puestoDeTrabajo->funciones;
        return response()->json($funciones);
    }

    public function getPuestoReporte($organizacion_id, $puesto_id){
        $puesto = PuestoDeTrabajo::findOrFail($puesto_id);

        $pdf = PDF::loadView('pdf.puesto', compact('puesto'));

        return $pdf->download('reporte-puesto.pdf');
    }

}
