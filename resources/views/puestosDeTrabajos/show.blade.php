@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

@include('template.menu')

@endsection

@section('contenido')

<h1 class="text-center display-4 text-dark font-weight-bold mb-3">{{$organizacion->nombre}}</h1>

<h4 class="text-left font-weight-bold mb-3 text-dark">Departamento: <span class="text-info">{{$departamento->nombre}}</span> | <span class="text-info">{{$departamento->nivelDepartamento->nombre}}</span></h4>
<h4 class="text-left font-weight-bold mb-3 text-dark">Puesto de Trabajo: <span class="text-info">{{$puestoDeTrabajo->nombre}}</span> | <span class="text-info">{{$puestoDeTrabajo->nivelPuesto->nombre}}</span> </h4>


<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header blue-marino d-flex justify-content-between align-items-center">
              <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Personas Asignadas ({{$puestoDeTrabajo->personas->count()}})</span></strong></h3>
                <a id="btnAgregarPersona" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregarPersona" data-id="{{$puestoDeTrabajo->id}}"
                    data-tooltip="tooltip" data-placement="top" title="Agregar Nueva Asignación De Puesto de Trabajo">
                <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
            </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive ">

                <div class="form-group row mb-3 px-3">
                    <div class="col-12">
                        <form method="get" action="#">
                            <div class="input-group">
                                <input type="text" id="buscarPersonas" name="buscarPersonas" class="form-control" placeholder="Buscar por Nombre...">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>


            <table class="table table-hover table-sm text-nowrap px-3 table-striped text-center">
                <thead class="thead-dark text-uppercase">
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody id="tablaPersonas">

                @foreach ($personas as $persona)
                    <tr>
                        <td>{{$persona->id}}</td>
                        <td>{{$persona->apellido . ', '. $persona->nombre}}</td>
                        <td>
                            <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminarPersona"
                            data-tooltip="tooltip" data-placement="top" title="Eliminar Asignación del Puesto de Trabajo" data-id="{{$persona->id}}"><i class="fas fa-trash-alt" data-id="{{$persona->id}}"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>

              {{$personas->links()}}


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header blue-marino d-flex justify-content-between align-items-center">
              <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Funciones ({{$puestoDeTrabajo->funciones->count()}})</span></strong></h3>
              <a id="btnAgregarFuncion" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregarFuncion"
              data-tooltip="tooltip" data-placement="top" title="Agregar Nueva Función">
                <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
            </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive ">

                <div class="form-group row mb-3 px-3">
                    <div class="col-12">
                        <form method="get" action="#">
                            <div class="input-group">
                                <input type="text" id="buscarFunciones" name="buscarFunciones" class="form-control" placeholder="Buscar ...">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>


            <table class="table table-hover table-sm text-nowrap px-3 table-striped text-center">
                <thead class="thead-dark text-uppercase">
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody id="tablaFunciones">

                @foreach ($funciones as $funcion)
                    <tr>
                        <td>{{$funcion->id}}</td>
                        <td>{{$funcion->nombre}}</td>
                        <td>
                            <a id="btnEditarFuncion" id="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditarFuncion"
                            data-tooltip="tooltip" data-placement="top" title="Editar datos de la Función" data-id="{{$funcion->id}}"><i class="fas fa-edit" data-id="{{$funcion->id}}"></i></a>
                            <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminarFuncion"
                            data-tooltip="tooltip" data-placement="top" title="Eliminar la Función" data-id="{{$funcion->id}}"><i class="fas fa-trash-alt" data-id="{{$funcion->id}}"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>

              {{$funciones->links()}}


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header blue-marino d-flex justify-content-between align-items-center">
              <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Obligaciones ({{$puestoDeTrabajo->obligaciones->count()}})</span></strong></h3>
              <a id="btnAgregarObligacion" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregarObligacion"
              data-tooltip="tooltip" data-placement="top" title="Agregar Nueva Obligación">
                <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
            </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive ">

                <div class="form-group row mb-3 px-3">
                    <div class="col-12">
                        <form method="get" action="#">
                            <div class="input-group">
                                <input type="text" id="buscarObligaciones" name="buscarObligaciones" class="form-control" placeholder="Buscar ...">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>

            <table class="table table-hover table-sm text-nowrap px-3 table-striped text-center">
                <thead class="thead-dark text-uppercase">
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody id="tablaObligaciones">

                @foreach ($obligaciones as $obligacion)
                    <tr>
                        <td>{{$obligacion->id}}</td>
                        <td>{{$obligacion->nombre}}</td>
                        <td>
                            <a id="btnEditarObligacion" id="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditarObligacion"
                            data-tooltip="tooltip" data-placement="top" title="Editar datos de la Obligación" data-id="{{$obligacion->id}}"><i class="fas fa-edit" data-id="{{$obligacion->id}}"></i></a>
                            <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminarObligacion"
                            data-tooltip="tooltip" data-placement="top" title="Eliminar Obligación" data-id="{{$obligacion->id}}"><i class="fas fa-trash-alt" data-id="{{$obligacion->id}}"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>

              {{$obligaciones->links()}}


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div>

