@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

@include('template.menu')

@endsection

@section('contenido')

<h1 class="text-center display-4 text-dark font-weight-bold mb-3">{{$organizacion->nombre}}</h1>

<div class="card">
    <div class="card-header blue-marino d-flex justify-content-between align-items-center">
      <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Gestión de Personas</span></strong></h3>
      <a id="btnAgregar" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar"
      data-tooltip="tooltip" data-placement="top" title="Agregar Nueva Persona a la Organización">
        <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
      </a>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive ">

        <div class="form-group row mb-3 px-3">
            <div class="col-md-6">
                <form method="get" action="#">
                    <div class="input-group">
                        <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar ...">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="form-group row d-flex justify-content-between align-items-center">
                  <label for="cantidadPuesto" class="col-md-5 text-dark">Cantidad de Puestos de Trabajo</label>
                  <select class="form-control col-md-7" name="cantidadPuesto" id="cantidadPuesto">
                    <option>Seleccionar</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="3+">Más de 3</option>
                    <option value="todos">Todos</option>
                  </select>
                </div>
            </div>
        </div>


    <table class="table table-hover table-sm text-nowrap px-3 table-striped text-center">
        <thead class="thead-dark text-uppercase">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Fecha de Nacimiento</th>
            <th>Domicilio</th>
            <th>Puestos de Trabajo Asignados</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla">
        @foreach ($personas as $persona)
            <tr>
                <td>{{$persona->id}}</td>
                <td>{{$persona->apellido . ', ' . $persona->nombre}}</td>
                <td>{{$persona->dni}}</td>
                <td>{{$persona->fechaNacimiento}}</td>
                <td>{{$persona->direccion}}</td>
                <td>
                    @if ($persona->puestosDeTrabajos->count() > 0)
                        <span class="badge badge-pill badge-info">{{$persona->puestosDeTrabajos->count() }}</span>
                    @else
                        <span class="badge badge-pill badge-secondary">No Tiene</span>
                    @endif
                </td>
                <td>
                    <a name="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar"
                    data-tooltip="tooltip" data-placement="top" title="Editar los datos de la Persona" data-id="{{$persona->id}}"><i class="fas fa-edit" data-id="{{$persona->id}}"></i></a>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar"
                    data-tooltip="tooltip" data-placement="top" title="Eliminar la Persona" data-id="{{$persona->id}}"><i class="fas fa-trash-alt" data-id="{{$persona->id}}"></i></a>
                    <a name="btnVer" class="btn btn-success text-white" href="{{route('personas.show',['organizacion' => $organizacion->id, 'persona' => $persona->id])}}"
                    data-tooltip="tooltip" data-placement="top" title="Detalle de los Puestos de Trabajos Asignados" role="button"><i class="fas fa-info-circle"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
      </table>

      {{ $personas->links() }}

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->


<!-- CONTENIDO PRINCIPAL DE LA PAGINA -->

@endsection

@section('modales')

