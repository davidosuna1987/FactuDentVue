<div class="side-menu hero is-dark">
	<div class="side-menu-icons">
		<span class="icon icon-backburger">
		  <i class="mdi mdi-backburger"></i>
		</span>
		<span class="icon icon-menu">
		  <i class="mdi mdi-menu"></i>
		</span>
	</div>
	<aside class="menu m-t-30">
		<p class="menu-label">General</p>
		<ul class="menu-list">
			<li><a  href="{{auth()->user()->isAdmin() ? route('admin.index') : route('app.index')}}">Panel</a></li>
		</ul>
		<p class="menu-label">Administración</p>
		<ul class="menu-list">
			@if(auth()->user()->isAdmin())
				<li class="has-dropdown">
				<a class="dropdown-label" href="#">Usuarios</a>
				<div class="dropdown">
					<ul>
						<li><a href="{{route('admin.index')}}">Todos los usuarios</a></li>
						<li><a href="{{route('admin.index')}}">Usuarios activos</a></li>
						<li><a href="{{route('admin.index')}}">Usuarios inactivos</a></li>
						<li><a href="{{route('admin.index')}}">Nuevo usuario</a></li>
					</ul>
				</div>
			</li>
			@endif
			<li class="has-dropdown">
				<a class="dropdown-label" href="#">Clínicas</a>
				<div class="dropdown">
					<ul>
						<li><a href="{{route('clinics.index')}}">Todas las clínicas</a></li>
						<li><a href="{{route('clinics.create')}}">Nueva clínica</a></li>
					</ul>
				</div>
			</li>
			<li class="has-dropdown">
				<a class="dropdown-label" href="#">Facturas</a>
				<div class="dropdown">
					<ul>
						<li><a href="{{route('invoices.index')}}">Todas mis facturas</a></li>
						<li><a href="{{route('invoices.pending')}}">Facturas pendientes</a></li>
						<li><a href="{{route('invoices.create')}}">Nueva factura</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</aside>
</div>
