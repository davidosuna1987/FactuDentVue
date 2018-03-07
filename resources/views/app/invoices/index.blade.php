@extends('layouts.app')

@section('title')
	| Listado de facturas
@endsection

@section('content')

	<div class="columns">
		<div class="column">
			@if($invoices->count())
				<a href="{{route('invoices.create')}}" class="button is-primary is-pulled-right is-rounded">Crear factura</a>
			@endif
			<div class="title title-secondary has-text-white">Listado de facturas</div>
			{{-- <hr> --}}
		</div>
	</div>

	<div class="card">
		<div class="card-content">
			@if($invoices->count())
				{{-- @include('app.invoices.partials.table') --}}
				<div id="app">
					<invoices show-unpaid="0"></invoices>
				</div>
			@else
				<p class="disabled">
					Aún no has hecho ninguna factura {{auth()->user()->name}}.
					<a href="{{route('invoices.create')}}" class="button is-primary is-pulled-right is-rounded">Crear factura</a>
				</p>
			@endif
		</div>
	</div>

@endsection