<!-- Modal Agregar -->
<div class="modal" tabindex="-1" role="dialog" id="modalAgregar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Nueva Persona</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action('PersonaController@store', ['id' => $organizacion->id]) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" name="organizacion_id" value="{{$organizacion->id}}">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input class="form-control" id="txtNombreAgregar" name="nombre" type="text" placeholder="Ingresar el nombre...">
                                <div id="errorTxtNombreAgregar"></div>
                            </div>

                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input class="form-control" id="txtApellidoAgregar" name="apellido" type="text" placeholder="Ingresar el apellido...">
                                <div id="errorTxtApellidoAgregar"></div>
                            </div>

                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input class="form-control" id="txtDniAgregar" name="dni" type="number" placeholder="Ingresar el DNI...">
                                <div id="errorTxtDniAgregar"></div>
                            </div>

                            <div class="form-group">
                                <label for="fechaNacimiento">Fecha de Nacimiento</label>
                                <div class="input-group date bootstrap-datepicker">
                                    <input id="fechaNacimientoAgregar" type="text" name="fechaNacimiento" class="form-control" placeholder="yyyy/mm/dd"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>
                                <div id="errorFechaNacimientoAgregar"></div>
                            </div>

                            <div class="form-group">
                                <label for="direccion">Domicilio</label>
                                <input class="form-control" id="txtDireccionAgregar" name="direccion" type="text" placeholder="Ingresar el domicilio...">
                                <div id="errorDireccionAgregar"></div>
                            </div>

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
<div class="modal" tabindex="-1" role="dialog" id="modalEditar" class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Persona</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditar" method="POST">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="modal-body">
                    <div class="card-body">

                        <input type="hidden" name="organizacion_id" value="{{$organizacion->id}}">

                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreEditar" name="nombre" type="text" placeholder="Ingresar el nombre...">
                            <div id="errorTxtNombreEditar"></div>
                        </div>

                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input class="form-control" id="txtApellidoEditar" name="apellido" type="text" placeholder="Ingresar el apellido...">
                            <div id="errorTxtApellidoEditar"></div>
                        </div>

                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input class="form-control" id="txtDniEditar" name="dni" type="number" minlength="00000000" max="99999999" placeholder="Ingresar el DNI...">
                            <div id="errorTxtDniEditar"></div>
                        </div>

                        <div class="form-group">
                            <label for="fechaNacimiento">Fecha de Nacimiento</label>
                            <div class="input-group date bootstrap-datepicker">
                                <input id="fechaNacimientoEditar" type="text" name="fechaNacimiento" class="form-control" placeholder="yyyy/mm/dd"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                            <div id="errorFechaNacimientoEditar"></div>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Domicilio</label>
                            <input class="form-control" id="txtDireccionEditar" name="direccion" type="text" placeholder="Ingresar el domicilio...">
                            <div id="errorDireccionEditar"></div>
                        </div>
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
<div class="modal" tabindex="-1" role="dialog" id="modalEliminar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title w-100 text-white text-center" id="tituloModalEliminar"></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formEliminar">
            {{csrf_field()}}
            {{method_field('delete')}}
                <div class="modal-body">
                    <div id="contenidoModalEliminar" class="card-body">
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


@endsection

@section('script')

