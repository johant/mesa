<ul class="sidebar-menu">
  <li class="header">Navegación</li>
  <!-- Optionally, you can add icons to the links -->
  <li {{ request()->is('/') ? 'class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
  <!-- <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li> -->
  <li class="treeview {{ request()->is('tickets/*') ? 'active' : '' }}">
    <a href="#"><i class="fa fa-link"></i> <span>Incidentes</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      {{-- <li {{ request()->is('tickets') ? 'class=active' : '' }}><a href="{{ route('tickets.list') }}"><i class="fa fa-eye"></i>Ver todos los Incidentes</a></li> --}}
      <li {{ request()->is('tickets/create') ? 'class=active' : '' }}><a href="{{ route('tickets.create')}}"><i class="fa fa-pencil"></i>Abrir un Incidente</a> </li>
      {{-- <li {{ request()->is('tickets/close') ? 'class=active' : '' }}><a href="{{ route('tickets.close')}}"><i class="fa fa-pencil"></i>Cerrar un Incidente</a> </li> --}}
    </ul>
  </li>
</ul>
