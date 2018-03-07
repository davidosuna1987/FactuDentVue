@extends('layouts.app')

@section('title')
	| Factura {{$invoice->invoice_no}}
@endsection

@section('content')

	<div id="invoice">

		<div class="columns">
			<div class="column">
				<a href="{{route('invoices.edit', $invoice->invoice_no)}}" class="button is-primary is-pulled-right is-rounded">Editar factura</a>
				<a href="{{route('invoices.pdf.show', $invoice->invoice_no)}}" class="show-pdf-button button is-link m-r-10 is-pulled-right is-rounded">PDF</a>
  			<a href="{{route('invoices.index')}}" class="button m-r-10 is-pulled-right is-rounded">Volver</a>
				<div class="title title-secondary has-text-white">
					Factura {{$invoice->invoice_no}}
					@if($invoice->payment_date)
						<span class="tag is-success m-l-10 text-primary is-rounded">Pagada {{\Carbon::parse(gmdate("Y-m-d\TH:i:s", strtotime($invoice->payment_date)))->diffForHumans()}}</span>
					@else
						<span class="tag is-danger m-l-10 text-primary is-rounded">Pendiente</span>
					@endif
				</div>
				{{-- <hr> --}}
			</div>
		</div>

		<div class="card">
			<div class="card-content">
				<div class="invoice-info">
					<h3 class="has-text-primary">Datos fiscales</h3>

					<div class="columns">
						<div class="column">
							<table class="table has-no-borders is-narrow has-text-small has-no-padding">
								<tbody>
									{{-- <tr>
										<th>Nº factura</th>
										<td class="invoice-no-fake" data-invoiceno="{{$invoice->invoice_no}}">{{$invoice->invoice_no}}</td>
									</tr> --}}
									<tr>
										<th>Fecha</th>
										<td class="invoice-date-fake has-no-borders">{{\Carbon::parse($invoice->invoice_date)->format('d-m-Y')}}</td>
									</tr>
									@include('app.invoices.partials.userdata-rows')
								</tbody>
							</table>
						</div>

						<div class="column">
							<table class="table has-no-borders is-narrow has-text-small has-no-padding">
								<tbody>
									<tr>
										<th>Cliente</th>
										<td>{{$invoice->clinic()->contact}}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>{{$invoice->clinic()->email}}</td>
									</tr>
									<tr>
										<th>NIF / CIF</th>
										<td>{{$invoice->clinic()->nif}}</td>
									</tr>
									<tr>
										<th>Dirección</th>
										<td>{{$invoice->clinic()->address}}</td>
									</tr>
									<tr>
										<th></th>
										<td>{{$invoice->clinic()->post_code}} {{$invoice->clinic()->locality}} ({{$invoice->clinic()->province}})</td>
									</tr>
									<tr>
										<th>Teléfono / Fax</th>
										<td>{{$invoice->clinic()->phone}} {{($invoice->clinic()->fax) ? ' / '.$invoice->clinic()->fax : ''}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="columns">
						<div class="column">

							<h3 class="has-text-primary">Detalles de la factura</h3>
							<table class="invoice-details-table table is-bordered is-narrow has-text-small">
								<thead>
									<tr>
										<th>Concepto</th>
										<th class="w-100">Cantidad</th>
										<th class="w-150">Precio</th>
										<th class="w-150">Total</th>
									</tr>
								</thead>
								<tbody>
									@foreach($invoice->invoiceLines()->get() as $index => $invoiceLine)
										<tr class="invoice-line" data-id="{{$index}}">
											<td class="has-input-field">
												{{$invoiceLine->description}}
											</td>
											<td class="has-input-field w-100">
												{{$invoiceLine->quantity}}
											</td>
											<td class="has-input-field w-150">
												{{str_replace(',00', '', number_format($invoiceLine->unit_price, 2, ',', '.'))}}€
											</td>
											<td class="has-text-right w-150">
												{{str_replace(',00', '', number_format($invoiceLine->total, 2, ',', '.'))}}€
											</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td class="is-empty" colspan="2"></td>
										<th>Subtotal</th>
										<td class="invoice-subtotal has-text-right">{{str_replace(',00', '', number_format($invoice->sub_total, 2, ',', '.'))}}€</td>
									</tr>
									<tr class="invoice-dentist-percentage-row">
										<td class="is-empty" colspan="2"></td>
										<th class="invoice-dentist-percentage-label">
											<span>Porcentaje odontólogo {{$invoice->dentist_percentage}}%</span>
										</th>
										<td class="invoice-dentist-percentage-total has-text-right">
											<span>{{str_replace(',00', '', number_format(ceil($invoice->sub_total * $invoice->dentist_percentage) / 100, 2, ',', '.'))}}€</span>
										</td>
									</tr>
									<tr>
										<td class="is-empty" colspan="2"></td>
										<th>Retención {{$invoice->retention}}%</th>
										<td class="invoice-retention-total has-text-right">{{str_replace(',00', '', number_format(floor($invoice->sub_total * $invoice->dentist_percentage) / 100 - $invoice->total, 2, ',', '.'))}}€</td>
									</tr>
									<tr>
										<td class="is-empty" colspan="2"></td>
										<th>Total</th>
										<td class="invoice-total has-text-right">{{str_replace(',00', '', number_format($invoice->total, 2, ',', '.'))}}€</td>
									</tr>
								</tfoot>
							</table>

							@if($invoice->ovserbations)
								<h3 class="has-text-primary">Ovserbaciones</h3>
								<p class="m-b-30">{{$invoice->ovserbations}}</p>
							@endif

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection