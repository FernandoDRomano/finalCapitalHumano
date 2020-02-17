<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NivelPuesto;
use App\Http\Requests\SaveNivelPuestoRequest;
use RealRashid\SweetAlert\Facades\Alert;

class NivelPuestoController extends Controller
{

    public function index(Request $request)
    {
        if ($request->buscar == null) {
            $nivelesPuestos = NivelPuesto::orderBy('jerarquia', 'ASC')->paginate(10);
        }else{
            $nivelesPuestos = NivelPuesto::search($request->buscar)->orderBy('id', 'ASC')->paginate(10);
        }

        return view('nivelesPuestos.index')->with('nivelesPuestos', $nivelesPuestos);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        //PARA ALMACENAR LOS DATOS
        $nivelPuesto = new NivelPuesto();
        //ASIGNO LOS VALORES
        $nivelPuesto->nombre = $request->nombre;
        $nivelPuesto->jerarquia = $request->selectJerarquia;
        //ALMACENO EN LA BD
        $nivelPuesto->save();

        //REDIRECCIONO AL INDEX DE LAS CATEGORIAS
        if ($nivelPuesto->save()) {
            //MENSAJE FLASH
            $mensaje = "El Nivel de Puesto " . $nivelPuesto->nombre . " fue registrada con Exito.";
            Alert::success('Nivel de Puesto Registrado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->action('NivelPuestoController@index');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

    }


    public function update(SaveNivelPuestoRequest $request, $id)
    {
        //Busco
        $nivelPuesto = NivelPuesto::findOrFail($id);
        //Actualizo
        $nivelPuesto->nombre = $request->nombre;
        $nivelPuesto->jerarquia = $request->selectJerarquia;
        $nivelPuesto->save();

        if($nivelPuesto->save()){
            $mensaje = "El Nivel de Puesto " . $nivelPuesto->nombre . " fue actualizada correctamente.";
            Alert::info('Nivel de Puesto Actualizado!', $mensaje);
            return redirect()->action('NivelPuestoController@index');
        }
    }


    public function destroy($id)
    {
        $nivelPuesto = NivelPuesto::findOrFail($id);
        $mensaje = "El Nivel de Puesto " . $nivelPuesto->jerarquia . " - " . $nivelPuesto->nombre . " fue eliminado correctamente.";

        $nivelPuesto->delete();

        Alert::warning('Nivel de Puesto Eliminado!', $mensaje);
        return redirect()->action('NivelPuestoController@index');
    }

    public function getNivelPuesto($id){
        //Busco la organización
        $nivelPuesto = NivelPuesto::findOrFail($id);
        //la retorno al fetch
        return response()->json($nivelPuesto);
    }

    public function getNivelesPuestos(){
        //Busco todos los niveles
        $nivelesPuestos = NivelPuesto::orderBy('jerarquia', 'DESC')->paginate(10);
        $niveles = [];
        foreach ($nivelesPuestos as $index => $nivel) {
            $niveles[$index] = $nivel->jerarquia;
        }
        return response()->json($niveles);
    }

}
