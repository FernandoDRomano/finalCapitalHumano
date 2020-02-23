@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Gestión
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('organizaciones.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Organizaciones</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('personas.index', ['id' => $organizacion->id])}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Personas</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('departamentos.index', ['id' => $organizacion->id])}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Departamentos</p>
        </a>
      </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-sitemap"></i>
      <p>
        Niveles
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{url('nivelesDepartamentales')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Nivel de Departamentos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('nivelesPuestos')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Nivel de Puestos</p>
        </a>
      </li>
    </ul>
</li>

@endsection

@section('contenido')

<h1 class="text-center display-4 font-weight-bold mb-3">{{$organizacion->nombre}}</h1>

<div class="card">
    <div class="card-header">
      <h3 class="card-title"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Gestión de Departamentos</span></strong></h3>
      <a id="btnAgregar" type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar">
        <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
      </a>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive ">

        <div class="form-group row my-3 px-3">
            <div class="col-md-6">
                <form method="get" action="#">
                    <div class="input-group">
                        <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar ...">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </form>
            </div>
        </div>


      <table class="table table-hover text-nowrap px-3">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Nivel</th>
            <th>Depende de</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla">
        @foreach ($departamentos as $departamento)
            <tr>
                <td>{{$departamento->id}}</td>
                <td>{{$departamento->nombre}}</td>
                <td>{{$departamento->nivelDepartamento->nombre}}</td>
                <td>{{isset($departamento->dependeDepartamento['nombre']) ? $departamento->dependeDepartamento['nombre'] : "No Asignado"}}</td>
                <td>
                    <a id="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar" data-id="{{$departamento->id}}"><i class="fas fa-edit" data-id="{{$departamento->id}}"></i></a>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar" data-id="{{$departamento->id}}"><i class="fas fa-trash-alt" data-id="{{$departamento->id}}"></i></a>
                    <a name="btnVer" class="btn btn-success text-white" href="{{route('departamentos.show',['organizacion' => $organizacion->id, 'departamento' => $departamento->id])}}" role="button"><i class="fas fa-info-circle"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
      </table>

      {{ $departamentos->links() }}

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
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Nuevo Departamento</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action('DepartamentoController@store', ['id' => $organizacion->id]) }}" method="POST">
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
                                <label for="selectNivelDepartamento">Nivel</label>
                                <select id="selectNivelDepartamentoAgregar" class="form-control" name="selectNivelDepartamento">
                                </select>
                                <div id="errorSelectNivelDepartamentoAgregar"></div>
                            </div>

                            <div class="form-group">
                                <label for="selectDependeDe">Depende de</label>
                                <select id="selectDependeDeAgregar" class="form-control" name="selectDependeDe">
                                    <option selected>Seleccionar</option>
                                    <option value="null">Ninguno</option>
                                </select>
                                <div id="errorSelectDependeDeAgregar"></div>
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
                <h5 class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Departamento</h5>
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
                            <label for="selectNivelDepartamento">Nivel</label>
                            <select id="selectNivelDepartamentoEditar" class="form-control" name="selectNivelDepartamento" readonly>
                            </select>
                            <div id="errorSelectNivelDepartamentoEditar"></div>
                        </div>

                        <div class="form-group">
                            <label for="selectDependeDe">Depende de</label>
                            <select id="selectDependeDeEditar" class="form-control" name="selectDependeDe">
                                <option selected>Seleccionar</option>
                            </select>
                            <div id="errorSelectDependeDeEditar"></div>
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
    const btnEliminar = document.getElementById('btnEliminarForm');
    //Tabla
    const tabla = document.getElementById('tabla');
    //Modales
    const modalEditar = document.getElementById('modalEditar');
    const modalEliminar = document.getElementById('modalEliminar');
    const modalConfirmacion = document.getElementById('modalConfirmacion');
    //Inputs Agregar
    const nombreAgregar = document.getElementById('txtNombreAgregar');
    const nivelAgregar = document.getElementById('selectNivelDepartamentoAgregar');
    const dependeDeAgregar = document.getElementById('selectDependeDeAgregar');
    //Inputs Error Agregar
    let campoErrorNombreAgregar = document.querySelector('#errorTxtNombreAgregar');
    let campoErrorSelectNivelDepartamentoAgregar = document.querySelector('#errorSelectNivelDepartamentoAgregar');
    let campoErrorSelectDependeDeAgregar = document.querySelector('#errorSelectDependeDeAgregar');
    //Inputs Editar
    const nombreEditar = document.getElementById('txtNombreEditar');
    const nivelEditar = document.getElementById('selectNivelDepartamentoEditar');
    const dependeDeEditar = document.getElementById('selectDependeDeEditar');
    //Inputs Error Editar
    let campoErrorNombreEditar = document.querySelector('#errorTxtNombreEditar');
    let campoErrorSelectNivelDepartamentoEditar = document.querySelector('#errorSelectNivelDepartamentoEditar');
    let campoErrorSelectDependeDeEditar = document.querySelector('#errorSelectDependeDeEditar');

    /*
        EVENTSLISTENERS
    */
   cargarEventsListeners();

    function cargarEventsListeners(){
        //Para agregar
        btnAgregar.addEventListener('click', getNivelesDepartamentales);
        formAgregar.addEventListener('submit', agregar);
        nombreAgregar.addEventListener('input', validarNombreAgregar);
        nivelAgregar.addEventListener('change', validarSelectAgregar);
        nivelAgregar.addEventListener('change', getNivelSuperior);
        //Para eliminar
        tabla.addEventListener('click', getDatosForDelete);
        //Para actualizar
        tabla.addEventListener('click', getDatosForUpdate);
        formEditar.addEventListener('submit', editar);
        nombreEditar.addEventListener('input', validarNombreEditar);
        nivelEditar.addEventListener('change', validarSelectEditar);
        nivelEditar.addEventListener('change', getNivelSuperior);
    }

    /*
        FUNCIONES DE VALIDACIÓN
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

    function validarSelectAgregar(e){
        let mensaje = '';
        if(e.target.classList.contains('error-input')){
            e.target.classList.remove('error-input');
            e.target.classList.add('correcto-input');
            mensaje = `<small id="mensaje" class="form-text text-green"><strong>Perfecto</strong></small>`;
            campoErrorSelectNivelDepartamentoAgregar.innerHTML = mensaje;
        }
    }

    function validarSelectEditar(e){
        let mensaje = '';
        if(e.target.classList.contains('error-input')){
            e.target.classList.remove('error-input');
            e.target.classList.add('correcto-input');
            mensaje = `<small id="mensaje" class="form-text text-green"><strong>Perfecto</strong></small>`;
            campoErrorSelectNivelDepartamentoEditar.innerHTML = mensaje;
        }
    }

    /*
        FUNCIONES QUE INTERACTUAN CON EL BACKEND
    */
    function agregar(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreAgregar, campoErrorNombreAgregar);
        validarSelectVacio(nivelAgregar, campoErrorSelectNivelDepartamentoAgregar);
        validarSelectVacio(dependeDeAgregar, campoErrorSelectDependeDeAgregar);

        let nombre = nombreAgregar.classList.contains('correcto-input');
        let nivel = nivelAgregar.classList.contains('correcto-input');
        let dependeDe = dependeDeAgregar.classList.contains('correcto-input');

        if (nombre && nivel && dependeDe) {
            console.log("Enviando info...");
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre} - nivel: ${nivel} - dependeDe: ${dependeDe}`);

        }
    }

    function editar(e){
        e.preventDefault();
        //Obtengos los datos
        validarVacio(nombreEditar, campoErrorNombreEditar);
        validarSelectVacio(nivelEditar, campoErrorSelectNivelDepartamentoEditar);
        validarSelectVacio(dependeDeEditar, campoErrorSelectDependeDeEditar);

        let nombre = nombreEditar.classList.contains('correcto-input');
        let nivel = nivelEditar.classList.contains('correcto-input');
        let dependeDe = dependeDeEditar.classList.contains('correcto-input');

        if (nombre && nivel && dependeDe) {
            console.log("Enviando info a servidor...");
            console.log(`nombre: ${nombreEditar.value} - nivel: ${nivelEditar.value} - dependeDe: ${dependeDeEditar.value}`);
            e.target.submit();
        }else{
            console.log(`revisar -> nombre: ${nombre} - nivel: ${nivel} - dependeDe: ${dependeDe}`);
        }
    }


    /*
        PARA TRAER ELEMENTOS
    */

   function getDatosForUpdate(e){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        if (e.target.classList.contains('editar') || e.target.classList.contains('fa-edit')) {
            //CONSTRUYO LA URL
            const id = e.target.getAttribute('data-id');
            const url = `getDepartamento/${id}`;
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
                getNivelesDepartamentales();
                //Cargo el nombre
                nombreEditar.value = datos.nombre;

                //Espero 0.5 segundo, dando tiempo que se carguen los niveles desde fetch. Luego selecciono el nivel
                setTimeout(() => {
                    //Recorro el select de niveles para colocar en true el selected del nivel escogido
                    for (let i = 0; i < nivelEditar.length; i++) {
                        if(nivelEditar[i].value == datos.nivel_departamento_id){
                            nivelEditar[i].selected = true;
                        }
                    }
                    //Obtengo el nivel superior del nivel seleccionado anteriormente
                    getNivelSuperiorEditar(nivelEditar.value);
                }, 500);

                //Espero 1 segundo, dando tiempo que se carguen los departamientos correspondientes al nivel superior
                setTimeout(() => {
                    //Recorro el select de departamentos dependientes para colocar en true el selected del departamento escogido
                    for (let i = 0; i < dependeDeEditar.length; i++) {
                        if(dependeDeEditar[i].value == datos.depende_departamento_id){
                            dependeDeEditar[i].selected = true;
                        }
                    }
                }, 1000);

                formEditar.setAttribute('action', 'departamentos/' + datos.id)

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
            const url = `getDepartamento/${id}`;
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
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar al Departamento <strong>${datos.nombre}</strong>?</h4>`;

                getDepartamentosDependientes(datos.id);

                formEliminar.setAttribute('action', 'departamentos/'+datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getNivelesDepartamentales(){
       console.log("Obteniendo niveles departamentales...");

        let url = "getNivelesDepartamentales";

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
            cargarNivelesDepartamentales(datos);
        })
        .catch(error => {
            console.log(error);
        });
   }