</div>


<!-- CONTENIDO PRINCIPAL DE LA PAGINA -->

@endsection

@section('modales')

<!-- Modal Agregar -->
<div class="modal" tabindex="-1" role="dialog" id="modalAgregarFuncion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 id="tituloModalAgregar" class="modal-title w-100 text-center" id="exampleModalLabel">Nueva Función</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregarFuncion" action=" {{ action('FuncionController@storeDesdePuestoDeTrabajo', [$organizacion->id])}}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreAgregarFuncion" name="nombre" type="text" placeholder="Ingresar el nombre...">
                            <div id="errorTxtNombreAgregarFuncion"></div>
                        </div>
                        <input type="hidden" name="selectPuestoDeTrabajo" value="{{$puestoDeTrabajo->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Agregar -->

<!-- Modal Agregar -->
<div class="modal" tabindex="-1" role="dialog" id="modalAgregarObligacion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 id="tituloModalAgregar" class="modal-title w-100 text-center" id="exampleModalLabel">Nueva Obligación</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregarObligacion" action="{{ action('ObligacionController@storeDesdePuestoDeTrabajo', [$organizacion->id])}} " method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreAgregarObligacion" name="nombre" type="text" placeholder="Ingresar el nombre...">
                            <div id="errorTxtNombreAgregarObligacion"></div>
                        </div>
                        <input type="hidden" name="selectPuestoDeTrabajo" value="{{$puestoDeTrabajo->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Agregar -->

<!-- Modal Agregar -->
<div class="modal" tabindex="-1" role="dialog" id="modalAgregarPersona">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 id="tituloModalAgregar" class="modal-title w-100 text-center" id="exampleModalLabel">Asignar Personas al Puesto de Trabajo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregarPersona" action="{{ action('PersonaController@storeDesdePuestoDeTrabajo', [$organizacion->id])}} " method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="selectPersona">Personas</label>
                            <select id="selectPersonaAgregar" name="selectPersona[]" class="form-control select2 selectMultiple" multiple="multiple" style="width: 100%;">

                            </select>
                            <div id="errorSelectPersonaAgregar"></div>
                        </div>
                        <input type="hidden" name="selectPuestoDeTrabajo" value="{{$puestoDeTrabajo->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Agregar -->

<!-- Modal Editar -->
<div class="modal" tabindex="-1" role="dialog" id="modalEditarFuncion" class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 id="tituloModalEditarFuncion" class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Función</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarFuncion" method="POST">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreEditarFuncion" name="nombre" type="text" placeholder="Ingresar el nombre...">
                            <div id="errorTxtNombreEditarFuncion"></div>
                        </div>
                        <input type="hidden" name="selectPuestoDeTrabajo" value="{{$puestoDeTrabajo->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning text-white">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar -->

