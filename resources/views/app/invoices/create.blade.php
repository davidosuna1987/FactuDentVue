@extends('layouts.app')

@section('title')
	| Nueva factura
@endsection

@section('content')

	<div id="invoice">

		<div class="columns">
			<div class="column">
	  		<a href="{{route('invoices.index')}}" class="button is-pulled-right is-rounded">Volver</a>
				<div class="title title-secondary has-text-white">Nueva factura</div>
				{{-- <hr> --}}
			</div>
		</div>

		<div class="card">
			<div class="card-content">
				@if(auth()->user()->clinics()->count())
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
											<td class="has-input-field invoice-clinic-id-fake-td">
												<div class="control">
												  <div class="select is-small">
												    <select class="invoice-clinic-id-fake is-primary">
											    	  <option value="0" selected>Selecciona una clínica</option>
												      @foreach(auth()->user()->clinics()->get() as $clinic)
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
																	{{$clinic->name}}
																</option>
												      @endforeach
												    </select>
												  </div>
												</div>
											</td>
										</tr>
										<tr>
											<th>Email</th>
											<td class="clinic-email"></td>
										</tr>
										<tr>
											<th>NIF / CIF</th>
											<td class="clinic-nif"></td>
										</tr>
										<tr>
											<th>Dirección</th>
											<td class="clinic-address"></td>
										</tr>
										<tr>
											<th></th>
											<td class="clinic-address-2"></td>
										</tr>
										<tr>
											<th>Teléfono / Fax</th>
											<td class="clinic-phone-fax"></td>
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
				@else
					<p class="disabled">
						Para crear facturas, primero debes añadir una clínica.
						<a href="{{route('clinics.create')}}" class="button is-primary is-pulled-right is-rounded">Crear clínica</a>
					</p>
				@endif
			</div>
		</div>
	</div>

@endsection
