<li class="nav-item">
    <a href="{{route('organizaciones.index')}}" class="nav-link text-white">
        <i class="nav-icon fas fa-building"></i>
        <p>
          Organizaciones
        </p>
    </a>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link text-white">
        <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Gestión
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('personas.index', ['id' => $organizacion->id])}}" class="nav-link text-white">
            <i class="fas fa-users nav-icon"></i>
            <p>Personas</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('departamentos.index', ['id' => $organizacion->id])}}" class="nav-link text-white">
            <i class="nav-icon fas fa-sitemap"></i>
            <p>Departamentos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('puestosDeTrabajos.index', ['id' => $organizacion->id])}}" class="nav-link text-white">
            <i class="far fa-id-card nav-icon"></i>
            <p>Puestos de Trabajos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('funciones.index', ['id' => $organizacion->id])}}" class="nav-link text-white">
            <i class="fas fa-tasks nav-icon"></i>
            <p>Funciones</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('obligaciones.index', ['id' => $organizacion->id])}}" class="nav-link text-white">
            <i class="fas fa-thumbtack nav-icon"></i>
            <p>Obligaciones</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('asignaciones.index', ['id' => $organizacion->id])}}" class="nav-link text-white">
            <i class="fas fa-briefcase nav-icon"></i>
            <p>Asignar Personal</p>
        </a>
      </li>
    </ul>
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
