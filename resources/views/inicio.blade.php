@extends('template.plantilla')

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

<h1 class="text-center display-4">Final de Gestión de Capital Humano</h1>

@endsection

@section('script')


@endsection
