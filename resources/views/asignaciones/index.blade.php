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
      <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Asignación de Personas a los Puestos de Trabajos</span></strong></h3>
      <a id="btnAgregar" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar"
      data-tooltip="tooltip" data-placement="top" title="Agregar Asignación de Puesto de Trabajo a las Personas">
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
        </div>


    <table class="table table-hover table-sm text-nowrap px-3 table-striped text-center">
        <thead class="thead-dark text-uppercase">
          <tr>
            <th>Departamento</th>
            <th>Puesto</th>
            <th>Persona</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla">

            @foreach ($asignaciones as $asignacion)

            <tr>
                <td>{{$asignacion->departamento }}</td>
                <td>{{$asignacion->puesto}}</td>
                <td>{{$asignacion->personaApellido . ', ' . $asignacion->personaNombre}}</td>
                <td>
                    <a id="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar"
                    data-tooltip="tooltip" data-placement="top" title="Editar datos de la Asignación del Puesto de Trabajo" data-id="{{$asignacion->id}}"><i class="fas fa-edit" data-id="{{$asignacion->id}}"></i></a>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar"
                    data-tooltip="tooltip" data-placement="top" title="Eliminar Asignación del Puesto de Trabajo" data-id="{{$asignacion->id}}"><i class="fas fa-trash-alt" data-id="{{$asignacion->id}}"></i></a>
                </td>
            </tr>

            @endforeach

        </tbody>
      </table>

      {{$asignaciones->links()}}

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
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Nuevo Asignacion de Persona a Puesto de Trabajo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action ('AsignacionController@store', ['id' => $organizacion->id])}}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="selectDepartamento">Departamento</label>
                            <select id="selectDepartamentoAgregar" class="form-control select2 selectSimple" multiple="multiple" name="selectDepartamento" style="width: 100%">
                                <option >Seleccionar</option>
                                @forelse ($departamentos as $departamento)
                                <option value="{{$departamento->id}}">{{$departamento->niveldepartamento->nombre .' - '. $departamento->nombre}}</option>
                                @empty
                                <option >No existen departamenos registrados en esta organización</option>
                                @endforelse
                            </select>
                            <div id="errorSelectDepartamentoAgregar"></div>
                        </div>

                        <div class="form-group">
                            <label for="selectPuestoDeTrabajo">Puesto de Trabajo</label>
                            <select id="selectPuestoDeTrabajoAgregar" class="select2 selectSimple form-control" name="selectPuestoDeTrabajo" multiple="multiple" style="width: 100%">

                            </select>
                            <div id="errorSelectPuestoDeTrabajoAgregar"></div>
                        </div>

                        <div class="form-group">
                            <label for="selectPersona">Personas</label>
                            <select id="selectPersonaAgregar" name="selectPersona[]" class="form-control select2 selectMultiple" multiple="multiple" style="width: 100%;">

                            </select>
                            <div id="errorSelectPersonaAgregar"></div>
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
                <h5 class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Puesto de Trabajo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditar" method="POST">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="selectDepartamento">Departamento</label>
                            <select id="selectDepartamentoEditar" class="form-control select2 selectSimple" name="selectDepartamento" multiple="multiple" style="width: 100%" disabled>
                                <option >Seleccionar una Opción</option>
                                @forelse ($departamentos as $departamento)
                                <option value="{{$departamento->id}}">{{$departamento->niveldepartamento->nombre .' - '. $departamento->nombre}}</option>
                                @empty
                                <option >No existen departamentos registrados en esta organización</option>
                                @endforelse
                            </select>
                            <div id="errorSelectDepartamentoEditar"></div>
                        </div>

                        <div class="form-group">
                            <label for="selectPuestoDeTrabajo">Puesto de Trabajo</label>
                            <select id="selectPuestoDeTrabajoEditar" class="select2 selectSimple form-control" name="selectPuestoDeTrabajo" multiple="multiple" style="width: 100%" disabled>
                                @forelse ($puestosDeTrabajos as $puesto)
                                <option value="{{$puesto->id}}">{{$puesto->nombre}}</option>
                                @empty
                                <option >No existen puestos de trabajos registrados en esta organización</option>
                                @endforelse
                            </select>
                            <div id="errorSelectPuestoDeTrabajoEditar"></div>
                        </div>

                        <div class="form-group">
                            <label for="selectPersona">Personas</label>
                            <select id="selectPersonaEditar" name="selectPersona" class="form-control select2 selectSimple" multiple="multiple" style="width: 100%;">
                                @forelse ($personas as $persona)
                                <option value="{{$persona->id}}">{{$persona->apellido .', '. $persona->nombre}}</option>
                                @empty
                                <option >No existen personas registradas en esta organización</option>
                                @endforelse
                            </select>
                            <div id="errorSelectPersonaEditar"></div>
                          </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning text-white">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
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
    JQUERY
