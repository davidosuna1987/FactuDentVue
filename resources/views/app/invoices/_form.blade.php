			@if(isset($invoice))
				<form class="create-invoice-form form" method="POST" action="{{route('invoices.update', $invoice->invoice_no)}}" role="form">
				{{method_field('PUT')}}
		    <input type="hidden" class="invoice-no" name="invoice_no" value="{{$invoice->invoice_no}}">
	    	<input type="hidden" class="invoice-clinic-id" name="clinic_id" value="{{$invoice->clinic_id}}">
		    <input v-model="invoiceDateExpedition" type="hidden" class="invoice-date" name="invoice_date" value="{{\Carbon::parse($invoice->invoice_date)->format('Y-m-d')}}">
				<input id="invoice-state-input" name="invoice_paid" type="checkbox" {{$invoice->payment_date ? 'checked' : ''}}>
			@else
				<form class="create-invoice-form form" method="POST" action="{{route('invoices.store')}}" role="form">
		    <input type="hidden" class="invoice-no" name="invoice_no" value="{{$lastInvoiceID+1}}">
	    	<input type="hidden" class="invoice-clinic-id" name="clinic_id" value="0">
		    <input v-model="invoiceDateExpedition" type="hidden" class="invoice-date" name="invoice_date" value="{{\Carbon::parse('first day of this month')->format('Y-m-d')}}">
				<input id="invoice-state-input" name="invoice_paid" type="checkbox">
			@endif
			    {{csrf_field()}}

					<table class="invoice-details-table table is-bordered is-narrow has-text-small">
						<thead>
							<tr>
								<th>Concepto</th>
								<th class="w-100">Cantidad</th>
								<th class="w-150">Precio</th>
								<th class="w-150">Total</th>
								<th class="is-empty w-30"></th>
							</tr>
						</thead>
						<tbody>
							@if(isset($invoice))
								@foreach($invoice->invoiceLines()->get() as $index => $invoiceLine)
									<tr class="invoice-line" data-id="{{$index}}">
										<td class="has-input-field">
											<input class="invoice-description input" name="invoiceline[{{$index}}][description]" required="required" value="{{$invoiceLine->description}}" />
										</td>
										<td class="has-input-field w-100">
											<input class="invoice-quantity input" type="number" name="invoiceline[{{$index}}][quantity]" min="1" value="{{$invoiceLine->quantity}}" required="required">
										</td>
										<td class="has-input-field w-150">
											<input class="invoice-unit-price input" type="number" name="invoiceline[{{$index}}][unit_price]" min="1" value="{{$invoiceLine->unit_price}}" required="required">
										</td>
										<td class="has-text-right w-150">
											<span class="invoice-line-total">{{$invoiceLine->total}}€</span>
										</td>
										<td class="is-empty has-input-field w-30">
											<span class="remove-invoice-line has-text-danger" title="Eliminar línea">&times;</span>
										</td>
									</tr>
								@endforeach
							@else
								<tr class="invoice-line" data-id="1">
									<td class="has-input-field">
										<input class="invoice-description input" name="invoiceline[1][description]" required="required" value="Trabajos realizados el mes de {{\Carbon::parse('first day of this month')->startOfMonth()->format('F')}}" />
									</td>
									<td class="has-input-field w-100">
										<input class="invoice-quantity input" type="number" name="invoiceline[1][quantity]" min="1" value="1" required="required">
									</td>
									<td class="has-input-field w-150">
										<input class="invoice-unit-price input" type="number" name="invoiceline[1][unit_price]" min="1" value="1" required="required">
									</td>
									<td class="has-text-right w-150">
										<span class="invoice-line-total">1€</span>
									</td>
									<td class="is-empty has-input-field w-30">
										<span class="remove-invoice-line has-text-danger" title="Eliminar línea">&times;</span>
									</td>
								</tr>
							@endif
						</tbody>
						<tfoot>
							<tr>
								<td class="is-empty" colspan="2"><span class="add-invoice-line has-text-primary">Añadir línea</span></td>
								<th>Subtotal</th>
								@if(isset($invoice))
									<td class="invoice-subtotal has-text-right">{{$invoice->sub_total}}€</td>
								@else
									<td class="invoice-subtotal has-text-right">1€</td>
								@endif
							</tr>
							<tr class="invoice-dentist-percentage-row">
								<td class="is-empty" colspan="2"></td>
								@if(isset($invoice))
									<th class="invoice-dentist-percentage-label">
										<span>Porcentaje odontólogo</span>
										<div class="field">
											<input type="number" name="dentist_percentage" class="invoice-dentist-percentage" min="0" max="100" value="{{$invoice->dentist_percentage}}">
									    <span class="icon is-small"><i class="mdi mdi-percent"></i></span>
										</div>
									</th>
									<td class="invoice-dentist-percentage-total has-text-right">
										<span>{{str_replace(',00', '', number_format(ceil($invoice->sub_total * $invoice->dentist_percentage) / 100, 2, ',', '.'))}}€</span>
									</td>
								@else
									<th class="invoice-dentist-percentage-label">
										<span>Porcentaje odontólogo</span>
										<div class="field">
											<input type="number" name="dentist_percentage" class="invoice-dentist-percentage" min="0" max="100" value="{{auth()->user()->default_percentage ? auth()->user()->default_percentage : 50}}">
									    <span class="icon is-small"><i class="mdi mdi-percent"></i></span>
										</div>
									</th>
									<td class="invoice-dentist-percentage-total has-text-right"><span>0,50€</span></td>
								@endif
							</tr>
							<tr class="invoice-retention-row">
								<td class="is-empty" colspan="2"></td>
								@if(isset($invoice))
									{{-- <th>Retención <span class="invoice-retention">{{$invoice->retention}}</span>%</th> --}}
									<th class="invoice-retention-label">
										<span>Retención</span>
										<div class="field">
											<input type="number" name="invoice_retention" class="invoice-retention" min="0" max="100" value="{{$invoice->retention}}">
									    <span class="icon is-small"><i class="mdi mdi-percent"></i></span>
										</div>
									</th>
									<td class="invoice-retention-total has-text-right">{{str_replace(',00', '', number_format(floor($invoice->sub_total * $invoice->dentist_percentage) / 100 - $invoice->total, 2, ',', '.'))}}€</td>
								@else
									{{-- <th>Retención <span class="invoice-retention">15</span>%</th> --}}
									<th class="invoice-retention-label">
										<span>Retención</span>
										<div class="field">
											<input type="number" name="invoice_retention" class="invoice-retention" min="0" max="100" value="{{auth()->user()->default_retention ? auth()->user()->default_retention : 15}}">
									    <span class="icon is-small"><i class="mdi mdi-percent"></i></span>
										</div>
									</th>
									<td class="invoice-retention-total has-text-right">0,07€</td>
								@endif
							</tr>
							<tr>
								<td class="is-empty" colspan="2"></td>
								<th>Total</th>
								@if(isset($invoice))
									<td class="invoice-total has-text-right">{{str_replace(',00', '', number_format($invoice->total, 2, ',', '.'))}}€</td>
								@else
									<td class="invoice-total has-text-right">0,43€</td>
								@endif
							</tr>
						</tfoot>
					</table>

					<h3 class="has-text-primary">Ovserbaciones</h3>
					<b-field>
            <b-input maxlength="500" type="textarea" name="ovserbations" placeholder="Ovserbaciones" value="{{isset($invoice) ? $invoice->ovserbations : ''}}"></b-input>
        	</b-field>

			    <div class="control is-pulled-right">
			    		<a href="{{route('invoices.index')}}" class="button m-r-10 m-t-10 is-rounded">Cancelar</a>
			    		@if(isset($invoice))
			        	<button type="submit" class="submit-invoice button is-primary m-t-10 is-rounded">Guardar factura</button>
			        @else
			        	<button type="submit" class="submit-invoice button is-primary m-t-10 is-rounded">Añadir factura</button>
			        @endif
			    </div>
				</form>
