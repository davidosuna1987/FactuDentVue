@extends('layouts.app')

@section('title')
	| Crear factura para {{$clinic->name}}
@endsection

@section('content')

	<div id="invoice">

		<div class="columns">
			<div class="column">
	  		<a href="{{route('clinics.invoices', $clinic)}}" class="button is-pulled-right">Volver</a>
				<div class="title">Crear factura para {{$clinic->name}}</div>
				<hr>
			</div>
		</div>

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
								<td><input class="input invoice-date-fake is-primary is-small" id="invoice_date_fake" type="date" name="invoice_date_fake" value="{{\Carbon\Carbon::parse('today')->format('Y-m-d')}}"></td>
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
				</div>

				<div class="column">
					<table class="table has-no-borders is-narrow has-text-small has-no-padding">
						<tbody>
							<tr>
								<th>Cliente</th>
								<td>{{$clinic->contact}}</td>
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

@endsection