<tr>
	<th>Nombre</th>
	<td>{{auth()->user()->fullName()}}</td>
</tr>
<tr>
	<th>NIF / CIF</th>
	<td>{{auth()->user()->nif}}</td>
</tr>
<tr>
	<th>Dirección</th>
	<td>{{auth()->user()->address}}</td>
</tr>
<tr>
	<th></th>
	<td>{{auth()->user()->post_code}} {{auth()->user()->locality}} ({{auth()->user()->province}})</td>
</tr>
@if(auth()->user()->phone or auth()->user()->fax)
	<tr>
		<th>Tel / Fax</th>
		@if(auth()->user()->phone and auth()->user()->fax)
			<td>{{auth()->user()->phone}}  / {{auth()->user()->fax}}</td>
		@elseif(auth()->user()->phone)
			<td>{{auth()->user()->phone}}</td>
		@else
			<td>{{auth()->user()->phone}}</td>
		@endif
	</tr>
@else
	<tr>
		<th>&nbsp;</th>
		<td>&nbsp;</td>
	</tr>
@endif