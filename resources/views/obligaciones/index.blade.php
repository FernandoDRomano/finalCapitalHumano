@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

@include('template.menu')

@endsection

@section('contenido')

<h1 class="text-center display-4 font-weight-bold mb-3">{{$organizacion->nombre}}</h1>

<div class="card">
    <div class="card-header blue-marino d-flex justify-content-between align-items-center">
      <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Gestión de Obligaciones</span></strong></h3>
      <a id="btnAgregar" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar">
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
            <th>ID</th>
            <th>Nombre</th>
            <th>Puesto de Trabajo</th>
            <th>Departamento</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla">

        @foreach ($obligaciones as $obligacion)
            <tr>
                <td>{{$obligacion->id}}</td>
                <td>{{$obligacion->nombre}}</td>
                <td>{{$obligacion->puestoDeTrabajo}}</td>
                <td>{{$obligacion->departamento}}</td>
                <td>
                    <a id="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar" data-id="{{$obligacion->id}}"><i class="fas fa-edit" data-id="{{$obligacion->id}}"></i></a>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar" data-id="{{$obligacion->id}}"><i class="fas fa-trash-alt" data-id="{{$obligacion->id}}"></i></a>
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


<!-- CONTENIDO PRINCIPAL DE LA PAGINA -->

@endsection

@section('modales')

