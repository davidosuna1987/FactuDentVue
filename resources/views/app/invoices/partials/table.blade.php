<table class="table is-narrow">
	<thead>
		<tr>
			<th>Nº Factura</th>
			<th>Fecha</th>
			<th>Total</th>
			<th>Pago</th>
			<th colspan="4">Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($invoices as $index => $invoice)
			<tr>
				<td class="name">{{$invoice->invoice_no}}</td>
				<td class="invoices">{{($invoice->invoice_date) ? date("j F Y", strtotime($invoice->invoice_date)) : ''}}</td>
				<td class="invoices">{{str_replace(',00', '',number_format($invoice->total, 2, ',', '.'))}}€</td>
				<td class="invoices">
					@if($invoice->payment_date)
						<form class="form form-set-invoice-as-unpaid" method="POST" action="{{route('invoices.unpay', $invoice->id)}}" role="form">
							{{csrf_field()}}
	            {{method_field('PUT')}}
							<button type="submit" class="button is-small is-success tooltip" data-tooltip="Haz click para marcar esta factura pendiente">Pagada</button>
						</form>
					@else
						<form class="form form-set-invoice-as-paid" method="POST" action="{{route('invoices.pay', $invoice->id)}}" role="form">
							{{csrf_field()}}
	            {{method_field('PUT')}}
							<button type="submit" class="button is-small is-danger tooltip" data-tooltip="Haz click para marcar esta factura como pagada">Pendiente</button>
						</form>
					@endif
				</td>
				<td class="actions w-10">
					<a href="{{route('invoices.show', $invoice->invoice_no)}}" class="button is-small tooltip" data-tooltip="Ver esta factura">
						<span class="icon"><i class="mdi mdi-eye"></i></span>
					</a>
				</td>
				<td class="actions w-10">
					<a href="{{route('invoices.edit', $invoice->invoice_no)}}" class="button is-small is-info tooltip" data-tooltip="Editar esta factura">
						<span class="icon"><i class="mdi mdi-pencil"></i></span>
					</a>
				</td>
				 <td class="actions w-10">
					<a href="{{route('invoices.pdf.show', $invoice->invoice_no)}}" class="show-pdf-button button is-small is-link tooltip" data-tooltip="Ver factura en PDF">
						<span class="icon"><i class="fa fa-file-pdf-o"></i></span>
					</a>
				</td>
				<td class="actions w-10">
					<form class="form form-delete-invoice" method="POST" action="{{route('invoices.delete', $invoice)}}" role="form">
						{{csrf_field()}}
            {{method_field('DELETE')}}
						<button type="submit" class="button is-small is-danger tooltip" data-tooltip="Eliminar esta factura">
							<span class="icon"><i class="mdi mdi-delete"></i></span>
						</button>
					</form>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

{{$invoices->render()}}