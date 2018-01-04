@extends('layouts.app')

@section('title', '| Nueva clínica')

@section('content')

	<div class="columns">
		<div class="column">
			<a href="{{route('clinics.index')}}" class="button is-pulled-right">Volver</a>
			<div class="title">Nueva clínica</div>
			<hr>
		</div>
	</div>

	<div class="columns">
		<div class="column">

			<div class="field">
				<label for="autocomplete" class="label is-small">Busca la dirección en Google</label>
				<p class="control has-icons-left">
					<input id="autocomplete" type="text" class="input is-small is-primary" placeholder="Calle de la amargura..." autofocus></input>
					<span class="icon is-small is-left"><i class="fa fa-globe"></i></span>
				</p>
			</div>

			<form class="form" method="POST" action="{{route('clinics.store')}}" role="form">
			    {{csrf_field()}}

					<h3 class="has-text-primary">Datos de localización</h3>

					<div class="columns">
				    <div class="column is-three-fifths p-b-0">
				    	<div class="field{{ $errors->has('address') ? ' has-error' : '' }}">
				    	    <label for="address" class="label is-small">Dirección</label>

				    	    <p class="control has-icons-left">
				    	        <input id="address" type="text" class="input is-small{{ $errors->has('address') ? ' is-danger' : ' is-primary' }}" name="address" value="{{old('address')}}">
				    	        <span class="icon is-small is-left"><i class="mdi mdi-map-marker"></i></span>

				    	        @if($errors->has('address'))
				    	            <p class="help is-danger">{{ $errors->first('address') }}</p>
				    	        @endif
				    	    </p>
				    	</div>
				    </div>

				    <div class="column is-two-fifths p-b-0">
				    	<div class="field{{ $errors->has('locality') ? ' has-error' : '' }}">
				    	    <label for="locality" class="label is-small">Localidad</label>

				    	    <p class="control has-icons-left">
				    	        <input id="locality" type="text" class="input is-small{{ $errors->has('locality') ? ' is-danger' : ' is-primary' }}" name="locality" value="{{old('locality')}}">
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
			    		    <label for="province" class="label is-small">Provinica</label>

			    		    <p class="control has-icons-left">
			    		        <input id="province" type="text" class="input is-small{{ $errors->has('province') ? ' is-danger' : ' is-primary' }}" name="province" value="{{old('province')}}">
			    		        <span class="icon is-small is-left"><i class="mdi mdi-map-marker"></i></span>

			    		        @if($errors->has('province'))
			    		            <p class="help is-danger">{{ $errors->first('province') }}</p>
			    		        @endif
			    		    </p>
			    		</div>
			    	</div>

			    	<div class="column is-one-third">
			    		<div class="field{{ $errors->has('country') ? ' has-error' : '' }}">
			    		    <label for="country" class="label is-small">País</label>

			    		    <p class="control has-icons-left">
			    		        <input id="country" type="text" class="input is-small{{ $errors->has('country') ? ' is-danger' : ' is-primary' }}" name="country" value="{{old('country')}}">
			    		        <span class="icon is-small is-left"><i class="mdi mdi-map-marker"></i></span>

			    		        @if($errors->has('country'))
			    		            <p class="help is-danger">{{ $errors->first('country') }}</p>
			    		        @endif
			    		    </p>
			    		</div>
			    	</div>

			    	<div class="column is-one-third">
			    		<div class="field{{ $errors->has('post_code') ? ' has-error' : '' }}">
			    		    <label for="post_code" class="label is-small">Código postal</label>

			    		    <p class="control has-icons-left">
			    		        <input id="post_code" type="number" class="input is-small{{ $errors->has('post_code') ? ' is-danger' : ' is-primary' }}" name="post_code" value="{{old('post_code')}}">
			    		        <span class="icon is-small is-left"><i class="mdi mdi-map-marker-radius"></i></span>

			    		        @if($errors->has('post_code'))
			    		            <p class="help is-danger">{{ $errors->first('post_code') }}</p>
			    		        @endif
			    		    </p>
			    		</div>
			    	</div>
			    </div>

			    <h3 class="has-text-primary">Datos fiscales</h3>

			    <div class="columns">
			    	<div class="column is-one-third p-b-0">
			    		<div class="field{{ $errors->has('name') ? ' has-error' : '' }}">
			    		    <label for="name" class="label is-small">Nombre de la clínica</label>

			    		    <p class="control has-icons-left">
			    		        <input id="name" type="text" class="input is-small{{ $errors->has('name') ? ' is-danger' : ' is-primary' }}" name="name" value="{{old('name')}}">
			    		        <span class="icon is-small is-left"><i class="fa fa-home"></i></span>

			    		        @if($errors->has('name'))
			    		            <p class="help is-danger">{{ $errors->first('name') }}</p>
			    		        @endif
			    		    </p>
			    		</div>
			    	</div>

			    	<div class="column is-one-third p-b-0">
			    		<div class="field{{ $errors->has('contact') ? ' has-error' : '' }}">
			    		    <label for="contact" class="label is-small">Persona de contacto</label>

			    		    <p class="control has-icons-left">
			    		        <input id="contact" type="text" class="input is-small{{ $errors->has('contact') ? ' is-danger' : ' is-primary' }}" name="contact" value="{{old('contact')}}">
			    		        <span class="icon is-small is-left"><i class="fa fa-user"></i></span>

			    		        @if($errors->has('contact'))
			    		            <p class="help is-danger">{{ $errors->first('contact') }}</p>
			    		        @endif
			    		    </p>
			    		</div>
			    	</div>

			    	<div class="column is-one-third p-b-0">
			    		<div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
			    		    <label for="email" class="label is-small">E-mail</label>

			    		    <p class="control has-icons-left">
			    		        <input id="email" type="email" class="input is-small{{ $errors->has('email') ? ' is-danger' : ' is-primary' }}" name="email" value="{{old('email')}}">
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
			    		    <label for="nif" class="label is-small">NIF</label>

			    		    <p class="control has-icons-left">
			    		        <input id="nif" type="text" class="input is-small{{ $errors->has('nif') ? ' is-danger' : ' is-primary' }}" name="nif" value="{{old('nif')}}">
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
			    		        <input id="phone" type="text" class="input is-small{{ $errors->has('phone') ? ' is-danger' : ' is-primary' }}" name="phone" value="{{old('phone')}}">
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
			    		        <input id="fax" type="text" class="input is-small{{ $errors->has('fax') ? ' is-danger' : ' is-primary' }}" name="fax" value="{{old('fax')}}">
			    		        <span class="icon is-small is-left"><i class="fa fa-fax"></i></span>

			    		        @if($errors->has('fax'))
			    		            <p class="help is-danger">{{ $errors->first('fax') }}</p>
			    		        @endif
			    		    </p>
			    		</div>
			    	</div>

			    	<div class="column p-b-0 w-150">
			    		<div class="field{{ $errors->has('percentage') ? ' has-error' : '' }}">
			    		    <label for="percentage" class="label is-small">Mi porcentaje</label>

			    		    <p class="control has-icons-left">
			    		        <input id="percentage" type="number" class="input is-small{{ $errors->has('percentage') ? ' is-danger' : ' is-primary' }}" name="percentage" min="1" max="100" value="{{(old('percentage') !== null) ? old('percentage') : 50}}" >
			    		        <span class="icon is-small is-left"><i class="mdi mdi-percent"></i></span>

			    		        @if($errors->has('percentage'))
			    		            <p class="help is-danger">{{ $errors->first('percentage') }}</p>
			    		        @endif
			    		    </p>
			    		</div>
			    	</div>
			    </div>

			    <div class="control is-pulled-right">
			    		<a href="{{route('clinics.index')}}" class="button m-t-10 m-r-10">Cancelar</a>
			        <button type="submit" class="button is-primary m-t-10">Añadir clínica</button>
			    </div>
			</form>
		</div>
	</div>

