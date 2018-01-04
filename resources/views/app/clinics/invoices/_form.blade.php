			@if(isset($invoice))
				<form class="create-invoice-form form" method="POST" action="{{route('clinics.invoices.update', [$clinic, $invoice->invoice_no])}}" role="form">
				{{method_field('PUT')}}
		    <input type="hidden" class="invoice-no" name="invoice_no" value="{{sprintf('%06d', $invoice->invoice_no)}}">
			@else
				<form class="create-invoice-form form" method="POST" action="{{route('clinics.invoices.store', $clinic)}}" role="form">
		    <input type="hidden" class="invoice-no" name="invoice_no" value="{{sprintf('%06d', $lastInvoiceID+1)}}">
			@endif
			    {{csrf_field()}}
			    <input type="hidden" class="invoice-date" name="invoice_date" value="{{\Carbon\Carbon::parse('today')->format('Y-m-d')}}">
			    <input type="hidden" class="invoice-clinic-id" name="clinic_id" value="{{$clinic->id}}">

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
											<input class="invoice-description input is-primary" name="invoiceline[{{$index}}][description]" required="required" value="{{$invoiceLine->description}}" />
										</td>
										<td class="has-input-field w-100">
											<input class="invoice-quantity input is-primary" type="number" name="invoiceline[{{$index}}][quantity]" min="1" value="{{$invoiceLine->quantity}}" required="required">
										</td>
										<td class="has-input-field w-150">
											<input class="invoice-unit-price input is-primary" type="number" name="invoiceline[{{$index}}][unit_price]" min="1" value="{{$invoiceLine->unit_price}}" required="required">
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
										<input class="invoice-description input is-primary" name="invoiceline[1][description]" required="required" value="Trabajos realizados el mes de {{\Carbon\Carbon::parse('first day of this month')->startOfMonth()->format('F')}}" />
									</td>
									<td class="has-input-field w-100">
										<input class="invoice-quantity input is-primary" type="number" name="invoiceline[1][quantity]" min="1" value="1" required="required">
									</td>
									<td class="has-input-field w-150">
										<input class="invoice-unit-price input is-primary" type="number" name="invoiceline[1][unit_price]" min="1" value="1" required="required">
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
								<td class="is-empty" colspan="2"><span class="add-invoice-line has-text-primary" title="Añadir línea">Añadir línea</span></td>
								<th>Subtotal</th>
								@if(isset($invoice))
									<td class="invoice-subtotal has-text-right">{{$invoice->sub_total}}€</td>
								@else
									<td class="invoice-subtotal has-text-right">1€</td>
								@endif
							</tr>
							<tr>
								<td class="is-empty" colspan="2"></td>
								@if(isset($invoice))
									<th>Retención <span class="invoice-retention">{{$invoice->retention}}</span>%</th>
									<td class="invoice-retention-total has-text-right">{{$invoice->sub_total - $invoice->total}}€</td>
								@else
									<th>Retención <span class="invoice-retention">15</span>%</th>
									<td class="invoice-retention-total has-text-right">0,15€</td>
								@endif
							</tr>
							<tr>
								<td class="is-empty" colspan="2"></td>
								<th>Total</th>
								@if(isset($invoice))
									<td class="invoice-total has-text-right">{{$invoice->total}}€</td>
								@else
									<td class="invoice-total has-text-right">0,85€</td>
								@endif
							</tr>
						</tfoot>
					</table>

			    <div class="control is-pulled-right">
			    		<a href="{{route('clinics.invoices', $clinic)}}" class="button m-r-10 m-t-10">Cancelar</a>
			    		@if(isset($invoice))
			        	<button type="submit" class="submit-invoice button is-primary m-t-10">Guardar factura</button>
			        @else
			        	<button type="submit" class="submit-invoice button is-primary m-t-10">Añadir factura</button>
			        @endif
			    </div>
				</form>