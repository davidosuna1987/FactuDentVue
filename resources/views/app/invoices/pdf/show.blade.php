@extends('layouts.pdf')

@section('title', '| Factura '.$invoice->invoice_no.' PDF')

@section('content')

	<div id="invoice">

		<div class="columns">
			<div class="column">
				<div class="title">Factura {{$invoice->invoice_no}}</div>
				<hr>
			</div>
		</div>

		<div class="invoice-info">

			<h3 style="color:{{auth()->user()->pdf_color}}">Datos fiscales</h3>

			<div class="columns">
				<table class="table fiscal-data-table has-no-borders" width="100%">
					<tr>
						<td width="50%">
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
						</td>

						<td width="50%">
							<table class="table has-no-borders is-narrow has-text-small has-no-padding">
								<tbody>
									<tr>
										<th>Cliente</th>
										<td>{{$invoice->clinic()->name}}</td>
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
									@if($invoice->clinic()->phone or $invoice->clinic()->fax)
										<tr>
											<th>Tel / Fax</th>
											@if($invoice->clinic()->phone and $invoice->clinic()->fax)
												<td>{{$invoice->clinic()->phone}}  / {{$invoice->clinic()->fax}}</td>
											@elseif($invoice->clinic()->phone)
												<td>{{$invoice->clinic()->phone}}</td>
											@else
												<td>{{$invoice->clinic()->phone}}</td>
											@endif
										</tr>
									@endif
								</tbody>
							</table>
						</td>
					</tr>
				</table>
			</div>

			<div class="columns">
				<div class="column">
					<h3 style="color:{{auth()->user()->pdf_color}}">Detalles de la factura</h3>
					@include('app.invoices.pdf._table')

					@if($invoice->ovserbations)
						<h3 style="color:{{auth()->user()->pdf_color}}">Ovserbaciones</h3>
						<p style="color:gray; font-size: 11px;" class="m-b-30">{{$invoice->ovserbations}}</p>
					@endif
				</div>
			</div>
		</div>
	</div>

@endsection

@push('styles')
	<style>
		*{
			font-size: 14px;
			font-family: BlinkMacSystemFont, -apple-system, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
		}

		table td,
		table th{
			font-size: .9em;
			color: #363636;
		}

		#app.pdf{
			padding: 70px 15px 30px;

		}

		.pdf-logo{
			position: fixed;
			top: -20px;
			right: 15px;
		}

		hr {
	    background-color: #dbdbdb;
	    border: none;
	    display: block;
	    height: 1px;
	    margin: 1.5rem 0;
		}

		.title {
	    color: #363636;
	    font-size: 2rem;
	    font-weight: 600;
	    line-height: 1.125;
		}

		h3{
			font-weight: 400;
    	line-height: 1.125;
    	font-size: 1.5em;
    	margin-top: 1.3333em;
    	margin-bottom: 0.6666em;
		}

		.has-text-right{
			text-align: right;
		}

		.fiscal-data-table{
			margin-bottom: 50px;
		}

		.fiscal-data-table th{
			width: 100px;
		}

		.invoice-details-table{
			width: 100%;
			border-collapse: collapse;
		}

		.invoice-details-table td,
		.invoice-details-table thead th{
			border: solid 1px #dbdbdb;
		}

		.invoice-details-table td,
		.invoice-details-table th{
			padding: 5px 12px;
		}

		.is-empty{
			border: none !important;
		}

		.factudent-advertising{
			font-size: 0.65rem;
			color: #464646;
			position: fixed;
			bottom: 0;
		}
	</style>
@endpush