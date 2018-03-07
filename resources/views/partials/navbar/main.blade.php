<nav class="navbar is-transparent has-shadow is-fixed-top">
  <div class="container">
    <div class="navbar-brand">
      <a class="navbar-item is-tab" href="{{ route('web') }}">
        <img src="{{ asset('images/factudent-logo.png') }}" alt="FactuDent Logo" width="112" height="28">
      </a>
      <div class="navbar-burger burger" data-target="top-navbar-menu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>

    <div id="top-navbar-menu" class="navbar-menu">
      <div class="navbar-start">
        @if(auth()->user())
          <a class="navbar-item is-tab" href="{{auth()->user()->isAdmin() ? route('admin.index') : route('app.index')}}">Panel</a>

          @if(auth()->user()->isAdmin())
            <div class="navbar-item has-dropdown is-hoverable">
              <span class="navbar-link">Usuarios</span>
              <div class="navbar-dropdown">
                <a class="navbar-item" href="{{route('admin.index')}}">Todos los usuarios</a>
                <a class="navbar-item" href="{{route('admin.index')}}">Usuarios activos</a>
                <a class="navbar-item" href="{{route('admin.index')}}">Usuarios inactivos</a>
                <hr class="navbar-divider">
                <a class="navbar-item" href="{{route('admin.index')}}">Nuevo usuario</a>
              </div>
            </div>
          @endif

          <div class="navbar-item has-dropdown is-hoverable">
            <span class="navbar-link">Clínicas</span>
            <div class="navbar-dropdown">
              <a class="navbar-item" href="{{route('clinics.index')}}">Todas las clínicas</a>
              <hr class="navbar-divider">
              <a class="navbar-item" href="{{route('clinics.create')}}">Nueva clínica</a>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <span class="navbar-link">Facturas</span>
            <div class="navbar-dropdown">
              <a class="navbar-item" href="{{route('invoices.index')}}">Todas las facturas</a>
              <a class="navbar-item" href="{{route('invoices.pending')}}">Facturas pendientes</a>
              <hr class="navbar-divider">
              <a class="navbar-item" href="{{route('invoices.create')}}">Nueva factura</a>
            </div>
          </div>
        @endif
      </div>

      <div class="navbar-end">
        @guest
            <a href="{{ route('login') }}" class="navbar-item is-tab">Login</a>
            <a href="{{ route('register') }}" class="navbar-item is-tab">Registro</a>
        @else
            <div class="navbar-item has-dropdown is-hoverable">
              <span class="navbar-link">¡Hola {{auth()->user()->name}}!</span>
              <div class="navbar-dropdown is-right">
                {{-- <a class="navbar-item" href="{{route('app.index')}}">
                  <span class="icon is-primary is-small m-r-10"><i class="mdi mdi-view-dashboard"></i></span>
                  Panel
                </a> --}}
                <a class="navbar-item" href="{{route('profile')}}">
                  <span class="icon has-text-primary is-small m-r-10"><i class="fa fa-fw fa-user-o"></i></span>
                  Perfil
                </a>
                <a class="navbar-item" href="#">
                  <span class="icon has-text-primary is-small m-r-10"><i class="fa fa-fw fa-bell-o"></i></span>
                  Notificaciones
                </a>
                <a class="navbar-item" href="{{route('settings')}}">
                  <span class="icon has-text-primary is-small m-r-10"><i class="fa fa-fw fa-sliders"></i></span>
                  Ajustes
                </a>
                <hr class="navbar-divider">
                <a class="navbar-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <span class="icon has-text-primary is-small m-r-10"><i class="fa fa-fw fa-sign-out"></i></span>
                  Salir
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
              </div>
            </div>
        @endif
      </div>
    </div>
  </div>
</nav>
