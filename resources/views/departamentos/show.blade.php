@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

@include('template.menu')

@endsection

@section('contenido')

<h1 class="text-center display-4 text-dark font-weight-bold mb-3">{{$organizacion->nombre}}</h1>

<h4 class="text-left text-dark font-weight-bold mb-3">Departamento: <span class="text-info">{{$departamento->nombre}}</span></h4>
<h4 class="text-left text-dark font-weight-bold mb-3">Nivel: <span class="text-info">{{$departamento->nivelDepartamento->nombre}}</span> </h4>


<div class="card">
    <div class="card-header blue-marino d-flex justify-content-between align-items-center">
      <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Puestos de Trabajos ({{$departamento->puestos->count()}})</span></strong></h3>
      <a id="btnAgregar" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar"
      data-tooltip="tooltip" data-placement="top" title="Agregar un Nuevo Puesto de Trabajo al Departamento">
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
            <th>Funciones</th>
            <th>Obligaciones</th>
            <th>Personas</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla">

        @foreach ($puestosDeTrabajos as $puesto)
            <tr>
                <td>{{$puesto->id}}</td>
                <td>{{$puesto->nombre}}</td>
                <td>{{$puesto->nivelPuesto->nombre }}</td>
                <td>
                    @if ($puesto->funciones->count() > 0)
                    <span class="badge badge-pill badge-info">{{$puesto->funciones->count()}}</span>
                    @else
                    <span class="badge badge-pill badge-secondary">No Tiene</span>
                    @endif
                </td>
                <td>
                    @if ($puesto->obligaciones->count() > 0)
                    <span class="badge badge-pill badge-info">{{$puesto->obligaciones->count()}}</span>
                    @else
                    <span class="badge badge-pill badge-secondary">No Tiene</span>
                    @endif
                </td>
                <td>
                    @if ($puesto->personas->count() > 0)
                    <span class="badge badge-pill badge-info">{{$puesto->personas->count()}}</span>
                    @else
                    <span class="badge badge-pill badge-secondary">No Tiene</span>
                    @endif
                </td>
                <td>
                    <a id="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar"
                    data-tooltip="tooltip" data-placement="top" title="Editar los datos del Puesto de Trabajo" data-id="{{$puesto->id}}"><i class="fas fa-edit" data-id="{{$puesto->id}}"></i></a>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar"
                    data-tooltip="tooltip" data-placement="top" title="Eliminar el Puesto de Trabajo del Departamento" data-id="{{$puesto->id}}"><i class="fas fa-trash-alt" data-id="{{$puesto->id}}"></i></a>
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
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Nuevo Puesto de Trabajo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action ('PuestoTrabajoController@storeDesdeDepartamento', ['id' => $organizacion->id])}}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreAgregar" name="nombre" type="text" placeholder="Ingresar el nombre del Puesto...">
                            <div id="errorTxtNombreAgregar"></div>
                        </div>
                        <div class="form-group">
                            <label for="selectNivelPuestoDeTrabajo">Nivel del Puesto</label>
                            <select id="selectNivelPuestoDeTrabajoAgregar" class="form-control" name="selectNivelPuestoDeTrabajo">
                                <option value="">Seleccionar</option>
                                @forelse ($niveles as $nivel)
                                    <option value="{{$nivel->id}}">{{$nivel->nombre}}</option>
                                @empty
                                    <option value="">No existen niveles de puestos creados.</option>
                                @endforelse
                            </select>
                            <div id="errorSelectNivelPuestoDeTrabajoAgregar"></div>
                        </div>
                        <input type="hidden" name="selectDepartamento" value="{{$departamento->id}}">
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
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreEditar" name="nombre" type="text" placeholder="Ingresar el nombre del Puesto...">
                            <div id="errorTxtNombreEditar"></div>
                        </div>
                        <div class="form-group">
                            <label for="selectNivelPuestoDeTrabajo">Nivel del Puesto</label>
                            <select id="selectNivelPuestoDeTrabajoEditar" class="form-control" name="selectNivelPuestoDeTrabajo">
                                <option value="">Seleccionar</option>
                                @forelse ($niveles as $nivel)
                                    <option value="{{$nivel->id}}">{{$nivel->nombre}}</option>
                                @empty
                                    <option value="">No existen niveles de puestos creados.</option>
                                @endforelse
                            </select>
                            <div id="errorSelectNivelPuestoDeTrabajoEditar"></div>
                        </div>
                        <input type="hidden" name="selectDepartamento" value="{{$departamento->id}}">
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
    const nombreAgregar = document.getElementById('txtNombreAgregar');
    const selectNivelAgregar = document.getElementById('selectNivelPuestoDeTrabajoAgregar');
    //Inputs Error Agregar
    let campoErrorNombreAgregar = document.querySelector('#errorTxtNombreAgregar');
    let campoErrorSelectNivelPuestoAgregar = document.querySelector('#errorSelectNivelPuestoDeTrabajoAgregar');
    //Inputs Editar
    const nombreEditar = document.getElementById('txtNombreEditar');
    const selectNivelEditar = document.getElementById('selectNivelPuestoDeTrabajoEditar');
    //Inputs Error Editar
    let campoErrorNombreEditar = document.querySelector('#errorTxtNombreEditar');
    let campoErrorSelectNivelPuestoEditar = document.querySelector('#errorSelectNivelPuestoDeTrabajoEditar');

    /*
        EVENTSLISTENERS
    */
   cargarEventsListeners();

    function cargarEventsListeners(){
        //Para agregar
        formAgregar.addEventListener('submit', agregar);
        nombreAgregar.addEventListener('input', validarNombreAgregar);
        //Para eliminar
        tabla.addEventListener('click', getDatosForDelete);
        //Para editar
        tabla.addEventListener('click', getDatosForUpdate);
        formEditar.addEventListener('submit', editar);
        nombreEditar.addEventListener('input', validarNombreEditar);
    }

    /*
        FUNCIONES QUE INTERACTUAN CON EL BACKEND
    */

    function agregar(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreAgregar, campoErrorNombreAgregar);
        validarSelectVacio(selectNivelAgregar, campoErrorSelectNivelPuestoAgregar);

        let nombre = nombreAgregar.classList.contains('correcto-input');
        let nivel = selectNivelAgregar.classList.contains('correcto-input');

        if (nombre && nivel) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre} - nivel: ${nivel}`);

        }
    }

    function editar(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreEditar, campoErrorNombreEditar);
        validarSelectVacio(selectNivelEditar, campoErrorSelectNivelPuestoEditar);

        let nombre = nombreEditar.classList.contains('correcto-input');
        let nivel = selectNivelEditar.classList.contains('correcto-input');

        if (nombre && nivel) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre} - nivel: ${nivel}`);

        }
    }

    /*
        FUNCIONES
    */


    function getDatosForUpdate(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('editar') || e.target.classList.contains('fa-edit')) {
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
                //Cargo el nombre
                nombreEditar.value = datos.nombre;

                 //Recorro el select de niveles de puestos para colocar en true el selected del departamento escogido
                for (let i = 0; i < selectNivelEditar.length; i++) {
                    if(selectNivelEditar[i].value == datos.nivel_puesto_id){
                        selectNivelEditar[i].selected = true;
                    }
                }

                formEditar.setAttribute('action', '../puestosDeTrabajos/editar/' + datos.id)

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
                titulo.innerHTML = `<strong>Eliminar ${datos.nombre}</strong>`;

                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar el Puesto de Trabajo <strong>${datos.nombre}</strong>?</h4>`;

                getObligacionesDependientes(datos.id);
                getFuncionesDependientes(datos.id);

                formEliminar.setAttribute('action', '../puestosDeTrabajos/eliminar/'+datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getDepartamentosDependientes(id){

    let url = "getDepartamentosDependientes/" + id;

    console.log(url);

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

            if (datos.length > 0) {
                let template = `
                <h5 class="font-weight-bold mt-3">Departamentos dependientes:</h5>
                <ul class="list-group mt-4">`;
                datos.forEach(dato => {
                    template += `<li class="list-group-item list-group-item-danger">${dato.nombre}</li>`
                });
                template += `
                </ul>
                <p class="font-weight-bold mt-4 text-danger">Nota: Si lo elimina, los departamentos dependientes de este seran eliminados.</p>
                `;
                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML += template;
            }
        })
        .catch(error => {
            console.log(error);

        });

    }

    function getObligacionesDependientes(id){

        let url = "../getObligacionesDependientes/" + id;

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

            if (datos.length > 0) {
                let template = `
                <h5 class="font-weight-bold mt-3">Obligaciones dependientes del Puesto:</h5>
                <ul class="list-group mt-4">`;
                datos.forEach(dato => {
                    template += `<li class="list-group-item list-group-item-danger">${dato.nombre}</li>`
                });
                template += `
                </ul>
                <p class="font-weight-bold mt-4 text-danger">Nota: Si lo elimina, las Obligaciones dependientes de este seran eliminados.</p>
                `;
                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML += template;
            }
        })
        .catch(error => {
            console.log(error);

        });

    }

    function getFuncionesDependientes(id){

        let url = "../getFuncionesDependientes/" + id;

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

            if (datos.length > 0) {
                let template = `
                <h5 class="font-weight-bold mt-3">Funciones dependientes del Puesto:</h5>
                <ul class="list-group mt-4">`;
                datos.forEach(dato => {
                    template += `<li class="list-group-item list-group-item-danger">${dato.nombre}</li>`
                });
                template += `
                </ul>
                <p class="font-weight-bold mt-4 text-danger">Nota: Si lo elimina, las Funciones dependientes de este seran eliminados.</p>
                `;
                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML += template;
            }
        })
        .catch(error => {
            console.log(error);

        });

    }

    /*
        VALIDACIONES
    */

    function validarNombreAgregar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorNombreAgregar, max);
    }

    function validarNombreEditar(e){
        let campo = e.target;
        let max = 45;
        validarSoloTextoNumero(campo, campoErrorNombreEditar, max);
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
        }else{
            campo.classList.remove('error-input');
            campo.classList.add('correcto-input');
            mensaje = `<small id="mensaje" class="form-text text-green"><strong>Perfecto.</strong></small>`;
            campoError.innerHTML = mensaje;
        }
    }

    </script>

</script>

@endsection
