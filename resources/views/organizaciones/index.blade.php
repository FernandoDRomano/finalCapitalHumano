@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

<li class="nav-item">
    <a href="{{url('organizaciones')}}" class="nav-link text-white">
        <i class="nav-icon fas fa-building"></i>
        <p>
          Organizaciones
        </p>
    </a>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link text-white">
        <i class="fas fa-layer-group nav-icon"></i>
      <p>
        Niveles
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{url('nivelesDepartamentales')}}" class="nav-link text-white">
            <i class="fas fa-boxes nav-icon"></i>
          <p>Nivel de Departamentos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('nivelesPuestos')}}" class="nav-link text-white">
            <i class="fas fa-sort-amount-up-alt nav-icon"></i>
            <p>Nivel de Puestos</p>
        </a>
      </li>
    </ul>
</li>

@endsection

@section('contenido')


<div class="card">
    <div class="card-header blue-marino d-flex justify-content-between align-items-center">
    <h3 class="card-title flex-grow-1"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Gestión de Organizaciones ({{$organizaciones->count()}})</span> </strong> </h3>
        <a type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar"
        data-tooltip="tooltip" data-placement="top" title="Agregar una Nueva Organización">
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
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tabla" class="bg-white">
        @foreach ($organizaciones as $organizacion)
            <tr>
                <td>{{$organizacion->id}}</td>
                <td>{{$organizacion->nombre}}</td>
                <td>
                    <a name="btnEditar" class="btn btn-warning text-white editar" href="#" role="button"  data-toggle="modal" data-target="#modalEditar"
                    data-id="{{$organizacion->id}}" data-tooltip="tooltip" data-placement="top" title="Editar la Organización"><i class="fas fa-edit" data-id="{{$organizacion->id}}"></i></a>
                    <a name="btnEliminar" class="btn btn-danger text-white eliminar" href="#" role="button" data-toggle="modal" data-target="#modalEliminar"
                    data-id="{{$organizacion->id}}" data-tooltip="tooltip" data-placement="top" title="Eliminar la Organización"><i class="fas fa-trash-alt" data-id="{{$organizacion->id}}"></i></a>
                    <a name="btnVer" class="btn btn-success text-white" href="{{action('OrganizacionController@show', $organizacion->id)}}"
                    role="button" data-tooltip="tooltip" data-placement="top" title="Detalles de la Organización"><i class="fas fa-info-circle"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
      </table>

      {{ $organizaciones->links() }}

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
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Nuevo Elemento</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregar" action="{{ action('OrganizacionController@store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input class="form-control" id="txtNombreAgregar" name="nombre" type="text" placeholder="Ingresar el nombre de la Organización">
                                <div id="errorTxtNombreAgregar"></div>
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
                <h5 class="modal-title w-100 text-white text-center" id="exampleModalLabel">Editar Elemento</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditar" method="POST">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="idOrganizacion" id="idOrganizacion" data-id="">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="txtNombreEditar" name="nombre" type="text" placeholder="Ingresar el nombre de la Organización">
                            <div id="errorTxtNombreEditar"></div>
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
                    <div id="contenidoModalEliminar" class="card-body mb-0 pb-0"></div>
                    <div id="contenidoModalEliminar2" class="card-body"></div>
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
        Activando los tooltips
    */

    $(function () {
        $('[data-tooltip="tooltip"]').tooltip()
    })

    //Variables
    const token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    const formAgregar = document.getElementById('formAgregar');
    const formEditar = document.getElementById('formEditar');
    const formEliminar = document.getElementById('formEliminar');
    const tabla = document.getElementById('tabla');
    const modalEditar = document.getElementById('modalEditar');
    const modalEliminar = document.getElementById('modalEliminar');

    //EventsListeners
    cargarEventsListeners();

    function cargarEventsListeners(){
        tabla.addEventListener('click', getDatosForUpdate);
        tabla.addEventListener('click', getDatosForDelete);
        formAgregar.addEventListener('submit', agregar);
        formEditar.addEventListener('submit', editar);
    }

    //Funciones
    function agregar(e){
        e.preventDefault();
        //Obtengos los datos
        const campo = document.getElementById('txtNombreAgregar');
        let resultado = validar(campo);

        if(resultado === ""){
            console.log("Enviando Info....");
            e.target.submit();
        }else{
            //Mostrar error
            let padre = document.querySelector('#errorTxtNombreAgregar');
            console.log(padre);
            console.log(resultado);
            padre.innerHTML = resultado;
        }
    }

    function editar(e){
        e.preventDefault();
        //Obtengos los datos
        const campo = document.getElementById('txtNombreEditar');
        let resultado = validar(campo);

        if(resultado === ""){
            console.log("Enviando Info....");
            e.target.submit();
        }else{
            //Mostrar error
            let padre = document.querySelector('#errorTxtNombreEditar');
            console.log(resultado);
            padre.innerHTML = resultado;
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
            const url = `getOrganizacion/${id}`;
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
                formEditar.setAttribute('action', 'organizaciones/' + datos.id)
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
            const url = `getOrganizacion/${id}`;
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
                getDatosDependientes(id);
                //Cargo en el modal los datos
                const titulo = document.getElementById('tituloModalEliminar');
                titulo.innerHTML = `<strong>Eliminar ${datos.nombre}</strong>`;

                const contenido = document.getElementById('contenidoModalEliminar');
                contenido.innerHTML = `<h4 class="text-center">¿Estas seguro de Eliminar a la Organización <strong>${datos.nombre}</strong>?</h4>`;

                formEliminar.setAttribute('action', 'organizaciones/' + datos.id);
            })
            .catch(error => {
                console.log(error);
            });

        }
   }

   function getDatosDependientes(id){
        //PRIMERO VERIFICO QUE SE HAGA CLICK EN EL BOTON DE EDITAR
        //CONSTRUYO LA URL
            const url = `getDatosDependientes/${id}`;
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
                //LLenar contenido
                const contenido = document.getElementById('contenidoModalEliminar2');
                let template = '';

                if(datos.departamentos.length > 0 || datos.personas.length > 0 || datos.puestosDeTrabajos.length > 0){

                    template += `
                    <h4 class="text-danger">Si la elimina, todas las demas entidades seran eliminadas.</h4>
                    <div id="accordion">
                    `;

                        if(datos.departamentos.length > 0){
                            template += `
                            <div class="card">
                                <div class="card-header bg-danger" id="headingOne">
                                    <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseOne"  aria-controls="collapseOne" aria-expanded="false">
                                        Departamentos <span class="badge badge-pill badge-light">${datos.departamentos.length}</span>
                                    </h6>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                            `;

                            for (let i = 0; i < datos.departamentos.length; i++) {
                                template += `
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-danger">${datos.departamentos[i].nombre}</li>
                                </ul>
                                `;
                            }

                            template += `
                                    </div>
                                </div>
                            </div>
                            `;

                        }

                        if(datos.personas.length > 0){
                            template += `
                            <div class="card">
                                <div class="card-header bg-danger" id="headingTwo">
                                    <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Personas <span class="badge badge-pill badge-light">${datos.personas.length}</span>
                                    </h6>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                            `;

                            for (let i = 0; i < datos.personas.length; i++) {
                                template += `
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-danger">${datos.personas[i].nombre}</li>
                                    </ul>
                                    `;
                            }

                            template += `
                                    </div>
                                </div>
                            </div>
                            `;
                        }

                        if(datos.puestosDeTrabajos.length > 0){
                            template += `
                            <div class="card">
                                <div class="card-header bg-danger" id="headingThree">
                                    <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Puestos de Trabajos <span class="badge badge-pill badge-light">${datos.puestosDeTrabajos.length}</span>
                                    </h6>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                            `;

                            for (let i = 0; i < datos.puestosDeTrabajos.length; i++) {
                                template += `
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-danger">${datos.puestosDeTrabajos[i].nombre}</li>
                                    </ul>
                                    `;
                            }

                            template += `
                                    </div>
                                </div>
                            </div>
                            `;
                        }

                    template += `
                    </div>
                    `;

                }

                contenido.innerHTML = template;


            })
            .catch(error => {
                console.log(error);
            });


   }

//Funciones de validacion
function validar(campo){
    return resultado = validarLongitud(campo, 45);
}

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

</script>

@endsection
