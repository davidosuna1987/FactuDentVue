@extends('layouts.app')

@section('title', '| Perfil de '.$user->fullName())

@section('content')

	<div class="columns">
		<div class="column">
			<a href="{{auth()->user()->isAdmin() ? route('admin.index') : route('app.index')}}" class="button is-pulled-right is-rounded">Volver</a>
			<div class="title title-secondary has-text-white">Editar perfil</div>
			{{-- <hr> --}}
		</div>
	</div>

	<div class="card">
		<div class="card-content">
			<div class="columns">
				<div class="column">

					@if(!$user->canCreateInvoices())
						<p class="label has-text-danger is-small">
							<strong class="has-text-danger">Atención: </strong>
							Todos los campos marcados con * deben estar completos para poder emitir facturas.
						</p>
					@endif

					@if($errors->any())
						<p class="label has-text-danger is-small">Recuerda que todos los campos marcados con * son obligatorios.</p>
					@endif

					@include('app.user.partials._form')

				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
	@include('partials.scripts.autocomplete')
@endpush