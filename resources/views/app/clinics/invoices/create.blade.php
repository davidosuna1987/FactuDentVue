@extends('layouts.app')

@section('title')
	| Crear factura para {{$clinic->name}}
@endsection

@section('content')

	<div id="invoice">

		<div class="columns">
			<div class="column">
	  		<a href="{{route('clinics.invoices', $clinic)}}" class="button is-pulled-right is-rounded">Volver</a>
				<div class="title title-secondary has-text-white">Crear factura para {{$clinic->name}}</div>
				{{-- <hr> --}}
			</div>
		</div>

		<div class="card">
			<div class="card-content">
				<div class="invoice-info">

					<h3 class="has-text-primary">Datos fiscales</h3>
					<div class="columns">
						<div class="column">
							{{-- @php($lastInvoiceID = $clinic->invoices()->orderBy('id', 'DESC')->pluck('invoice_no')->first() or 0) --}}
							@php($lastInvoiceID = auth()->user()->invoices()->orderBy('id', 'DESC')->pluck('invoice_no')->first() or 0)
							<table class="table has-no-borders is-narrow has-text-small has-no-padding">
								<tbody>
									<tr>
										<th>Nº factura</th>
										<td class="invoice-no-fake" data-invoiceno="{{$lastInvoiceID+1}}">{{sprintf('%06d', $lastInvoiceID+1)}}</td>
									</tr>
									<tr>
										<th>Fecha</th>
										{{-- <td><input class="input invoice-date-fake is-small" id="invoice_date_fake" type="date" name="invoice_date_fake" value="{{\Carbon::parse('first day of this month')->format('Y-m-d')}}"></td> --}}
										<td>
			                <b-field class="invoice-date-picker-field">
				                <b-datepicker
				                		v-model="invoiceDateExpedition"
				                    placeholder="Fecha expedición"
				                    icon="calendar-today"
				                    size="is-small"
				                    :first-day-of-week="1"
				                    :month-names="monthNames"
				                    :day-names="dayNames"
				                    :readonly="false"
				                    :date-formatter="invoiceDateFormatter">
				                </b-datepicker>
				            	</b-field>
										</td>
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
										<td>{{$clinic->name}}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>{{$clinic->email}}</td>
									</tr>
									<tr>
										<th>NIF / CIF</th>
										<td>{{$clinic->nif}}</td>
									</tr>
									<tr>
										<th>Dirección</th>
										<td>{{$clinic->address}}</td>
									</tr>
									<tr>
										<th></th>
										<td>{{$clinic->post_code}} {{$clinic->locality}} ({{$clinic->province}})</td>
									</tr>
									<tr>
										<th>Teléfono / Fax</th>
										<td>{{$clinic->phone}} / {{($clinic->fax) ? $clinic->fax : ''}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="columns">
						<div class="column">

							<h3 class="has-text-primary">Detalles de la factura</h3>
							@include('app.clinics.invoices._form')

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
