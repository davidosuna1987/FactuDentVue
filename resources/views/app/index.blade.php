@extends('layouts.app')

@section('content')
	<h1>Hola {{auth()->user()->name}}, este es tu panel de administración</h1>
@endsection
