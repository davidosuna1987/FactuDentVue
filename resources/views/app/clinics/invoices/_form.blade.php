			<form class="create-invoice-form form" method="POST" action="{{route('clinics.invoices.store', $clinic)}}" role="form">
		    <input type="hidden" class="invoice-no" name="invoice_no" value="{{$lastInvoiceID+1}}">
			    {{csrf_field()}}
			    <input v-model="invoiceDateExpedition" type="hidden" class="invoice-date" name="invoice_date" value="{{\Carbon::parse('first day of this month')->format('Y-m-d')}}">
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
						</tbody>
						<tfoot>
							<tr>
								<td class="is-empty" colspan="2"><span class="add-invoice-line has-text-primary">Añadir línea</span></td>
								<th>Subtotal</th>
								<td class="invoice-subtotal has-text-right">1€</td>
							</tr>
							<tr class="invoice-dentist-percentage-row">
								<td class="is-empty" colspan="2"></td>
								<th class="invoice-dentist-percentage-label">
									<span>Porcentaje odontólogo</span>
									<div class="field">
										<input type="number" name="dentist_percentage" class="invoice-dentist-percentage is-primary" value="{{auth()->user()->default_percentage ? auth()->user()->default_percentage : 50}}">
								    <span class="icon is-small"><i class="mdi mdi-percent"></i></span>
									</div>
								</th>
								<td class="invoice-dentist-percentage-total has-text-right">
									<span>{{auth()->user()->default_percentage ? str_replace(',00', '', number_format(ceil(1 * auth()->user()->default_percentage) / 100, 2, ',', '.')) : '0.50'}}€</span>
								</td>
							</tr>
							<tr class="invoice-retention-row">
								<td class="is-empty" colspan="2"></td>
								{{-- <th>Retención <span class="invoice-retention">15</span>%</th> --}}
								<th class="invoice-retention-label">
									<span class="invoice-retention-label">Retención</span>
									<div class="field">
										<input type="number" name="invoice_retention" class="invoice-retention" min="0" max="100" value="{{auth()->user()->default_retention}}">
								    <span class="icon is-small"><i class="mdi mdi-percent"></i></span>
									</div>
								</th>
								<td class="invoice-retention-total has-text-right">
									{{auth()->user()->default_percentage ? str_replace(',00', '', number_format(floor(0.15 * auth()->user()->default_percentage) / 100, 2, ',', '.')) : '0.15'}}€
								</td>
							</tr>
							<tr>
								<td class="is-empty" colspan="2"></td>
								<th>Total</th>
								<td class="invoice-total has-text-right">
									{{auth()->user()->default_percentage ? str_replace(',00', '', number_format(ceil(0.85 * auth()->user()->default_percentage) / 100, 2, ',', '.')) : '0.15'}}€
								</td>
							</tr>
						</tfoot>
					</table>

					<h3 class="has-text-primary">Ovserbaciones</h3>
					<b-field>
            <b-input maxlength="500" type="textarea" name="ovserbations" placeholder="Observaciones"></b-input>
        	</b-field>

			    <div class="control is-pulled-right">
			    		<a href="{{route('clinics.invoices', $clinic)}}" class="button is-rounded m-r-10 m-t-10">Cancelar</a>
		        	<button type="submit" class="submit-invoice button is-primary is-rounded m-t-10">Añadir factura</button>
			    </div>
				</form>
