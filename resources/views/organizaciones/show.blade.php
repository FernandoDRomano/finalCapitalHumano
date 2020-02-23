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

    <h1>Organización: {{$organizacion->nombre}}</h1>

    <div id="chart-container"></div>

@endsection

@section('script')

<script>

(function($) {
  $(function() {
   var ds = {
     'name': 'Fernando',
     'title': 'Presidente',
     'children': [
       { 'name': 'Bo Miao', 'title': 'department manager' ,
       'children': [
           { 'name': 'Tie Hua', 'title': 'senior engineer' },
           { 'name': 'Hei Hei', 'title': 'senior engineer',
             'children': [
               { 'name': 'Pang Pang', 'title': 'engineer' },
               { 'name': 'Xiang Xiang', 'title': 'UE engineer' }
             ]
            }
          ]
       },
       { 'name': 'Su Miao', 'title': 'department manager',
         'children': [
           { 'name': 'Tie Hua', 'title': 'senior engineer' },
           { 'name': 'Hei Hei', 'title': 'senior engineer',
             'children': [
               { 'name': 'Pang Pang', 'title': 'engineer' },
               { 'name': 'Xiang Xiang', 'title': 'UE engineer',
               'children': [
                    { 'name': 'Pang Pang', 'title': 'engineer' },
                    { 'name': 'Xiang Xiang', 'title': 'UE engineer' }
                    ]
               }
             ]
            }
          ]
        },
        { 'name': 'Hong Miao', 'title': 'department manager' },
        { 'name': 'Chun Miao', 'title': 'department manager' }
      ]
    };

    var oc = $('#chart-container').orgchart({
      'data' : ds,
      'nodeContent': 'title'
    });

  });
})(jQuery);




</script>

@endsection
