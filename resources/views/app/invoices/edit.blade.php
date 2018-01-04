@extends('layouts.app')

@section('title')
	| Editar factura {{$invoice->invoice_no}}
@endsection

@section('content')

	<div id="invoice">

		<div class="columns">
			<div class="column">
	  		<a href="{{route('invoices.index')}}" class="button is-pulled-right">Volver</a>
				<div class="title">Editar factura {{$invoice->invoice_no}}</div>
				<hr>
			</div>
		</div>

		<div class="invoice-info">
			<h3 class="has-text-primary">
				Datos fiscales
			</h3>
			<div class="columns">
				<div class="column">
					<table class="table has-no-borders is-narrow has-text-small has-no-padding">
						<tbody>
							<tr>
								<th>Nº factura</th>
								<td class="invoice-no-fake" data-invoiceno="{{$invoice->invoice_no}}">{{sprintf('%06d', $invoice->invoice_no)}}</td>
							</tr>
							<tr>
								<th>Fecha</th>
								<td><input class="input invoice-date-fake is-primary is-small" id="invoice_date_fake" type="date" name="invoice_date_fake" value="{{\Carbon\Carbon::parse('today')->format('Y-m-d')}}"></td>
							</tr>
							<tr>
								<th>Nombre</th>
								<td>{{Auth::user()->fullName()}}</td>
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
								{{-- <td>{{$invoice->clinic()->contact}}</td> --}}
								<td class="has-input-field invoice-clinic-id-fake-td">
									<div class="control">
									  <div class="select is-small">
									    <select class="invoice-clinic-id-fake is-primary">
									    	<option selected
														value="{{$invoice->clinic()->id}}"
														data-id="{{$invoice->clinic()->id}}"
														data-name="{{$invoice->clinic()->name}}"
														data-contact="{{$invoice->clinic()->contact}}"
														data-email="{{$invoice->clinic()->email}}"
														data-nif="{{$invoice->clinic()->nif}}"
														data-address="{{$invoice->clinic()->address}}"
														data-locality="{{$invoice->clinic()->locality}}"
														data-province="{{$invoice->clinic()->province}}"
														data-post_code="{{$invoice->clinic()->post_code}}"
														data-phone="{{$invoice->clinic()->phone}}"
														data-fax="{{$invoice->clinic()->fax}}">
														{{$invoice->clinic()->contact}}
													</option>
									      @foreach(auth()->user()->clinics() as $clinic)
									      	@if($invoice->clinic_id != $clinic->id)
														<option value="{{$clinic->id}}"
															data-id="{{$clinic->id}}"
															data-name="{{$clinic->name}}"
															data-contact="{{$clinic->contact}}"
															data-email="{{$clinic->email}}"
															data-nif="{{$clinic->nif}}"
															data-address="{{$clinic->address}}"
															data-locality="{{$clinic->locality}}"
															data-province="{{$clinic->province}}"
															data-post_code="{{$clinic->post_code}}"
															data-phone="{{$clinic->phone}}"
															data-fax="{{$clinic->fax}}">
															{{$clinic->contact}}
														</option>
													@endif
									      @endforeach
									    </select>
									  </div>
									</div>
								</td>
							</tr>
							<tr>
								<th>Email</th>
								<td class="clinic-email">{{$invoice->clinic()->email}}</td>
							</tr>
							<tr>
								<th>NIF / CIF</th>
								<td class="clinic-nif">{{$invoice->clinic()->nif}}</td>
							</tr>
							<tr>
								<th>Dirección</th>
								<td class="clinic-address">{{$invoice->clinic()->address}}</td>
							</tr>
							<tr>
								<th></th>
								<td class="clinic-address-2">{{$invoice->clinic()->post_code}} {{$invoice->clinic()->locality}} ({{$invoice->clinic()->province}})</td>
							</tr>
							<tr>
								<th>Teléfono / Fax</th>
								<td class="clinic-phone-fax">{{$invoice->clinic()->phone}} / {{($invoice->clinic()->fax) ? $invoice->clinic()->fax : ''}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="columns">
				<div class="column">

					<h3 class="has-text-primary">Detalles de la factura</h3>
					@include('app.invoices._form')

				</div>
			</div>
		</div>
	</div>

@endsection