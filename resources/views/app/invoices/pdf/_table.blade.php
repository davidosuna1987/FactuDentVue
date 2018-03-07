<table class="invoice-details-table table is-bordered is-narrow has-text-small">
	<thead>
		<tr>
			<th>Concepto</th>
			<th width="70px">Cantidad</th>
			<th class="w-100" width="70px">Precio</th>
			<th class="has-text-right" width="90px">Total</th>
		</tr>
	</thead>
	<tbody>
		@if(isset($invoice))
			@foreach($invoice->invoiceLines()->get() as $index => $invoiceLine)
				<tr class="invoice-line" data-id="{{$index}}">
					<td >{{$invoiceLine->description}}</td>
					<td width="70px">{{$invoiceLine->quantity}}</td>
					<td class="w-100">{{str_replace(',00', '', number_format($invoiceLine->unit_price, 2, ',', '.'))}}€</td>
					<td class="has-text-right w-100">{{str_replace(',00', '', number_format($invoiceLine->total, 2, ',', '.'))}}€</td>
				</tr>
			@endforeach
		@endif
	</tbody>
	<tfoot>
		<tr>
			<th class="has-text-right" colspan="3">Subtotal</th>
			<td class="invoice-subtotal has-text-right">{{str_replace(',00', '', number_format($invoice->sub_total, 2, ',', '.'))}}€</td>
		</tr>
		<tr class="invoice-dentist-percentage-row">
			<th class="has-text-right" colspan="3" class="invoice-dentist-percentage-label">
				<span>Porcentaje odontólogo {{$invoice->dentist_percentage}}%</span>
			</th>
			<td class="has-text-right">{{str_replace(',00', '', number_format(ceil($invoice->sub_total * $invoice->dentist_percentage) / 100, 2, ',', '.'))}}€</td>
		</tr>
		<tr>
			<th class="has-text-right" colspan="3">Retención {{$invoice->retention}}%</th>
			<td class="invoice-retention-total has-text-right">{{str_replace(',00', '', number_format(ceil($invoice->sub_total * $invoice->dentist_percentage) / 100 - $invoice->total, 2, ',', '.'))}}€</td>
		</tr>
		<tr>
			<th class="has-text-right" colspan="3">Total</th>
			<td class="invoice-total has-text-right">{{str_replace(',00', '', number_format($invoice->total, 2, ',', '.'))}}€</td>
		</tr>
	</tfoot>
</table>