<script>
    /*
        INICIALIZANDO LOS TOOLTIPS
    */

    $(function(){
        $('[data-tooltip="tooltip"]').tooltip();
    });

    /*
        INICIALIZANDO EL DATEPICKER
    */
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        clearBtn: true,
        orientation: "bottom auto"
    });

    /*
        FIN DE LA CONFIGURACIÓN DEL DATEPICKER
    */

    /*
        VARIABLES
    */

    //Token
    const token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    //Formularios
    const formAgregar = document.getElementById('formAgregar');
    const formEditar = document.getElementById('formEditar');
    const formEliminar = document.getElementById('formEliminar');
    //Tabla
    const tabla = document.getElementById('tabla');
    //Modales
    const modalEditar = document.getElementById('modalEditar');
    const modalEliminar = document.getElementById('modalEliminar');
    //Inputs Agregar
    const nombreAgregar = document.getElementById('txtNombreAgregar');
    const apellidoAgregar = document.getElementById('txtApellidoAgregar');
    const direccionAgregar = document.getElementById('txtDireccionAgregar');
    const fechaNacimientoAgregar = document.getElementById('fechaNacimientoAgregar');
    fechaNacimientoAgregar.valuesAsDate = new Date();
    const dniAgregar = document.getElementById('txtDniAgregar');
    //Inputs Error Agregar
    let campoErrorNombreAgregar = document.querySelector('#errorTxtNombreAgregar');
    let campoErrorApellidoAgregar = document.querySelector('#errorTxtApellidoAgregar');
    let campoErrorDireccionAgregar = document.querySelector('#errorDireccionAgregar');
    let campoErrorDniAgregar = document.querySelector('#errorTxtDniAgregar');
    let campoErrorFechaNacimientoAgregar = document.querySelector('#errorFechaNacimientoAgregar');
    //Inputs Editar
    const nombreEditar = document.getElementById('txtNombreEditar');
    const apellidoEditar = document.getElementById('txtApellidoEditar');
    const direccionEditar = document.getElementById('txtDireccionEditar');
    const fechaNacimientoEditar = document.getElementById('fechaNacimientoEditar');
    const dniEditar = document.getElementById('txtDniEditar');
    //Inputs Error Editar
    let campoErrorNombreEditar = document.querySelector('#errorTxtNombreEditar');
    let campoErrorApellidoEditar = document.querySelector('#errorTxtApellidoEditar');
    let campoErrorDireccionEditar = document.querySelector('#errorDireccionEditar');
    let campoErrorDniEditar = document.querySelector('#errorTxtDniEditar');
    let campoErrorFechaNacimientoEditar = document.querySelector('#errorFechaNacimientoEditar');

    const cantidadPuesto = document.getElementById('cantidadPuesto');

    /*
        EVENTSLISTENERS
    */
   cargarEventsListeners();

    function cargarEventsListeners(){
        //Para agregar
        formAgregar.addEventListener('submit', agregar);
        nombreAgregar.addEventListener('input', validarNombreAgregar);
        apellidoAgregar.addEventListener('input', validarApellidoAgregar);
        direccionAgregar.addEventListener('input', validarDireccionAgregar);
        dniAgregar.addEventListener('input', validarDniAgregar);
        //Para eliminar
        tabla.addEventListener('click', getDatosForDelete);
        //Para actualizar
        tabla.addEventListener('click', getDatosForUpdate);
        formEditar.addEventListener('submit', editar);
        nombreEditar.addEventListener('input', validarNombreEditar);
        apellidoEditar.addEventListener('input', validarApellidoEditar);
        direccionEditar.addEventListener('input', validarDireccionEditar);
        dniEditar.addEventListener('input', validarDniEditar);

        //Para Filtrar por cantidad de puestos de trabajos
        cantidadPuesto.addEventListener('input', getPersonasPorCantidadDePuestos);
    }

    /*
        FUNCIONES DE VALIDACIÓN
    */
    function validarNombreAgregar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTexto(campo, campoErrorNombreAgregar, max);
    }

    function validarApellidoAgregar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTexto(campo, campoErrorApellidoAgregar, max);
    }

    function validarDireccionAgregar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorDireccionAgregar, max);
    }

    function validarDniAgregar(e){
        let campo = e.target;
        let max = 8;
        validarSoloNumero(campo, campoErrorDniAgregar, max);
    }

    function validarNombreEditar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTexto(campo, campoErrorNombreEditar, max);
    }

    function validarApellidoEditar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTexto(campo, campoErrorApellidoEditar, max);
    }

    function validarDireccionEditar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorDireccionEditar, max);
    }

    function validarDniEditar(e){
        let campo = e.target;
        let max = 8;
        validarSoloNumero(campo, campoErrorDniEditar, max);
    }

    function validarSoloTexto(campo, campoError, max = 0){
        //Expresion regular para validar solo letras [a-z][A-Z] con los acentos y el signo (.) punto
        let expresion = /^[a-zA-ZáÁéÉíÍóÓúÚñÑüÜ\s.]+$/;
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

    function validarSoloTextoNumero(campo, campoError, max = 0){
        /*
            Expresion regular que valida solo letras numeros y los caracteres especiales de (. , ° | &)
        */
        let expresion = /^[0-9a-zA-ZáÁéÉíÍóÓúÚñÑüÜ\s.°,&|]+$/;
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

    function validarSoloNumero(campo, campoError, max = 0){
        /*
            Expresion regular que valida solo letras numeros y los caracteres especiales de (. , ° | &)
        */
        let expresion = /^[0-9]+$/;
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

    /*
        FUNCIONES QUE INTERACTUAN CON EL BACKEND
    */
    function agregar(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreAgregar, campoErrorNombreAgregar);
        validarVacio(apellidoAgregar, campoErrorApellidoAgregar);
        validarVacio(dniAgregar, campoErrorDniAgregar);
        validarVacio(direccionAgregar, campoErrorDireccionAgregar);
        validarVacio(fechaNacimientoAgregar, campoErrorFechaNacimientoAgregar);

        let nombre = nombreAgregar.classList.contains('correcto-input');
        let apellido = apellidoAgregar.classList.contains('correcto-input');
        let dni = dniAgregar.classList.contains('correcto-input');
        let direccion = direccionAgregar.classList.contains('correcto-input');
        let fechaNacimiento = fechaNacimientoAgregar.classList.contains('correcto-input');

        if (nombre && apellido && dni && direccion && fechaNacimiento) {
            console.log("Enviando info...");
            e.target.submit();
        }
    }

    function editar(e){
        e.preventDefault();

        validarVacio(nombreEditar, campoErrorNombreEditar);
        validarVacio(apellidoEditar, campoErrorApellidoEditar);
        validarVacio(dniEditar, campoErrorDniEditar);
        validarVacio(direccionEditar, campoErrorDireccionEditar);
        validarVacio(fechaNacimientoEditar, campoErrorFechaNacimientoEditar);

        let nombre = nombreEditar.classList.contains('correcto-input');
        let apellido = apellidoEditar.classList.contains('correcto-input');
        let dni = dniEditar.classList.contains('correcto-input');
        let direccion = direccionEditar.classList.contains('correcto-input');
        let fechaNacimiento = fechaNacimientoEditar.classList.contains('correcto-input');

        if (nombre && apellido && dni && direccion && fechaNacimiento) {
            console.log("Enviando info...");
            //Envio el formulario
            e.target.submit();
        }
    }


    /*
        PARA TRAER ELEMENTOS
    */

    function getPersonasPorCantidadDePuestos(e){
        if (e.target.value != "Seleccionar") {
            const url = `getPersonas/${e.target.value}`;
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
                //Limpio la tabla y el paginador
                const paginador = document.querySelector('.pagination');

                if(paginador){
                    paginador.remove();
                }
                tabla.innerHTML = "";

                //Cargo en la tabla
                let template = "";

                datos.forEach(dato => {
                    template += `
                    <tr>
                        <td>${dato.id}</td>
                        <td>${dato.apellido + ', ' + dato.nombre}</td>
                        <td>${dato.dni}</td>
                        <td>${dato.fechaNacimiento}</td>
                        <td>${dato.direccion}</td>
                        <td>
                            ${(dato.puestos_de_trabajos_count) ? `<span class="badge badge-pill badge-info">${dato.puestos_de_trabajos_count}</span>` : `<span class="badge badge-pill badge-secondary">No Tiene</span>`}

                        </td>
                        <td>
                            <a name="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar"
                            data-tooltip="tooltip" data-placement="top" title="Editar los datos de la dato" data-id="${dato.id}"><i class="fas fa-edit" data-id="${dato.id}"></i></a>
                            <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar"
                            data-tooltip="tooltip" data-placement="top" title="Eliminar la dato" data-id="${dato.id}"><i class="fas fa-trash-alt" data-id="${dato.id}"></i></a>
                            <a name="btnVer" class="btn btn-success text-white" href="/organizacion/${dato.organizacion_id}/personas/${dato.id}"
                            data-tooltip="tooltip" data-placement="top" title="Detalle de los Puestos de Trabajos Asignados" role="button"><i class="fas fa-info-circle"></i></a>
                        </td>
                    </tr>
                    `;
                });

                tabla.innerHTML = template;

            })
            .catch(error => {
                console.log(error);
            });
        }
    }

   function getDatosForUpdate(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('editar') || e.target.classList.contains('fa-edit')) {
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `getPersona/${id}`;
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
                //Lo cargare en el modal
                nombreEditar.value = datos.nombre;
                apellidoEditar.value = datos.apellido;
                dniEditar.value = datos.dni;
                direccionEditar.value = datos.direccion;
                fechaNacimientoEditar.value = datos.fechaNacimiento;

                formEditar.setAttribute('action', 'personas/' + datos.id)
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getDatosForDelete(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('eliminar') || e.target.classList.contains('fa-trash-alt')) {
            console.log("Click btn eliminar");
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `getPersona/${id}`;
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
                const titulo = document.getElementById('tituloModalEliminar');
                titulo.innerHTML = `<strong>Eliminar ${datos.apellido}, ${datos.nombre}</strong>`;

                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar a la Persona <strong>${datos.apellido}, ${datos.nombre}</strong>?</h4>`;

                formEliminar.setAttribute('action', 'personas/' + datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }


</script>


@endsection