*/

    /*
        INICIALIZANDO LOS TOOLTIPS
    */

    $(function(){
        $('[data-tooltip="tooltip"]').tooltip();
    });

//$('.js-example-basic-multiple').select2({});
$('.selectMultiple').select2({
    placeholder: 'Seleccione opción',
    maximumSelectionLength: 5,
    language: "es",
    allowClear: true
})

$('.selectSimple').select2({
    placeholder: 'Seleccione opción',
    maximumSelectionLength: 1,
    language: "es",
    allowClear: true
})

let $eventSelectPuestoDeTrabajoAgregar = $("#selectPuestoDeTrabajoAgregar");
let $eventSelectPuestoDeTrabajoEditar = $("#selectPuestoDeTrabajoEditar");
let $eventSelectDepartamentoAgregar = $("#selectDepartamentoAgregar");

/*
    EVENTOS DE JQUERY PARA CONTROLAR LOS SELECT2S
*/
$eventSelectDepartamentoAgregar.on('select2:select', getPuestosDeTrabajos);
$eventSelectPuestoDeTrabajoAgregar.on("select2:select", getPersonas);



    function mostrarValor(e){
        console.log("Seleccionado: ", e.target.value);
    }

/*
    FIN DE JQUERY
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
    //Botones
    const btnAgregar = document.getElementById('btnAgregar');
    const btnEditar = document.getElementById('btnEditar');
    //Tabla
    const tabla = document.getElementById('tabla');
    //Modales
    const modalEditar = document.getElementById('modalEditar');
    const modalEliminar = document.getElementById('modalEliminar');
    const modalConfirmacion = document.getElementById('modalConfirmacion');
    //Inputs Agregar
    const selectPersonaAgregar = document.getElementById('selectPersonaAgregar');
    const selectDepartamentoAgregar = document.getElementById('selectDepartamentoAgregar');
    const selectPuestoDeTrabajoAgregar = document.getElementById('selectPuestoDeTrabajoAgregar');
    //Inputs Error Agregar
    let campoErrorSelectDepartamentoAgregar = document.querySelector('#errorSelectDepartamentoAgregar');
    let campoErrorSelectPersonaAgregar = document.querySelector('#errorSelectPersonaAgregar');
    let campoErrorSelectPuestoDeTrabajoAgregar = document.querySelector('#errorSelectPuestoDeTrabajoAgregar');
    //Inputs Editar
    const selectPersonaEditar = document.getElementById('selectPersonaEditar');
    const selectPuestoDeTrabajoEditar = document.getElementById('selectPuestoDeTrabajoEditar');
    //Inputs Error Editar
    let campoErrorSelectDepartamentoEditar = document.querySelector('#errorSelectDepartamentoEditar');
    let campoErrorSelectPersonaEditar = document.querySelector('#errorSelectPersonaEditar');
    let campoErrorSelectPuestoDeTrabajoEditar = document.querySelector('#errorSelectPuestoDeTrabajoEditar');



    selectPuestoDeTrabajoAgregar.addEventListener('select2:select', (e)=>{
        console.log("Seleccionado: ", e.target.value);
    });

    /*
        EVENTSLISTENERS
    */
   cargarEventsListeners();

    function cargarEventsListeners(){
        //Para agregar
        formAgregar.addEventListener('submit', agregar);
        //Para eliminar
        tabla.addEventListener('click', getDatosForDelete);
        //Para editar
        tabla.addEventListener('click', getDatosForUpdate);
        formEditar.addEventListener('submit', editar);
    }

    /*
        FUNCIONES QUE INTERACTUAN CON EL BACKEND
    */

    function agregar(e){
        e.preventDefault();
        //Obtengos los datos
        validarSelect2Vacio(selectDepartamentoAgregar, campoErrorSelectDepartamentoAgregar);
        validarSelect2Vacio(selectPuestoDeTrabajoAgregar, campoErrorSelectPuestoDeTrabajoAgregar);
        validarSelect2Vacio(selectPersonaAgregar, campoErrorSelectPersonaAgregar);

        let departamento = selectDepartamentoAgregar.classList.contains('correcto-input');
        let puesto = selectPuestoDeTrabajoAgregar.classList.contains('correcto-input');
        let persona = selectPersonaAgregar.classList.contains('correcto-input');

        if (persona && puesto && departamento) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> persona: ${persona} - puesto: ${puesto} - departamento: ${departamento}`);

        }
    }

    function editar(e){
        e.preventDefault();
        //Obtengos los datos
        validarSelect2Vacio(selectDepartamentoEditar, campoErrorSelectDepartamentoEditar);
        validarSelect2Vacio(selectPuestoDeTrabajoEditar, campoErrorSelectPuestoDeTrabajoEditar);
        validarSelect2Vacio(selectPersonaEditar, campoErrorSelectPersonaEditar);

        let departamento = selectDepartamentoEditar.classList.contains('correcto-input');
        let puesto = selectPuestoDeTrabajoEditar.classList.contains('correcto-input');
        let persona = selectPersonaEditar.classList.contains('correcto-input');

        if (persona && puesto && departamento) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> persona: ${persona} - puesto: ${puesto} - departamento: ${departamento}`);

        }
    }


    /*
        FUNCIONES
    */

    function getPuestosDeTrabajos(e){
        let id = e.target.value;
        let url = "getPuestosDeTrabajos/" + id;
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
        .then(response => {
            console.log(response);
            return response.json();
        })
        .then(datos => {
            console.log(datos);
            cargarSelectPuesto(datos, selectPuestoDeTrabajoAgregar);
        })
        .catch(error => {
            console.log(error);
        });

    }

    function getPersonas(e){
        let id = e.target.value;
        let url = "getPersonas/" + id;
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
        .then(response => {
            console.log(response);
            return response.json();
        })
        .then(datos => {
            console.log(datos);
            cargarSelectPersona(datos, selectPersonaAgregar);
        })
        .catch(error => {
            console.log(error);
        });

    }

    function cargarSelectPuesto(datos, select){
        let template = "";
        datos.forEach(dato => {
            template += `<option value="${dato.id}">${dato.nivel_puesto.nombre} - ${dato.nombre}</option>`;
        });
        select.innerHTML = template;
    }

    function cargarSelectPersona(datos, select){
        let template = "";
        datos.forEach(dato => {
            template += `<option value="${dato.id}">${dato.apellido + ', ' + dato.nombre}</option>`;
        });
        select.innerHTML = template;
    }

   function getDatosForDelete(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('eliminar') || e.target.classList.contains('fa-trash-alt')) {
            console.log("Click btn eliminar");
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `getAsignacion/${id}`;
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
                titulo.innerHTML = `<strong>Eliminar Asignación de Personal</strong>`;

                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML = `
                <h4 class="text-center">¿Estas seguro de Eliminar esta Asignación de Trabajo <strong>
                <span class="text-danger">${datos[0].puesto.nombre}</span> - <span class="text-danger">${datos[0].persona.apellido + ', ' +datos[0].persona.nombre}</span>
                </strong>?</h4>
                `;

                formEliminar.setAttribute('action', 'asignaciones/'+ datos[0].id);
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
            const url = `getAsignacion/${id}`;
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
                //BUSCO LOS ID DE LAS ENTIDADES
                let departamento_id = datos[0].puesto.departamento_id;
                let puesto_id = datos[0].puesto.id;
                let persona_id = datos[0].persona.id;
                //BUSCO LAS PERONAS QUE PERTENECEN AL PUESTO Y MANDO EL QUE TIENEN QUE MARCAR
                getPersonasEditar(puesto_id, persona_id);

                //SELECCIONO EL VALOR DEL DEPARTAMENTO Y DEL PUESTO
                $('#selectDepartamentoEditar').val(departamento_id).trigger("change");
                $('#selectPuestoDeTrabajoEditar').val(puesto_id).trigger("change");

                //AGREGO EL OPTION DE LA PERSONA QUE VIENE DE BD, YA QUE VIENEN FILTRADOS POR LOS OCUPADOS
                //PERO NECESITO AGREGARLO POR EL ECHO DE SELECCIONARLO DE NUEVO
                selectPersonaEditar.innerHTML = `<option value="${datos[0].persona.id}" >${datos[0].persona.apellido + ', ' + datos[0].persona.nombre}</option>`;

                formEditar.setAttribute('action', 'asignaciones/'+ datos[0].id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getPersonasEditar(id, seleccionado){
        let url = "getPersonas/" + id;
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
        .then(response => {
            console.log(response);
            return response.json();
        })
        .then(datos => {
            console.log(datos);
            cargarSelectPersonaEditar(datos, selectPersonaEditar, seleccionado);
        })
        .catch(error => {
            console.log(error);
        });

    }

    function cargarSelectPersonaEditar(datos, select, seleccionado){
        let template = "";
        datos.forEach(dato => {
            template += `<option value="${dato.id}">${dato.apellido + ', ' + dato.nombre}</option>`;
        });

        //NO BORRO EL HTML QUE YA TENIA, SOLO LE AGREGO LAS NUEVAS OPCIONES
        select.innerHTML += template;

        //SELECCIONA CON JQUERY EL VALOR DEL SELECT2
        $('#selectPersonaEditar').val([seleccionado]).trigger("change");
    }

    /*
        VALIDACIONES
    */

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
