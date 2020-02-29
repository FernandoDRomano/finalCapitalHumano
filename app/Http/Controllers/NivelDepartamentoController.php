<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NivelDepartamento;
use App\Http\Requests\SaveNivelDepartamentalRequest;
use App\NivelPuesto;
use RealRashid\SweetAlert\Facades\Alert;


class NivelDepartamentoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->buscar == null) {
            $nivelesDepartamentales = NivelDepartamento::orderBy('jerarquia', 'ASC')->paginate(10);
        }else{
            $nivelesDepartamentales = NivelDepartamento::search($request->buscar)->orderBy('id', 'ASC')->paginate(10);
        }

        return view('nivelesDepartamentales.index')->with('nivelesDepartamentales', $nivelesDepartamentales);

    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        //PARA ALMACENAR LOS DATOS
        $nivelDepartamento = new NivelDepartamento();
        //ASIGNO LOS VALORES
        $nivelDepartamento->nombre = $request->nombre;
        $nivelDepartamento->jerarquia = $request->selectJerarquia;
        //ALMACENO EN LA BD
        $nivelDepartamento->save();

        //REDIRECCIONO AL INDEX DE LAS CATEGORIAS
        if ($nivelDepartamento->save()) {
            //MENSAJE FLASH
            $mensaje = "El Nivel Departamental " . $nivelDepartamento->nombre . " fue registrada con Exito.";
            Alert::success('Nivel Departamental Registrado!', $mensaje);
            //flash('¡Se ha Registrado la Organización <strong>' . $organizacion->nombre . '</strong> de Forma Exitosa!')->success()->important();
            return redirect()->action('NivelDepartamentoController@index');
        }
    }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {
        //Busco
        $nivelDepartamento = NivelDepartamento::findOrFail($id);
        //Actualizo
        $nivelDepartamento->nombre = $request->nombre;
        $nivelDepartamento->jerarquia = $request->selectJerarquia;
        $nivelDepartamento->save();

        if($nivelDepartamento->save()){
            $mensaje = "El Nivel Departamental " . $nivelDepartamento->nombre . " fue actualizada correctamente.";
            Alert::info('Nivel Departamental Actualizado!', $mensaje);
            return redirect()->action('NivelDepartamentoController@index');
        }
    }


    public function destroy($id)
    {
        $nivelDepartamento = NivelDepartamento::findOrFail($id);
        $mensaje = "El Nivel Departamental " . $nivelDepartamento->jerarquia . " - " . $nivelDepartamento->nombre . " fue eliminada correctamente.";

        $nivelDepartamento->delete();

        Alert::warning('Nivel Departamental Eliminado!', $mensaje);
        return redirect()->action('NivelDepartamentoController@index');
    }

    public function getNivelDepartamental($id){
        //Busco la organización
        $nivelDepartamento = NivelDepartamento::findOrFail($id);
        //la retorno al fetch
        return response()->json($nivelDepartamento);
    }

    public function getNivelesDepartamentales(){
        //Busco todos los niveles
        $nivelesDepartamentales = NivelDepartamento::orderBy('jerarquia', 'DESC')->paginate(10);
        $niveles = [];
        foreach ($nivelesDepartamentales as $index => $nivel) {
            $niveles[$index] = $nivel->jerarquia;
        }
        return response()->json($niveles);
    }

    public function getDepartamentosDependientes($id){
        $nivel = NivelDepartamento::findOrFail($id);
        $departamentos = $nivel->departamentos;

        return response()->json(['departamentos' => $departamentos]);
    }

}
