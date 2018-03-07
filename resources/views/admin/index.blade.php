@extends('layouts.app')

@section('content')

	<div class="card m-t-20">
		<div class="card-content">
			<h1 class="title is-1">¡Bienvenid@ {{ $user->name }}!</h1>
		</div>
	</div>

@endsection
