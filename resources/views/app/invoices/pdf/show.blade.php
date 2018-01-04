@extends('layouts.pdf')

@section('title')
	PDF | Factura {{$invoice->invoice_no}}
@endsection

@section('content')

	<div id="invoice">

		<div class="columns">
			<div class="column">
				<div class="title">Factura {{$invoice->invoice_no}}</div>
				<hr>
			</div>
		</div>

		<div class="invoice-info">

			<div class="columns">
				<table class="table has-no-borders">
					<tr>
						<td colspan="2"><h3 class="has-text-primary">Datos fiscales</h3></td>
					</tr>
					<tr>
						<td width="50%">
							<table class="table has-no-borders is-narrow has-text-small has-no-padding">
								<tbody>
									<tr>
										<th>Nº factura</th>
										<td class="invoice-no-fake" data-invoiceno="{{$invoice->invoice_no}}">{{sprintf('%06d', $invoice->invoice_no)}}</td>
									</tr>
									<tr>
										<th>Fecha</th>
										<td class="invoice-date-fake has-no-borders">{{\Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y')}}</td>
									</tr>
									<tr>
										<th>Nombre</th>
										<td>{{Auth::user()->name}}</td>
									</tr>
									{{-- TODO: cambiar datos fijos por user_settings --}}
									<tr>
										<th>Domicilio</th>
										<td>C/ Bélgica 14, puerta 5</td>
									</tr>
									<tr>
										<th></th>
										<td>46021 Valencia (Valencia)</td>
									</tr>
									<tr>
										<th>CIF / NIF</th>
										<td>44646557-S</td>
									</tr>
								</tbody>
							</table>
						</td>

						<td width="50%">
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
										<td>{{$invoice->clinic()->phone}} / {{($invoice->clinic()->fax) ? $invoice->clinic()->fax : ''}}</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>
			</div>

			<div class="columns p-t-30">
				<div class="column">
					<h3 class="has-text-primary">Detalles de la factura</h3>
					@include('app.invoices.pdf._table')
				</div>
			</div>
		</div>
	</div>

@endsection