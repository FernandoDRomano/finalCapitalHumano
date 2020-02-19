<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Http\Requests\SavePersonaRequest;
use App\Organizacion;
use RealRashid\SweetAlert\Facades\Alert;
use DateTime;

class PersonaController extends Controller
{

    public function index(Request $request, $idOrganizacion)
    {
        //Busco la organización por el id que llega de la URI
        $organizacion = Organizacion::findOrFail($idOrganizacion);

        if ($request->buscar == null) {
            //Si el request es nulo traigo todas las personas que pertenezcan a la organizacion
            $personas = Persona::where('organizacion_id', $organizacion->id)->orderBy('id', 'DESC')->paginate(10);
        }else{
            //Si el request trae una busqueda, busco la persona que pertenece a la organizacion y la devuelvo
            $personas = Persona::search($request->buscar)->where('organizacion_id', $organizacion->id)->orderBy('id', 'ASC')->paginate(10);
        }
        return view('personas.index')->with(['personas' => $personas, 'organizacion' => $organizacion]);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        //Creo el objeto persona
        $persona = new Persona;
        //Asigno sus valores
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->dni = $request->dni;
        $persona->direccion = $request->direccion;
        $persona->fechaNacimiento = $request->fechaNacimiento;
        $persona->organizacion_id = $request->organizacion_id;
        //Guardo
        $persona->save();
        //Redirecciono
        if($persona->save()){
            $mensaje = "La Persona " . $persona->apellido . ', ' . $persona->nombre . " fue registrada con Exito.";
            Alert::success('Persona Registrada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('personas.index', $persona->organizacion_id);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

    }


    public function update(Request $request, $organizacion_id, $persona_id)
    {
        //Busco la persona
        $persona = Persona::findOrFail($persona_id);
        //Asigno los valores
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->dni = $request->dni;
        $persona->direccion = $request->direccion;

        $persona->fechaNacimiento = $request->fechaNacimiento;

        //Guardo los cambios
        $persona->save();

        if($persona->save()){
            $mensaje = "La Persona " . $persona->apellido . ', ' . $persona->nombre . " fue actualizada con Exito.";
            Alert::success('Persona Actualizada!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->route('personas.index', $organizacion_id);
        }
    }

    //Estoy recibiendo dos parametros por la URI, ver rutas
    public function destroy($organizacion_id, $persona_id)
    {
        //Buscamos a la persona
        $persona = Persona::findOrFail($persona_id);
        //Guardamos el msj
        $mensaje = $persona->apellido . ", " . $persona->nombre . " fue eliminado correctamente.";
        //Eliminamos la persona
        $persona->delete();
        //Imprimos el msj
        Alert::warning('Persona Eliminada!', $mensaje);
        //Redireccionamos
        return redirect()->route('personas.index', $organizacion_id);
    }

    //Estoy recibiendo dos parametros por la URI, ver rutas
    public function getPersona($organizacion_id, $persona_id){
        //Busco la persona
        $persona = Persona::findOrFail($persona_id);
        //La retorno
        return response()->json($persona);
    }

}
