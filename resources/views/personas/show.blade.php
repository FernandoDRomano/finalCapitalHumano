@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

@include('template.menu')

@endsection

@section('contenido')

<h1 class="text-center display-4 text-dark font-weight-bold mb-3">{{$organizacion->nombre}}</h1>

<h4 class="text-left text-dark font-weight-bold mb-3">Persona: <span class="text-info">{{ $persona->apellido .', '. $persona->nombre}}</span></h4>

<div class="card">
    <div class="card-header blue-marino d-flex justify-content-between align-items-center">
      <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Puestos de Trabajos ({{$persona->puestosDeTrabajos->count()}})</span></strong></h3>
      <a id="btnAgregar" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar"
      data-tooltip="tooltip" data-placement="top" title="Asignar un Nuevo Puesto de Trabajo">
        <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
    </a>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">

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
            <th>ID</th>
            <th>Nombre</th>
            <th>Nivel del Puesto</th>
            <th>Departamento</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla">

        @foreach ($puestosDeTrabajos as $puesto)
            <tr>
                <td>{{$puesto->id}}</td>
                <td>{{$puesto->nombre}}</td>
                <td>{{$puesto->nivelPuesto->nombre }}</td>
                <td>{{$puesto->departamento->nombre}}</td>

                <td>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar"
                    data-tooltip="tooltip" data-placement="top" title="Eliminar la Asignación del Puesto de Trabajo" data-id="{{$puesto->id}}"><i class="fas fa-trash-alt" data-id="{{$puesto->id}}"></i></a>
                    <a name="btnVer" class="btn btn-success text-white" href="{{route('puestosDeTrabajos.show',['organizacion' => $organizacion->id, 'puesto' => $puesto->id])}}"
                    data-tooltip="tooltip" data-placement="top" title="Detalles del Puesto de Trabajo" role="button"><i class="fas fa-info-circle"></i></a>
                    <a name="btnPDF" class="btn btn-outline-danger" href="{{action('PuestoTrabajoController@getPuestoReporte',['organizacion' => $organizacion->id, 'puesto' => $puesto->id])}}"
                        data-tooltip="tooltip" data-placement="top" title="Generar Reporte PDF" role="button"><i class="fas fa-file-pdf"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
      </table>

      {{$puestosDeTrabajos->links()}}


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
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Asignar Nuevo Puesto de Trabajo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action ('AsignacionController@storeDesdePersona', ['id' => $organizacion->id])}}" method="POST">
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

                        <input type="hidden" name="persona_id" value="{{$persona->id}}">

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
                    <input type="hidden" name="persona_id" value="{{$persona->id}}">
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

    let $eventSelectDepartamentoAgregar = $("#selectDepartamentoAgregar");
    let $eventSelectPuestoDeTrabajoAgregar = $("#selectPuestoDeTrabajoAgregar");

    /*
        EVENTOS DE JQUERY PARA CONTROLAR LOS SELECT2S
    */
    $eventSelectDepartamentoAgregar.on('select2:select', getPuestosDeTrabajosLibres);


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
    const formEliminar = document.getElementById('formEliminar');
    //Tabla
    const tabla = document.getElementById('tabla');
    //Modales
    const modalEliminar = document.getElementById('modalEliminar');
    //Inputs Agregar
    const selectDepartamentoAgregar = document.getElementById('selectDepartamentoAgregar');
    const selectPuestoDeTrabajoAgregar = document.getElementById('selectPuestoDeTrabajoAgregar');
    //Inputs Error Agregar
    let campoErrorSelectDepartamentoAgregar = document.querySelector('#errorSelectDepartamentoAgregar');
    let campoErrorSelectPuestoDeTrabajoAgregar = document.querySelector('#errorSelectPuestoDeTrabajoAgregar');
    //Inputs Editar

    /*
        EVENTSLISTENERS
    */
   cargarEventsListeners();

    function cargarEventsListeners(){
        //Para agregar
        formAgregar.addEventListener('submit', agregar);
        //Para eliminar
        tabla.addEventListener('click', getDatosForDelete);
    }

    /*
        FUNCIONES QUE INTERACTUAN CON EL BACKEND
    */

    function agregar(e){
        e.preventDefault();
        //Obtengos los datos
        validarSelect2Vacio(selectDepartamentoAgregar, campoErrorSelectDepartamentoAgregar);
        validarSelect2Vacio(selectPuestoDeTrabajoAgregar, campoErrorSelectPuestoDeTrabajoAgregar);

        let departamento = selectDepartamentoAgregar.classList.contains('correcto-input');
        let puesto = selectPuestoDeTrabajoAgregar.classList.contains('correcto-input');

        if (puesto && departamento) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> puesto: ${puesto} - departamento: ${departamento}`);

        }
    }


    /*
        FUNCIONES
    */

    function getPuestosDeTrabajosLibres(e){
        let id = e.target.value;
        let url = {{$persona->id}} + "/getPuestosDeTrabajosLibres/" + id;

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

    function cargarSelectPuesto(datos, select){
        let template = "";
        datos.forEach(dato => {
            template += `<option value="${dato.id}">${dato.nivel_puesto.nombre} - ${dato.nombre}</option>`;
        });
        select.innerHTML = template;
    }

   function getDatosForDelete(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('eliminar') || e.target.classList.contains('fa-trash-alt')) {
            console.log("Click btn eliminar");
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `../getPuestoDeTrabajo/${id}`;
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
                titulo.innerHTML = `<strong>Eliminar Asignación del Puesto</strong>`;

                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML = `
                <h4 class="text-center">¿Estas seguro quitar el Puesto de Trabajo <strong>
                <span class="text-danger">${datos.nombre}</span> </strong>?</h4>
                `;

                formEliminar.setAttribute('action', '../asignaciones/eliminar/'+ datos.id);

            })
            .catch(error => {
                console.log(error);
            });

        }
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