<!-- Modal Editar -->
<div class="modal" tabindex="-1" role="dialog" id="modalEditarObligacion" class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 id="tituloModalEditarObligacion" class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Obligación</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarObligacion" method="POST">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreEditarObligacion" name="nombre" type="text" placeholder="Ingresar el nombre...">
                            <div id="errorTxtNombreEditarObligacion"></div>
                        </div>
                        <input type="hidden" name="selectPuestoDeTrabajo" value="{{$puestoDeTrabajo->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning text-white">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar -->

<!-- Modal Eliminar -->
<div class="modal" tabindex="-1" role="dialog" id="modalEliminarFuncion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title w-100 text-white text-center" id="tituloModalEliminarFuncion"></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formEliminarFuncion">
            {{csrf_field()}}
            {{method_field('delete')}}
                <div class="modal-body">
                    <div id="contenidoModalEliminarFuncion" class="card-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger text-white">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Eliminar -->

<!-- Modal Eliminar -->
<div class="modal" tabindex="-1" role="dialog" id="modalEliminarObligacion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title w-100 text-white text-center" id="tituloModalEliminarObligacion"></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formEliminarObligacion">
            {{csrf_field()}}
            {{method_field('delete')}}
                <div class="modal-body">
                    <div id="contenidoModalEliminarObligacion" class="card-body">
                    </div>
                    <input type="hidden" name="puestoDeTrabajo_id" value="{{$puestoDeTrabajo->id}}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger text-white">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Eliminar -->

<!-- Modal Eliminar -->
<div class="modal" tabindex="-1" role="dialog" id="modalEliminarPersona">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title w-100 text-white text-center" id="tituloModalEliminarPersona"></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formEliminarPersona">
            {{csrf_field()}}
            {{method_field('delete')}}
                <div class="modal-body">
                    <div id="contenidoModalEliminarPersona" class="card-body">
                    </div>
                    <input type="hidden" name="puestoDeTrabajo_id" value="{{$puestoDeTrabajo->id}}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger text-white">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Eliminar -->

@endsection

@section('script')

