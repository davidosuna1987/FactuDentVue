@extends('layouts.app')

@section('title', '| Clínicas')

@section('content')

	<div class="columns">
		<div class="column">
			@if($clinics->count())
				<a href="{{route('clinics.create')}}" class="button is-primary is-pulled-right">Nueva clínica</a>
			@endif
			<div class="title">Listado de clínicas</div>
			<hr>
		</div>

	</div>

	<div class="card">
		<div class="card-content">
			@if($clinics->count())
				<table class="table is-narrow">
					<thead>
						<tr>
							<th>Clínica</th>
							<th>Facturas</th>
							<th class="has-text-right" colspan="4">Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach($clinics as $clinic)
							<tr>
								<td class="name">{{$clinic->name}}</td>
								<td class="invoices">{{$clinic->invoices()->count()}}</td>
								<td class="actions w-10">
									<a href="{{route('clinics.show', $clinic)}}" class="button is-small" title="Ver esta clínica">
										<span class="icon m-r-5"><i class="mdi mdi-eye"></i></span> Ver
									</a>
								</td>
								<td class="actions w-10">
									<a href="{{route('clinics.edit', $clinic)}}" class="button is-small is-info" title="Editar esta clínica">
										<span class="icon m-r-5"><i class="mdi mdi-pencil"></i></span> Editar
									</a>
								</td>
								<td class="actions w-10">
									<a href="{{route('clinics.invoices', $clinic)}}" class="button is-small is-link" title="Ver facturas de esta clínica">
										<span class="icon m-r-5"><i class="mdi mdi-currency-usd"></i></span> Facturas
									</a>
								</td>
								<td class="actions w-10">
									<form class="form form-delete-clinic" method="POST" action="{{route('clinics.deactivate', $clinic)}}" role="form">
										{{csrf_field()}}
		                {{method_field('PUT')}}
										<button type="submit" class="button is-small is-danger" title="Eliminar esta clínica">
											<span class="icon"><i class="mdi mdi-delete"></i></span>
										</button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p class="disabled">
					Aún no has añadido ninguna clínica a la lista.
					<a href="{{route('clinics.create')}}" class="button is-primary is-pulled-right">Añadir clínica</a>
				</p>
			@endif
		</div>
	</div>

	{{$clinics->render()}}

@endsection