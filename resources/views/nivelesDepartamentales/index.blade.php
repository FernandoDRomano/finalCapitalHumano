@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

<li class="nav-item">
    <a href="{{url('organizaciones')}}" class="nav-link">
        <i class="nav-icon fas fa-building"></i>
        <p>
          Organizaciones
        </p>
    </a>
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


<div class="card">
    <div class="card-header">
      <h3 class="card-title"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Gestión de Niveles Departamentales</span></strong></h3>
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
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla">
        @foreach ($nivelesDepartamentales as $nivel)
            <tr>
                <td>{{$nivel->id}}</td>
                <td>{{$nivel->jerarquia . ' - ' . $nivel->nombre}}</td>
                <td>
                    <a name="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar" data-id="{{$nivel->id}}"><i class="fas fa-edit" data-id="{{$nivel->id}}"></i></a>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar" data-id="{{$nivel->id}}"><i class="fas fa-trash-alt" data-id="{{$nivel->id}}"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
      </table>

      {{ $nivelesDepartamentales->links() }}

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
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Nuevo Nivel Departamental</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action('NivelDepartamentoController@store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="selectJerarquia">Jerarquia</label>
                                        <select id="selectJerarquiaAgregar" class="form-control" name="selectJerarquia">
                                            <option selected>Seleccionar</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                        <div id="errorSelectJerarquiaAgregar"></div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control" id="txtNombreAgregar" name="nombre" type="text" placeholder="Ingresar el nombre del Nivel Departamental...">
                                        <div id="errorTxtNombreAgregar"></div>
                                    </div>
                                </div>
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
                <h5 class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Nivel Departamental</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditar" method="POST">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="selectJerarquia">Jerarquia</label>
                                    <select id="selectJerarquiaEditar" class="form-control" name="selectJerarquia">
                                        <option selected>Seleccionar</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <div id="errorSelectJerarquiaEditar"></div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input class="form-control" id="txtNombreEditar" name="nombre" type="text" placeholder="Ingresar el nombre del Nivel Departamental...">
                                    <div id="errorTxtNombreEditar"></div>
                                </div>
                            </div>
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
    //Variables
    const token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    const formAgregar = document.getElementById('formAgregar');
    const formEditar = document.getElementById('formEditar');
    const formEliminar = document.getElementById('formEliminar');
    const tabla = document.getElementById('tabla');
    const modalEditar = document.getElementById('modalEditar');
    const modalEliminar = document.getElementById('modalEliminar');
    const btnAgregar = document.getElementById('btnAgregar');

    //EventsListeners
    cargarEventsListeners();

    function cargarEventsListeners(){
        tabla.addEventListener('click', getDatosForUpdate);
        tabla.addEventListener('click', getDatosForDelete);
        formAgregar.addEventListener('submit', agregar);
        formEditar.addEventListener('submit', editar);
        btnAgregar.addEventListener('click', getJerarquias);
    }

    //Funciones
    function agregar(e){
        e.preventDefault();
        //Obtengos los datos
        const campo = document.getElementById('txtNombreAgregar');
        const select = document.getElementById('selectJerarquiaAgregar');

        let resultadoCampo = validarLongitud(campo);
        let resultadoSelect = validarSelect(select);

        if(resultadoCampo === "" && resultadoSelect === ""){
            console.log("Enviando Info....");
            e.target.submit();
        }else{
            //Mostrar error
            let campoError = document.querySelector('#errorTxtNombreAgregar');
            campoError.innerHTML = resultadoCampo;

            let selectError = document.getElementById('errorSelectJerarquiaAgregar');
            selectError.innerHTML = resultadoSelect;
        }
    }

    function editar(e){
        e.preventDefault();
        //Obtengos los datos
        const campo = document.getElementById('txtNombreEditar');
        const select = document.getElementById('selectJerarquiaEditar');

        let resultadoCampo = validarLongitud(campo);
        let resultadoSelect = validarSelect(select);

        if(resultadoCampo === "" && resultadoSelect === ""){
            console.log("Enviando Info....");
            e.target.submit();
        }else{
            //Mostrar error
            let campoError = document.querySelector('#errorTxtNombreEditar');
            campoError.innerHTML = resultadoCampo;

            let selectError = document.getElementById('errorSelectJerarquia');
            selectError.innerHTML = resultadoSelect;
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
            const url = `getNivelDepartamental/${id}`;
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
                const txtNombre = document.getElementById('txtNombreEditar');
                txtNombre.value = datos.nombre;

                let jerarquia = datos.jerarquia;
                getJerarquias(jerarquia);

                formEditar.setAttribute('action', 'nivelesDepartamentales/' + datos.id)
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
            const url = `getNivelDepartamental/${id}`;
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
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar a la Organización <strong>${datos.nombre}</strong>?</h4>`;

                formEliminar.setAttribute('action', 'nivelesDepartamentales/' + datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getJerarquias(seleccionado = 0){
        let url = "getNivelesDepartamentales";
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
                //Si es pasado el option seleccionado
                if(seleccionado > 0){
                    cargarSelectFormEditar(datos, seleccionado);
                }else{
                    //si no lo pasa, es que voy a abrir el modal para crear uno nuevo
                    cargarSelectFormAgregar(datos);
                }

            })
            .catch(error => {
                console.log(error);
            });
   }

//Funciones de validacion
function validarLongitud(campo, max){
    let longitud = campo.value.length;

    let mensaje = "";
    if(longitud === 0){
        mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: Debe ingresar un valor.</strong></small>`;
    }else if(campo.value.trim() === ""){
        mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: No se permiten enviar espacios en blanco unicamente.</strong></small>`;
    }else if(longitud > max){
        mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: La longitud debe ser menor que ${max} caracteres.</strong></small>`;
    }

    return mensaje;
}

function validarSelect(select){
    let mensaje = "";
    if(select.options[select.selectedIndex].text === "Seleccionar"){
        mensaje = `<small id="mensaje" class="form-text text-danger"><strong>Error: debe seleccionar un valor para Jerarquia</strong></small>`;
    }

    return mensaje;
}

function cargarSelectFormAgregar(datos){
    //Busco y imprimo el template
    const select = document.getElementById('selectJerarquiaAgregar');
    select.innerHTML = mostrarJerarquiaDisponible(datos);
}

function cargarSelectFormEditar(datos, seleccionado){
    //Busco y imprimo el template
    const select = document.getElementById('selectJerarquiaEditar');
    select.innerHTML = mostrarJerarquiaDisponible(datos, seleccionado);
}

/*
    ESTE METODO DEVOLVERA LAS GERARQUIAS DISPONIBLES Y EL OPTION SELECCIONADO
    SI ES QUE SE PASA COMO PARAMETRO
*/
function mostrarJerarquiaDisponible(datos, seleccionado = null){
    datos.sort(); //Ordeno los datos traidos del backend
    let template = `<option>Seleccionar</option>\n`; //Inicio del template
    let valores = [1,2,3,4,5,6,7,8,9,10]; //Array con los valores definidos de entrada
    let resultado= []; //Array donde iran los valores ocupados y libres
    let aux = 1; //Variable auxiliar que tomara los valores disponibles en el segundo for

    //Recorro el arreglo para determinar las valores ocupados
    for (let i = 0; i < valores.length; i++) {
        //Guardo en un nuevo arreglo los valores ocupados y los disponibles quedan como undefined
        resultado[i] = datos.find(element => element == valores[i]);
    }

    //Recorro el arreglo con los valores ocupados y undefined
    for (let i = 0; i < resultado.length; i++) {
        //SI EXISTE EL VALOR
        if(resultado[i]){
            //SI EL VALOR SELECCIONADO ES IGUAL AL VALOR QUE SE ESTA RECORRIENDO
            if (seleccionado == resultado[i]) {
                //LO PONGO AL OPTION COMO SELECCIONADO
                template += `<option value="${resultado[i]}" class="disabled" selected>${resultado[i]}</option> \n`;
            }else{
                //Si existe un valor en una posición lo pongo como disabled
                template += `<option value="${resultado[i]}" class="disabled" disabled>${resultado[i]}</option> \n`;
            }
        }else{
            //Si no existe no lo pongo disabled, es decir esta disponible
            template += `<option value="${aux}">${aux}</option> \n`;
        }
        //Variable que tomara el valor de los campos disponibles que iteran
        aux++;
    }

    return template;

}

</script>

@endsection
