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

@endsection

@section('contenido')

<h1 class="text-center display-4">Final de Gestión de Capital Humano</h1>

@endsection

@section('script')


@endsection
