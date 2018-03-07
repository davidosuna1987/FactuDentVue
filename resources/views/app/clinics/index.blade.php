@extends('layouts.app')

@section('title', '| Clínicas')

@section('content')

	<div class="columns">
		<div class="column">
			@if($clinics->count())
				<a href="{{route('clinics.create')}}" class="button is-primary is-pulled-right is-rounded">Nueva clínica</a>
			@endif
			<div class="title title-secondary has-text-white">Listado de clínicas</div>
			{{-- <hr> --}}
		</div>

	</div>

	<div class="card">
		<div class="card-content">
			@if($clinics->count())
				{{-- @include('app.clinics.partials.table') --}}
				<div id="app">
					<clinics></clinics>
				</div>
			@else
				<p class="disabled">
					Aún no has añadido ninguna clínica a la lista.
					<a href="{{route('clinics.create')}}" class="button is-primary is-pulled-right is-rounded">Añadir clínica</a>
				</p>
			@endif
		</div>
	</div>

	{{-- {{$clinics->render()}} --}}

@endsection