@endsection

@push('scripts')

	<script>
	  // This example displays an address form, using the autocomplete feature
	  // of the Google Places API to help users fill in the information.

	  // This example requires the Places library. Include the libraries=places
	  // parameter when you first load the API. For example:
	  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

	  var placeSearch, autocomplete;
	  var componentForm = {
	    street_number: false,
	    route: false,
	    locality: false,
	    administrative_area_level_1: false,
	    administrative_area_level_2: false,
	    country: false,
	    postal_code: false
	  };

	  function initAutocomplete() {
	    // Create the autocomplete object, restricting the search to geographical
	    // location types.
	    autocomplete = new google.maps.places.Autocomplete(
	        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
	        {types: ['geocode']});

	    // When the user selects an address from the dropdown, populate the address
	    // fields in the form.
	    autocomplete.addListener('place_changed', fillInAddress);
	  }

	  function fillInAddress() {
	    // Get the place details from the autocomplete object.
	    var place = autocomplete.getPlace();
	    console.info(place.address_components);

	    for(var component in componentForm) componentForm[component] = false;

	    // Get each component of the address from the place details
	    // and fill the corresponding field on the form.
	    for (var i = 0; i < place.address_components.length; i++) {
	      var addressType = place.address_components[i].types[0];
	      if (componentForm[addressType] !== null) {
	        var val = place.address_components[i]['long_name'];
	        componentForm[addressType] = val;
	      }
	    }

	    var calle = componentForm['route'] || '',
	    		numero = componentForm['street_number'] || '',
	    		localidad = componentForm['locality'] || '',
	    		provincia = componentForm['administrative_area_level_2'] || '',
	    		ccaa = componentForm['administrative_area_level_1'] || '',
	    		pais = componentForm['country'] || '',
	    		cp = componentForm['postal_code'] || '';
	   	var direccion = calle;
	   	if(numero) direccion += ', ' + numero;

	   	document.getElementById('autocomplete').value = '';
	   	document.getElementById('address').value = direccion;
	   	document.getElementById('locality').value = localidad;
	   	document.getElementById('province').value = provincia;
	   	document.getElementById('country').value = pais;
	   	document.getElementById('post_code').value = cp;
	  }

	  // Bias the autocomplete object to the user's geographical location,
	  // as supplied by the browser's 'navigator.geolocation' object.
	  function geolocate() {
	    if (navigator.geolocation) {
	      navigator.geolocation.getCurrentPosition(function(position) {
	        var geolocation = {
	          lat: position.coords.latitude,
	          lng: position.coords.longitude
	        };
	        var circle = new google.maps.Circle({
	          center: geolocation,
	          radius: position.coords.accuracy
	        });
	        autocomplete.setBounds(circle.getBounds());
	      });
	    }
	  }
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsUrHpDmE-xK7rHWLxBU6Am7weZkkxZ90&libraries=places&callback=initAutocomplete"
	    async defer></script>

@endpush