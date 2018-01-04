<nav class="navbar is-transparent has-shadow is-fixed-top">
  <div class="container">
    <div class="navbar-brand">
      <a class="navbar-item is-tab" href="{{ route('home') }}">
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
        <a class="navbar-item is-tab" href="#">Home</a>
        <a class="navbar-item is-tab" href="#">Test</a>
      </div>

      <div class="navbar-end">
        @if(Auth::guest())
            <a href="{{ route('login') }}" class="navbar-item is-tab">Login</a>
            <a href="{{ route('register') }}" class="navbar-item is-tab">Registro</a>
        @else
            <div class="navbar-item has-dropdown is-hoverable">
              <span class="navbar-link">¡Hola {{Auth::user()->name}}!</span>
              <div class="navbar-dropdown is-right">
                <a class="navbar-item" href="#">
                  <span class="icon is-primary is-small m-r-10"><i class="fa fa-fw fa-user-o"></i></span>
                  Perfil
                </a>
                <a class="navbar-item" href="#">
                  <span class="icon is-primary is-small m-r-10"><i class="fa fa-fw fa-bell-o"></i></span>
                  Notificaciones
                </a>
                <a class="navbar-item" href="#">
                  <span class="icon is-primary is-small m-r-10"><i class="fa fa-fw fa-sliders"></i></span>
                  Ajustes
                </a>
                <hr class="navbar-divider">
                <a class="navbar-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <span class="icon is-primary is-small m-r-10"><i class="fa fa-fw fa-sign-out"></i></span>
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