function cargarNivelesDepartamentales(datos){
    let template = '<option value="">Seleccionar</option>';
    datos.forEach(nivel => {
        template += `<option value="${nivel.id}">${nivel.jerarquia} - ${nivel.nombre}</option>`;
    });

    nivelEditar.innerHTML = template;
    nivelAgregar.innerHTML = template;
}

function getNivelSuperior(e){
    //Obtengo el id
    let id = e.target.value;
    //Valido si el id existe
    if(id != ""){
        //Armo la url y el fetch
        let url = "getNivelSuperior/" + id;

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
            //console.log(response);
            return response.json();
        })
        .then(datos => {
            if (datos.length > 0) {
                datos.forEach(elemento =>{
                    console.log("Llmando a los departamentos");
                    getDepartamentosPorNivel(elemento.id);
                });
            }else{
                noExisteNivelSuperior();
            }
        })
        .catch(error => {
            console.log(error);

        });
    }

}

function getNivelSuperiorEditar(id){
    //Valido si el id existe
    if(id != ""){
        //Armo la url y el fetch
        let url = "getNivelSuperior/" + id;

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
            //console.log(response);
            return response.json();
        })
        .then(datos => {
            if (datos.length > 0) {
                datos.forEach(elemento =>{
                    console.log("Llamando a los departamentos");
                    getDepartamentosPorNivel(elemento.id);
                });
            }else{
                noExisteNivelSuperior();
            }
        })
        .catch(error => {
            console.log(error);

        });
    }

}

function noExisteNivelSuperior(){
    let template = `<option value="null">No existe nivel superior</option>`;
    dependeDeAgregar.innerHTML = template;
    dependeDeEditar.innerHTML = template;
}

function noExisteDepartamentosParaElNivelSuperior(){
    let template = `<option value="null">No existen departamentos registrados en el nivel superior</option>`;
    dependeDeAgregar.innerHTML = template;
    dependeDeEditar.innerHTML = template;
}

function getDepartamentosPorNivel(id){
    //Valido si el id existe
    if(id != ""){
        //Armo la url y el fetch
        let url = "getDepartamentosPorNivel/" + id;

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
                cargarDepartamentos(datos);
            }else{
                noExisteDepartamentosParaElNivelSuperior();
            }
        })
        .catch(error => {
            console.log(error);

        });
    }
}

function cargarDepartamentos(datos){
    let template = '<option value="">Seleccionar</option>';
    datos.forEach(departamento => {
        template += `<option value="${departamento.id}">${departamento.nombre}</option>`;
    });

    dependeDeAgregar.innerHTML = template;
    dependeDeEditar.innerHTML = template;
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

</script>


@endsection
