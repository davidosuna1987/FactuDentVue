@extends('layouts.app')

@section('title')
	| Listado de facturas pendientes
@endsection

@section('content')

	<div class="columns">
		<div class="column">
			@if($invoices->count())
  			<a href="{{route('invoices.index')}}" class="button is-primary is-pulled-right is-rounded">Ver todas</a>
  		@endif
			<div class="title title-secondary has-text-white">Listado de facturas pendientes</div>
			{{-- <hr> --}}
		</div>
	</div>

	<div class="card">
		<div class="card-content">
			@if($invoices->count())
				{{-- @include('app.invoices.partials.table') --}}
				<div id="app">
					<invoices show-unpaid="1"></invoices>
				</div>
			@else
				<p class="disabled">
					No tienes facturas pendientes {{auth()->user()->name}}.
					<a href="{{route('app.index')}}" class="button is-primary is-pulled-right is-rounded">Volver</a>
				</p>
			@endif
		</div>
	</div>

@endsection