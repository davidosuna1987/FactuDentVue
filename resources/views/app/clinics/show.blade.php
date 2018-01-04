@extends('layouts.app')

@section('title')
| {{$clinic->name}}
@endsection

@section('content')

	<div class="columns">
		<div class="column">
			<a href="{{route('clinics.edit', $clinic)}}" class="button is-primary is-pulled-right">Editar clínica</a>
			<a href="{{route('clinics.invoices.create', $clinic)}}" class="button is-link m-r-10 is-pulled-right">Crear factura</a>
  		<a href="{{route('clinics.index')}}" class="button m-r-10 is-pulled-right">Volver</a>
			<div class="title">{{$clinic->name}}</div>
			<hr>
		</div>
	</div>

	<div class="columns">
		<div class="column">
			<h3 class="has-text-primary">Dirección</h3>

			<div class="columns">
		    <div class="column p-b-0">
		    	<div class="field">
		    	    {{-- <label class="label is-small">Dirección</label> --}}
		    	    <p class="control">{{$clinic->address}}, {{$clinic->post_code}} {{$clinic->locality}} ({{$clinic->province}}), {{$clinic->country}}</p>
		    	</div>
		    </div>
	    </div>

	    <h3 class="has-text-primary">Datos fiscales</h3>

	    <div class="columns is-multiline">
	    	<div class="column is-one-third p-b-0">
	    		<div class="field">
	    		    <label class="label is-small">Nombre de la clínica</label>
	    		    <p class="control">{{$clinic->name}}</p>
	    		</div>
	    	</div>

	    	<div class="column is-one-third p-b-0">
	    		<div class="field">
	    		    <label class="label is-small">Persona de contacto</label>
	    		    <p class="control">{{$clinic->contact}}</p>
	    		</div>
	    	</div>

	    	<div class="column is-one-third p-b-0">
	    		<div class="field">
	    		    <label class="label is-small">E-mail</label>
	    		    <p class="control">{{$clinic->email}}</p>
	    		</div>
	    	</div>

	    	<div class="column is-one-third p-b-0">
	    		<div class="field">
	    		    <label class="label is-small">NIF</label>
	    		    <p class="control">{{$clinic->nif}}</p>
	    		</div>
	    	</div>

	    	<div class="column is-one-third p-b-0">
	    		<div class="field">
	    		    <label class="label is-small">Teléfono</label>
	    		    <p class="control">{{$clinic->phone}}</p>
	    		</div>
	    	</div>

	    	<div class="column is-one-third p-b-0">
	    		<div class="field">
	    		    <label class="label is-small">Fax</label>
	    		    <p class="control">{{$clinic->fax}}</p>
	    		</div>
	    	</div>

	    	<div class="column p-b-0 m-t-30">
	    		<div class="field">
	    		    <label class="label is-small has-text-primary">Mi porcentaje de beneficio en esta clínica</label>
	    		    <p class="control">{{$clinic->percentage}}%</p>
	    		</div>
	    	</div>
	    </div>

		</div>
	</div>

@endsection