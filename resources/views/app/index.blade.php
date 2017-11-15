@extends('layouts.app')

@section('content')

	<div class="container app-index">
		<div class="card is-full-height is-translucid m-t-20">
			<div class="card-content">
				<h1 class="title">¡Bienvenid@ {{ $user->name }}!</h1>

				<div class="field is-grouped is-grouped-centered m-t-50 m-b-50">
					<p class="control w-400">
					    <input class="input is-primary" type="text" placeholder="Dame una palabra y haremos magia..." autofocus>
					</p>
					<p class="control">
					    <a class="button is-primary">
					      	¡VAMOS!
					    </a>
					</p>
				</div>

				<hr>

				<h2 class="subtitle">Histórico de búsquedas</h2>
				<table class="table is-narrow is-fullwidth">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="id w-50">1</th>
							<td class="name">Búsqueda 1</td>
							<td class="actions" style="width: 225px;text-align: right;">
								<a href="#" class="button is-small is-info"><span class="icon is-small m-r-5"><i class="mdi mdi-pencil"></i></span> Editar</a>
								<a href="#" class="button is-small is-primary"><span class="icon is-small m-r-5"><i class="mdi mdi-file-outline"></i></span> CSV</a>
								<a href="#" class="button is-small is-danger"><span class="icon is-small"><i class="mdi mdi-delete"></i></span></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection
