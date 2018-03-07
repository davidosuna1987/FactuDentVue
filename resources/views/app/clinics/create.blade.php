@extends('layouts.app')

@section('title', '| Nueva clínica')

@section('content')

	<div class="columns">
		<div class="column">
			<a href="{{route('clinics.index')}}" class="button is-pulled-right is-rounded">Volver</a>
			<div class="title title-secondary has-text-white">Nueva clínica</div>
			{{-- <hr> --}}
		</div>
	</div>

	<div class="card">
		<div class="card-content">
			<div class="columns">
				<div class="column">

					@if($errors->any())
						<p class="label has-text-danger is-small">Recuerda que todos los campos marcados con * son obligatorios.</p>
					@endif

					<form class="form" method="POST" action="{{route('clinics.store')}}" role="form">
					    {{csrf_field()}}

					    <h3 class="has-text-primary">Datos fiscales</h3>

					    <div class="columns">
					    	<div class="column is-one-third p-b-0">
					    		<div class="field{{ $errors->has('name') ? ' has-error' : '' }}">
					    		    <label for="name" class="label is-small">Nombre de la clínica <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="name" type="text" class="input is-small {{ $errors->has('name') ? 'is-danger' : '' }}" name="name" value="{{old('name')}}">
					    		        <span class="icon is-small is-left"><i class="fa fa-home"></i></span>

					    		        @if($errors->has('name'))
					    		            <p class="help is-danger">{{ $errors->first('name') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>

					    	<div class="column is-one-third p-b-0">
					    		<div class="field{{ $errors->has('contact') ? ' has-error' : '' }}">
					    		    <label for="contact" class="label is-small">Persona de contacto <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="contact" type="text" class="input is-small {{ $errors->has('contact') ? 'is-danger' : '' }}" name="contact" value="{{old('contact')}}">
					    		        <span class="icon is-small is-left"><i class="fa fa-user"></i></span>

					    		        @if($errors->has('contact'))
					    		            <p class="help is-danger">{{ $errors->first('contact') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>

					    	<div class="column is-one-third p-b-0">
					    		<div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
					    		    <label for="email" class="label is-small">E-mail <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="email" type="email" class="input is-small {{ $errors->has('email') ? 'is-danger' : '' }}" name="email" value="{{old('email')}}">
					    		        <span class="icon is-small is-left"><i class="fa fa-at"></i></span>

					    		        @if($errors->has('email'))
					    		            <p class="help is-danger">{{ $errors->first('email') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>
					    </div>

					    <div class="columns">
					    	<div class="column p-b-0">
					    		<div class="field{{ $errors->has('nif') ? ' has-error' : '' }}">
					    		    <label for="nif" class="label is-small">NIF <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="nif" type="text" class="input is-small {{ $errors->has('nif') ? 'is-danger' : '' }}" name="nif" value="{{old('nif')}}">
					    		        <span class="icon is-small is-left"><i class="fa fa-id-card-o"></i></span>

					    		        @if($errors->has('nif'))
					    		            <p class="help is-danger">{{ $errors->first('nif') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>

					    	<div class="column p-b-0">
					    		<div class="field{{ $errors->has('phone') ? ' has-error' : '' }}">
					    		    <label for="phone" class="label is-small">Teléfono</label>

					    		    <p class="control has-icons-left">
					    		        <input id="phone" type="text" class="input is-small {{ $errors->has('phone') ? 'is-danger' : '' }}" name="phone" value="{{old('phone')}}">
					    		        <span class="icon is-small is-left"><i class="mdi mdi-phone-classic"></i></span>

					    		        @if($errors->has('phone'))
					    		            <p class="help is-danger">{{ $errors->first('phone') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>

					    	<div class="column p-b-0">
					    		<div class="field{{ $errors->has('fax') ? ' has-error' : '' }}">
					    		    <label for="fax" class="label is-small">Fax</label>

					    		    <p class="control has-icons-left">
					    		        <input id="fax" type="text" class="input is-small {{ $errors->has('fax') ? 'is-danger' : '' }}" name="fax" value="{{old('fax')}}">
					    		        <span class="icon is-small is-left"><i class="fa fa-fax"></i></span>

					    		        @if($errors->has('fax'))
					    		            <p class="help is-danger">{{ $errors->first('fax') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>

					    	<div class="column p-b-0 w-150">
					    		<div class="field{{ $errors->has('percentage') ? ' has-error' : '' }}">
					    		    <label for="percentage" class="label is-small">Mi porcentaje <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="percentage" type="number" class="input is-small {{ $errors->has('percentage') ? 'is-danger' : '' }}" name="percentage" min="1" max="100" value="{{(old('percentage') !== null) ? old('percentage') : (auth()->user()->default_percentage) ? auth()->user()->default_percentage : 50}}" >
					    		        <span class="icon is-small is-left"><i class="mdi mdi-percent"></i></span>

					    		        @if($errors->has('percentage'))
					    		            <p class="help is-danger">{{ $errors->first('percentage') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>
					    </div>

							<h3 class="has-text-primary">Datos de localización</h3>

							<div class="field">
								<label for="autocomplete" class="label is-small">Si quieres, puedes buscar la dirección en Google</label>
								<p class="control has-icons-left">
									<input id="autocomplete" type="text" class="input is-small" placeholder="Calle de la amargura..." autocomplete="off"></input>
									<span class="icon is-small is-left"><i class="fa fa-globe"></i></span>
								</p>
							</div>

							<div class="columns">
						    <div class="column is-three-fifths p-b-0">
						    	<div class="field{{ $errors->has('address') ? ' has-error' : '' }}">
						    	    <label for="address" class="label is-small">Dirección <span class="has-text-primary">*</span></label>

						    	    <p class="control has-icons-left">
						    	        <input id="address" type="text" class="input is-small {{ $errors->has('address') ? 'is-danger' : '' }}" name="address" value="{{old('address')}}">
						    	        <span class="icon is-small is-left"><i class="mdi mdi-map-marker"></i></span>

						    	        @if($errors->has('address'))
						    	            <p class="help is-danger">{{ $errors->first('address') }}</p>
						    	        @endif
						    	    </p>
						    	</div>
						    </div>

						    <div class="column is-two-fifths p-b-0">
						    	<div class="field{{ $errors->has('locality') ? ' has-error' : '' }}">
						    	    <label for="locality" class="label is-small">Localidad <span class="has-text-primary">*</span></label>

						    	    <p class="control has-icons-left">
						    	        <input id="locality" type="text" class="input is-small {{ $errors->has('locality') ? 'is-danger' : '' }}" name="locality" value="{{old('locality')}}">
						    	        <span class="icon is-small is-left"><i class="mdi mdi-map-marker"></i></span>

						    	        @if($errors->has('locality'))
						    	            <p class="help is-danger">{{ $errors->first('locality') }}</p>
						    	        @endif
						    	    </p>
						    	</div>
						    </div>
						  </div>

					    <div class="columns">
					    	<div class="column is-one-third">
					    		<div class="field{{ $errors->has('province') ? ' has-error' : '' }}">
					    		    <label for="province" class="label is-small">Provinica <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="province" type="text" class="input is-small {{ $errors->has('province') ? 'is-danger' : '' }}" name="province" value="{{old('province')}}">
					    		        <span class="icon is-small is-left"><i class="mdi mdi-map-marker"></i></span>

					    		        @if($errors->has('province'))
					    		            <p class="help is-danger">{{ $errors->first('province') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>

					    	<div class="column is-one-third">
					    		<div class="field{{ $errors->has('country') ? ' has-error' : '' }}">
					    		    <label for="country" class="label is-small">País <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="country" type="text" class="input is-small {{ $errors->has('country') ? 'is-danger' : '' }}" name="country" value="{{old('country')}}">
					    		        <span class="icon is-small is-left"><i class="mdi mdi-map-marker"></i></span>

					    		        @if($errors->has('country'))
					    		            <p class="help is-danger">{{ $errors->first('country') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>

					    	<div class="column is-one-third">
					    		<div class="field{{ $errors->has('post_code') ? ' has-error' : '' }}">
					    		    <label for="post_code" class="label is-small">Código postal <span class="has-text-primary">*</span></label>

					    		    <p class="control has-icons-left">
					    		        <input id="post_code" type="text" class="input is-small {{ $errors->has('post_code') ? 'is-danger' : '' }}" name="post_code" value="{{old('post_code')}}">
					    		        <span class="icon is-small is-left"><i class="mdi mdi-map-marker-radius"></i></span>

					    		        @if($errors->has('post_code'))
					    		            <p class="help is-danger">{{ $errors->first('post_code') }}</p>
					    		        @endif
					    		    </p>
					    		</div>
					    	</div>
					    </div>

					    <div class="control is-pulled-right">
					    		<a href="{{route('clinics.index')}}" class="button m-t-10 m-r-10 is-rounded">Cancelar</a>
					        <button type="submit" class="button is-primary m-t-10 is-rounded">Añadir clínica</button>
					    </div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
	@include('partials.scripts.autocomplete')
@endpush