<script>
    /*
    JQUERY
    */

    /*
        INICIALIZANDO LOS TOOLTIPS
    */

    $(function(){
        $('[data-tooltip="tooltip"]').tooltip();
    });

    $('.selectMultiple').select2({
        placeholder: 'Seleccione opción',
        maximumSelectionLength: 3,
        language: "es",
        allowClear: true
    })

    $('.selectSimple').select2({
        placeholder: 'Seleccione opción',
        maximumSelectionLength: 1,
        language: "es",
        allowClear: true
    })

    /*
        FIN DE JQUERY
    */

    /*
        VARIABLES
    */

    //Token
    const token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    //Formularios
    const formAgregarFuncion = document.getElementById('formAgregarFuncion');
    const formAgregarObligacion = document.getElementById('formAgregarObligacion');
    const formAgregarPersona = document.getElementById('formAgregarPersona');
    const formEditarFuncion = document.getElementById('formEditarFuncion');
    const formEditarObligacion = document.getElementById('formEditarObligacion');
    const formEliminarFuncion = document.getElementById('formEliminarFuncion');
    const formEliminarObligacion = document.getElementById('formEliminarObligacion');
    const formEliminarPersona = document.getElementById('formEliminarPersona');
    //Tabla
    const tablaFunciones = document.getElementById('tablaFunciones');
    const tablaObligaciones = document.getElementById('tablaObligaciones');
    const tablaPersonas = document.getElementById('tablaPersonas');
    //Inputs Agregar
    const nombreAgregarFuncion = document.getElementById('txtNombreAgregarFuncion');
    const nombreAgregarObligacion = document.getElementById('txtNombreAgregarObligacion');
    let selectPersonaAgregar = document.getElementById('selectPersonaAgregar');
    const btnAgregarPersona = document.getElementById('btnAgregarPersona');
    //Inputs Error Agregar
    let campoErrorNombreAgregarFuncion = document.querySelector('#errorTxtNombreAgregarFuncion');
    let campoErrorNombreAgregarObligacion = document.querySelector('#errorTxtNombreAgregarObligacion');
    let campoErrorPersonaAgregar = document.getElementById('errorSelectPersonaAgregar');
    //Inputs Editar
    const nombreEditarFuncion = document.getElementById('txtNombreEditarFuncion');
    const nombreEditarObligacion = document.getElementById('txtNombreEditarObligacion');
    //Inputs Error EditarFuncion
    let campoErrorNombreEditarFuncion = document.querySelector('#errorTxtNombreEditarFuncion');
    let campoErrorNombreEditarObligacion = document.querySelector('#errorTxtNombreEditarObligacion');


    /*
        EVENTSLISTENERS
    */
   cargarEventsListeners();

    function cargarEventsListeners(){
        /*
            EVENTOS PARA FUNCIONES
        */
        //Para agregar
        formAgregarFuncion.addEventListener('submit', agregarFuncion);
        nombreAgregarFuncion.addEventListener('input', validarNombreAgregarFuncion);
        //Para eliminar
        tablaFunciones.addEventListener('click', getDatosForDeleteFuncion);
        //Para editar
        tablaFunciones.addEventListener('click', getDatosForUpdateFuncion);
        formEditarFuncion.addEventListener('submit', editarFuncion);
        nombreEditarFuncion.addEventListener('input', validarNombreEditarFuncion);

        /*
            EVENTOS PARA OBLIGACIONES
        */
        //Para agregar
        formAgregarObligacion.addEventListener('submit', agregarObligacion);
        nombreAgregarObligacion.addEventListener('input', validarNombreAgregarObligacion);
        //Para eliminar
        tablaObligaciones.addEventListener('click', getDatosForDeleteObligacion);
        //Para editar
        tablaObligaciones.addEventListener('click', getDatosForUpdateObligacion);
        formEditarObligacion.addEventListener('submit', editarObligacion);
        nombreEditarObligacion.addEventListener('input', validarNombreEditarObligacion);

        /*
            EVENTOS PARA PERSONAS
        */
       //Para agregar
       btnAgregarPersona.addEventListener('click', getPersonas);
       formAgregarPersona.addEventListener('submit', agregarPersona);
       //Para eliminar
       tablaPersonas.addEventListener('click', getDatosForDeletePersona);
    }

    /*
        FUNCIONES QUE INTERACTUAN CON EL BACKEND
    */

    function agregarFuncion(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreAgregarFuncion, campoErrorNombreAgregarFuncion);

        let nombre = nombreAgregarFuncion.classList.contains('correcto-input');

        if (nombre) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre}`);

        }
    }

    function agregarObligacion(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreAgregarObligacion, campoErrorNombreAgregarObligacion);

        let nombre = nombreAgregarObligacion.classList.contains('correcto-input');

        if (nombre) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre}`);

        }
    }

    function agregarPersona(e){
        e.preventDefault();
        //Obtengos los datos
        validarSelect2Vacio(selectPersonaAgregar, campoErrorPersonaAgregar);

        let persona = selectPersonaAgregar.classList.contains('correcto-input');

        if (persona) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> persona: ${persona}`);

        }
    }

    function editarFuncion(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreEditarFuncion, campoErrorNombreEditarFuncion);

        let nombre = nombreEditarFuncion.classList.contains('correcto-input');

        if (nombre) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre}`);

        }
    }

    function editarObligacion(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreEditarObligacion, campoErrorNombreEditarObligacion);

        let nombre = nombreEditarObligacion.classList.contains('correcto-input');

        if (nombre) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre}`);

        }
    }

    /*
        FUNCIONES
    */

    function getPersonas(e){
            const id = e.target.getAttribute('data-id');
            const url = `../getPersonas/${id}`;
            //LLAMADA A FETCH
            fetch(url, {
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
                },
                method: 'get',
                credentials: "same-origin",
            })
            .then(response =>{
                console.log(response);
                return response.json();
            })
            .then(datos => {
                console.log(datos);
                //Cargo el nombre
                let template = ``;

                datos.forEach(persona => {
                    template += `<option value="${persona.id}">${persona.apellido + ', ' + persona.nombre}</option>`;
                });

                selectPersonaAgregar.innerHTML = template;

            })
            .catch(error => {
                console.log(error);
            });

   }

    function getDatosForUpdateFuncion(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('editar') || e.target.classList.contains('fa-edit')) {
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `../getFuncion/${id}`;
            //LLAMADA A FETCH
            fetch(url, {
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
                },
                method: 'get',
                credentials: "same-origin",
            })
            .then(response =>{
                console.log(response);
                return response.json();
            })
            .then(datos => {
                console.log(datos);
                //Cargo el nombre
                nombreEditarFuncion.value = datos.nombre;

                formEditarFuncion.setAttribute('action', '../funciones/editar/' + datos.id)

            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   /*

    FALTA ELIMINAR LA PERSONA, VER RUTA Y ACCIONES A LLEVAR A CABO

   */

   function getDatosForDeletePersona(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('eliminar') || e.target.classList.contains('fa-trash-alt')) {
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `../getPersona/${id}`;
            //LLAMADA A FETCH
            fetch(url, {
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
                },
                method: 'get',
                credentials: "same-origin",
            })
            .then(response =>{
                console.log(response);
                return response.json();
            })
            .then(datos => {
                console.log(datos);

                const titulo = document.getElementById('tituloModalEliminarPersona');
                titulo.innerHTML = `<strong>Eliminar ${datos.apellido +', ' + datos.nombre}</strong>`;

                const contenido = document.getElementById('contenidoModalEliminarPersona');
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar a <strong>${datos.apellido + ', ' + datos.nombre}</strong> de este Puesto de Trabajo?</h4>`;

                formEliminarPersona.setAttribute('action', '../personas/eliminar/'+ datos.id);

            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getDatosForUpdateObligacion(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('editar') || e.target.classList.contains('fa-edit')) {
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `../getObligacion/${id}`;
            //LLAMADA A FETCH
            fetch(url, {
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
                },
                method: 'get',
                credentials: "same-origin",
            })
            .then(response =>{
                console.log(response);
                return response.json();
            })
            .then(datos => {
                console.log(datos);
                //Cargo el nombre
                nombreEditarObligacion.value = datos.nombre;

                formEditarObligacion.setAttribute('action', '../obligaciones/editar/' + datos.id)

            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getDatosForDeleteFuncion(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('eliminar') || e.target.classList.contains('fa-trash-alt')) {
            console.log("Click btn eliminar");
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `../getFuncion/${id}`;
            //LLAMADA A FETCH
            fetch(url, {
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
                },
                method: 'get',
                credentials: "same-origin",
            })
            .then(response =>{
                console.log(response);
                return response.json();
            })
            .then(datos => {
                console.log(datos);
                //Cargo en el modal los datos

                const titulo = document.getElementById('tituloModalEliminarFuncion');
                titulo.innerHTML = `<strong>Eliminar ${datos.nombre}</strong>`;

                const contenido = document.getElementById('contenidoModalEliminarFuncion');
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar la Función <strong>${datos.nombre}</strong>?</h4>`;

                formEliminarFuncion.setAttribute('action', '../funciones/eliminar/'+datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getDatosForDeleteObligacion(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('eliminar') || e.target.classList.contains('fa-trash-alt')) {
            console.log("Click btn eliminar");
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `../getObligacion/${id}`;
            //LLAMADA A FETCH
            fetch(url, {
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
                },
                method: 'get',
                credentials: "same-origin",
            })
            .then(response =>{
                console.log(response);
                return response.json();
            })
            .then(datos => {
                console.log(datos);
                //Cargo en el modal los datos

                const titulo = document.getElementById('tituloModalEliminarObligacion');
                titulo.innerHTML = `<strong>Eliminar ${datos.nombre}</strong>`;

                const contenido = document.getElementById('contenidoModalEliminarObligacion');
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar la Obligación <strong>${datos.nombre}</strong>?</h4>`;

                formEliminarObligacion.setAttribute('action', '../obligaciones/eliminar/'+datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

    /*
        VALIDACIONES
    */

    function validarNombreAgregarFuncion(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorNombreAgregarFuncion, max);
    }

    function validarNombreAgregarObligacion(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorNombreAgregarObligacion, max);
    }

    function validarNombreEditarFuncion(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorNombreEditarFuncion, max);
    }

    function validarNombreEditarObligacion(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorNombreEditarObligacion, max);
    }

    function validarSoloTextoNumero(campo, campoError, max = 0){
        /*
            Expresion regular que valida solo letras numeros y los caracteres especiales de (.-_,&|°*)
        */
        let expresion = /^[0-9a-zA-ZáÁéÉíÍóÓúÚñÑüÜ\s.-_,&|°*]+$/;
        //Mensaje que se imprimira
        let mensaje = ``;
        //obtengo la longitud del campo
        let longitud = campo.value.length;
        //obtengo el valor del campo
        let valor = campo.value;

        if(longitud === 0){
            //Si la longitud del campo es vacio
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: Debe ingresar un valor.</strong></small>`;
        }else if(valor.trim() === ""){
            //Si el campo solo tiene espacios vacios
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: No se permiten enviar espacios en blanco unicamente.</strong></small>`;
        }else if(longitud > max){
            //Verifico que la longitud del campo no sea mayor que el max permitido
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: La longitud debe ser menor que ${max} caracteres.</strong></small>`;
        }else if(!expresion.test(valor)){
            //Si no se cumple la expresion regular
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: Solo se permiten letras [a-z] mayusculas y minusculas</strong></small>`;
        }else{
            campo.classList.remove('error-input');
            campo.classList.add('correcto-input');
            mensaje = `<small id="mensaje" class="form-text text-green"><strong>Perfecto</strong></small>`;
        }

        campoError.innerHTML = mensaje;

    }

    function validarVacio(campo, campoError){
        let mensaje = "";
        if(campo.value.length === 0){
            //Si la longitud del campo es vacio
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: Debe ingresar un valor.</strong></small>`;
            campoError.innerHTML = mensaje;
        }else if(campo.value.trim() === ""){
            //Si el campo solo tiene espacios vacios
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: No se permiten enviar espacios en blanco unicamente.</strong></small>`;
            campoError.innerHTML = mensaje;
        }else {
            campo.classList.remove('error-input');
            campo.classList.add('correcto-input');
            mensaje = `<small id="mensaje" class="form-text text-green"><strong>Perfecto</strong></small>`;
            campoError.innerHTML = mensaje;
        }
    }

    function validarSelectVacio(campo, campoError){
        let mensaje = '';
        if(campo.options[campo.selectedIndex].text === "Seleccionar"){
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: Debe seleccionar una opción.</strong></small>`;
            campoError.innerHTML = mensaje;
        }else if(campo.options[campo.selectedIndex].text === "No tiene Puestos de Trabajos asignados."){
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: Debe seleccionar otro departamento, que contenga Puestos de Trabajos asignados.</strong></small>`;
            campoError.innerHTML = mensaje;
        }else{
            campo.classList.remove('error-input');
            campo.classList.add('correcto-input');
            mensaje = `<small id="mensaje" class="form-text text-green"><strong>Perfecto.</strong></small>`;
            campoError.innerHTML = mensaje;
        }
    }

    function validarSelect2Vacio(campo, campoError){
        let mensaje = '';

        console.log(campo);

        if(campo.value == ""){
            campo.classList.remove('correcto-input');
            campo.classList.add('error-input');
            mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: Debe seleccionar una opción.</strong></small>`;
            campoError.innerHTML = mensaje;
        }else{
            campo.classList.remove('error-input');
            campo.classList.add('correcto-input');
            mensaje = `<small id="mensaje" class="form-text text-green"><strong>Perfecto.</strong></small>`;
            campoError.innerHTML = mensaje;
        }

    }


</script>

@endsection