<!-- Modal Agregar -->
<div class="modal" tabindex="-1" role="dialog" id="modalAgregar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Nueva Obligación</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action ('ObligacionController@store', ['id' => $organizacion->id])}}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreAgregar" name="nombre" type="text" placeholder="Ingresar el nombre de la Obligación...">
                            <div id="errorTxtNombreAgregar"></div>
                        </div>
                        <div class="form-group">
                            <label for="selectDepartamento">Departamento</label>
                            <select id="selectDepartamentoAgregar" class="form-control" name="selectDepartamento">
                                <option selected>Seleccionar</option>
                                @forelse ($departamentos as $departamento)
                                    <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                @empty
                                    <option selected>No existen departamentos</option>
                                @endforelse
                            </select>
                            <div id="errorSelectDepartamentoAgregar"></div>
                        </div>
                        <div class="form-group">
                            <label for="selectPuestoDeTrabajo">Puesto de Trabajo</label>
                            <select id="selectPuestoDeTrabajoAgregar" class="form-control" name="selectPuestoDeTrabajo">
                                <option selected>Seleccionar</option>
                            </select>
                            <div id="errorSelectPuestoDeTrabajoAgregar"></div>
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
                <h5 class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Obligación</h5>
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
                            <input class="form-control" id="txtNombreEditar" name="nombre" type="text" placeholder="Ingresar el nombre de la Obligación...">
                            <div id="errorTxtNombreEditar"></div>
                        </div>
                        <div class="form-group">
                            <label for="selectDepartamento">Departamento</label>
                            <select id="selectDepartamentoEditar" class="form-control" name="selectDepartamento">
                                <option selected>Seleccionar</option>
                                @forelse ($departamentos as $departamento)
                                    <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                @empty
                                    <option selected>No existen departamentos</option>
                                @endforelse
                            </select>
                            <div id="errorSelectDepartamentoEditar"></div>
                        </div>
                        <div class="form-group">
                            <label for="selectPuestoDeTrabajo">Puesto de Trabajo</label>
                            <select id="selectPuestoDeTrabajoEditar" class="form-control" name="selectPuestoDeTrabajo">
                                <option selected>Seleccionar</option>
                            </select>
                            <div id="errorSelectPuestoDeTrabajoEditar"></div>
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
    const selectPuestoAgregar = document.getElementById('selectPuestoDeTrabajoAgregar');
    const selectDepartamentoAgregar = document.getElementById('selectDepartamentoAgregar');
    //Inputs Error Agregar
    let campoErrorNombreAgregar = document.querySelector('#errorTxtNombreAgregar');
    let campoErrorSelectPuestoAgregar = document.querySelector('#errorSelectPuestoDeTrabajoAgregar');
    let campoErrorSelectDepartamentoAgregar = document.querySelector('#errorSelectDepartamentoAgregar');
    //Inputs Editar
    const nombreEditar = document.getElementById('txtNombreEditar');
    const selectPuestoEditar = document.getElementById('selectPuestoDeTrabajoEditar');
    const selectDepartamentoEditar = document.getElementById('selectDepartamentoEditar');
    //Inputs Error Editar
    let campoErrorNombreEditar = document.querySelector('#errorTxtNombreEditar');
    let campoErrorSelectPuestoEditar = document.querySelector('#errorSelectPuestoDeTrabajoEditar');
    let campoErrorSelectDepartamentoEditar = document.querySelector('#errorSelectDepartamentoEditar');

    /*
        EVENTSLISTENERS
    */
   cargarEventsListeners();

    function cargarEventsListeners(){
        //Para agregar
        selectDepartamentoAgregar.addEventListener('input', getDatosSelectPuestosAgregar);
        formAgregar.addEventListener('submit', agregar);
        nombreAgregar.addEventListener('input', validarNombreAgregar);
        //Para eliminar
        tabla.addEventListener('click', getDatosForDelete);
        //Para editar
        tabla.addEventListener('click', getDatosForUpdate);
        selectDepartamentoEditar.addEventListener('input', getDatosSelectPuestosEditar);
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
        validarSelectVacio(selectPuestoAgregar, campoErrorSelectPuestoAgregar);
        validarSelectVacio(selectDepartamentoAgregar, campoErrorSelectDepartamentoAgregar);

        let nombre = nombreAgregar.classList.contains('correcto-input');
        let puesto = selectPuestoAgregar.classList.contains('correcto-input');
        let departamento = selectDepartamentoAgregar.classList.contains('correcto-input');

        if (nombre && puesto && departamento) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre} - puesto: ${puesto} - departamento: ${departamento}`);

        }
    }

    function editar(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreEditar, campoErrorNombreEditar);
        validarSelectVacio(selectPuestoEditar, campoErrorSelectPuestoEditar);
        validarSelectVacio(selectDepartamentoEditar, campoErrorSelectDepartamentoEditar);

        let nombre = nombreEditar.classList.contains('correcto-input');
        let puesto = selectPuestoEditar.classList.contains('correcto-input');
        let departamento = selectDepartamentoEditar.classList.contains('correcto-input');

        if (nombre && puesto && departamento) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre} - puesto: ${puesto} - departamento: ${departamento}`);

        }
    }

    /*
        FUNCIONES
    */

    function getDatosSelectPuestosAgregar(e){
        let id = e.target.value;
        getPuestos(selectPuestoAgregar, id);
    }

    function getDatosSelectPuestosEditar(e){
        let id = e.target.value;
        getPuestos(selectPuestoEditar, id);
    }

    function getPuestos(select, id, selected = null){
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
            cargarSelect(datos, select, selected);
        })
        .catch(error => {
            console.log(error);
        });

    }

    function cargarSelect(datos, select, selected){
        let template = "<option>Seleccionar</option>";

        if(datos.length > 0){
            datos.forEach(dato => {
                template += `<option value="${dato.id}">${dato.nombre}</option>`;
            });
        }else{
            template += "<option>No tiene Puestos de Trabajos asignados.</option>";
        }

        select.innerHTML = template;

        if(selected){
            console.log("existe valor a seleccionar");
            seleccionarPuesto(selected);
        }
    }

    function seleccionarPuesto(id){
        for (let i = 0; i < selectPuestoEditar.length; i++) {
            if(selectPuestoEditar[i].value == id){
                selectPuestoEditar[i].selected = true;
            }
        }
    }

    function getDatosForUpdate(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('editar') || e.target.classList.contains('fa-edit')) {
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `getObligacion/${id}`;
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
                //Cargo los niveles departamentales en el modal de editar
                getPuestoSeleccionado(datos.puesto_de_trabajo_id);
                //Cargo el nombre
                nombreEditar.value = datos.nombre;

                formEditar.setAttribute('action', 'obligaciones/' + datos.id)

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
            const url = `getObligacion/${id}`;
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
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar la Obligación <strong>${datos.nombre}</strong>?</h4>`;

                formEliminar.setAttribute('action', 'obligaciones/'+datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getPuestoSeleccionado(id){

    let url = "getPuesto/" + id;

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
            setSelectDepartamento(datos.departamento_id, datos.id);
        })
        .catch(error => {
            console.log(error);

        });

    }

    function setSelectDepartamento(departamento_id, puesto_id){
        for (let i = 0; i < selectDepartamentoEditar.length; i++) {
            if(selectDepartamentoEditar[i].value == departamento_id){
                selectDepartamentoEditar[i].selected = true;
            }
        }

        getPuestos(selectPuestoEditar, departamento_id, puesto_id);
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


</script>

@endsection
