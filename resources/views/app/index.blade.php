@extends('layouts.app')

@section('content')
	<div class="columns">
		<div class="column">
			<h1 class="has-text-white">Hola {{auth()->user()->name}}, este es tu panel de administración.</h1>
			<h3 class="has-text-white">De momento podemos hacer un par de cosas:</h3>
		</div>
	</div>

	<div class="columns is-multiline">
		{{-- @if(auth()->user()->isAdmin())
			<div class="column is-one-quarter badge is-badge-large" data-badge="{{$users->count()}}">
				<a href="{{route('admin.index')}}" class="card app-index-action"><span>Ver todos los usuarios</span></a>
			</div>
		@endif --}}
		<div class="column is-one-quarter badge is-badge-large" data-badge="{{auth()->user()->clinics()->count() ? auth()->user()->clinics()->count() : 0}}">
			<a href="{{route('clinics.index')}}" class="card app-index-action"><span>Ver mis clínicas activas</span></a>
		</div>
		<div class="column is-one-quarter badge is-badge-large" data-badge="{{auth()->user()->invoices()->count() ? auth()->user()->invoices()->count() : 0}}">
			<a href="{{route('invoices.index')}}" class="card app-index-action"><span>Ver todas mis facturas</span></a>
		</div>
		<div class="column is-one-quarter badge is-badge-large {{auth()->user()->pendingInvoices()->count() ? 'is-badge-danger' : ''}}" data-badge="{{auth()->user()->pendingInvoices()->count() ? auth()->user()->pendingInvoices()->count() : 0}}">
			<a href="{{route('invoices.pending')}}" class="card app-index-action"><span>Ver facturas pendientes</span></a>
		</div>
	</div>
@endsection
