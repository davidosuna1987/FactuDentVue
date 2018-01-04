@extends('layouts.app')

@section('title')
	| Listado de facturas
@endsection

@section('content')

	<div class="columns">
		<div class="column">
			@if(auth()->user()->invoices()->count())
				<a href="{{route('invoices.create')}}" class="button is-primary is-pulled-right">Crear factura</a>
			@endif
			<div class="title">Listado de facturas</div>
			<hr>
		</div>
	</div>

	<div class="card">
		<div class="card-content">
			@if(auth()->user()->invoices()->count())
					<table class="table is-narrow">
						<thead>
							<tr>
								<th>Nº Factura</th>
								<th>Fecha</th>
								<th>Total</th>
								<th>Pago</th>
								<th colspan="4">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach(auth()->user()->invoices()->orderBy('invoice_no', 'desc')->get() as $index => $invoice)
								<tr>
									<td class="name">{{sprintf('%06d', $invoice->invoice_no)}}</td>
									<td class="invoices">{{($invoice->invoice_date) ? date("j F Y", strtotime($invoice->invoice_date)) : ''}}</td>
									<td class="invoices">{{str_replace(',00', '',number_format($invoice->total, 2, ',', '.'))}}€</td>
									<td class="invoices">{!!($invoice->payment_date) ? Carbon\Carbon::parse(gmdate("Y-m-d\TH:i:s", strtotime($invoice->payment_date)))->diffForHumans() : '<span class="has-text-danger">Pendiente</span>'!!}</td>
									<td class="actions w-10">
										<a href="{{route('invoices.show', $invoice->invoice_no)}}" class="button is-small" title="Ver esta factura">
											<span class="icon m-r-5"><i class="mdi mdi-eye"></i></span> Ver
										</a>
									</td>
									<td class="actions w-10">
										<a href="{{route('invoices.edit', $invoice->invoice_no)}}" class="button is-small is-info" title="Editar esta factura">
											<span class="icon m-r-5"><i class="mdi mdi-pencil"></i></span> Editar
										</a>
									</td>
									 <td class="actions w-10">
										<a href="{{route('invoices.pdf.show', $invoice->invoice_no)}}" class="button is-small is-link" title="Ver factura en PDF">
											<span class="icon m-r-5"><i class="fa fa-file-pdf-o"></i></span> PDF
										</a>
									</td>
									<td class="actions w-10">
										<form class="form form-delete-invoice" method="POST" action="{{route('invoices.delete', $invoice)}}" role="form">
											{{csrf_field()}}
			                {{method_field('DELETE')}}
											<button type="submit" class="button is-small is-danger" title="Eliminar esta factura">
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
					Aún no has hecho ninguna factura {{auth()->user()->name}}.
					<a href="{{route('invoices.create')}}" class="button is-primary is-pulled-right">Crear factura</a>
				</p>
			@endif
		</div>
	</div>

@endsection