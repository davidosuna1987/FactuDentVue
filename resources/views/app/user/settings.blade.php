@extends('layouts.app')

@section('title', '| Ajustes de '.$user->fullName())

@section('content')

	<div class="columns">
		<div class="column">
			<a href="{{auth()->user()->isAdmin() ? route('admin.index') : route('app.index')}}" class="button is-pulled-right is-rounded">Volver</a>
			<div class="title title-secondary has-text-white">Editar ajustes</div>
			{{-- <hr> --}}
		</div>
	</div>

	<div class="card">
		<div class="card-content">
			<div class="columns">
				<div class="column">

					@if($errors->any())
						<p class="label has-text-danger is-small">
							<strong class="has-text-danger">Atención: </strong>
							Todos los campos marcados con * son obligatorios.
						</p>
					@endif

					<form class="form" method="POST" action="{{route('settings.update', $user)}}" role="form" enctype="multipart/form-data">
					    {{csrf_field()}}
					    {{method_field('PUT')}}

							<h3 class="has-text-primary">Datos de configuración</h3>

							<div class="columns">
						    <div class="column is-three-fifths p-b-0">
						    	<div class="field{{ $errors->has('api_key') ? ' has-error' : '' }}">
						    	    <label for="api_key" class="label is-small">API key</label>

						    	    <pre>{{$user->api_key}}</pre>

						    	    {{-- <p class="control has-icons-left">
						    	        <input id="api_key" type="text" class="input is-small {{ $errors->has('api_key') ? 'is-danger' : '' }}" name="api_key" value="{{$user->api_key}}" disabled>
						    	        <span class="icon is-small is-left"><i class="mdi mdi-key"></i></span>

						    	        @if($errors->has('api_key'))
						    	            <p class="help is-danger">{{ $errors->first('api_key') }}</p>
						    	        @endif
						    	    </p> --}}
						    	</div>
						    </div>

						    <div class="column is-two-fifth p-b-0">
						    	<div class="field">
						    	    <label for="role" class="label is-small">Tipo de usuario</label>

						    	    <pre>{{$user->role->name}}</pre>

						    	    {{-- <p class="control has-icons-left">
						    	        <input id="role" type="text" class="input is-small" name="role" value="" disabled>
						    	        <span class="icon is-small is-left"><i class="fa fa-user-secret"></i></span>
						    	    </p> --}}
						    	</div>
						    </div>
						  </div>

							<h3 class="has-text-primary">Clínicas y facturación</h3>

						  <div class="columns">
						    <div class="column is-one-fifth p-b-0">
						    	<div class="field{{ $errors->has('default_percentage') ? ' has-error' : '' }}">
						    	    <label for="default_percentage" class="label is-small tooltip is-tooltip-multiline" data-tooltip="Se usará como información para saber qué porcentaje de beneficio tienes en cada clínica.">Mi % por defecto <span class="has-text-primary">*</span></label>

						    	    <p class="control has-icons-left">
						    	        <input id="default_percentage" type="number" class="input is-small {{ $errors->has('default_percentage') ? 'is-danger' : '' }}" name="default_percentage" value="{{$user->default_percentage or old('default_percentage')}}">
						    	        <span class="icon is-small is-left"><i class="mdi mdi-percent"></i></span>

						    	        @if($errors->has('default_percentage'))
						    	            <p class="help is-danger">{{ $errors->first('default_percentage') }}</p>
						    	        @endif
						    	    </p>
						    	</div>
						    </div>

						    <div class="column is-one-fifth p-b-0">
						    	<div class="field{{ $errors->has('default_retention') ? ' has-error' : '' }}">
						    	    <label for="default_retention" class="label is-small tooltip is-tooltip-multiline" data-tooltip="Porcentaje de retención que se aplicará al subtotal de la factura.">Retención % por defecto <span class="has-text-primary">*</span></label>

						    	    <p class="control has-icons-left">
						    	        <input id="default_retention" type="number" class="input is-small {{ $errors->has('default_retention') ? 'is-danger' : '' }}" name="default_retention" value="{{$user->default_retention or old('default_retention')}}">
						    	        <span class="icon is-small is-left"><i class="mdi mdi-percent"></i></span>

						    	        @if($errors->has('default_retention'))
						    	            <p class="help is-danger">{{ $errors->first('default_retention') }}</p>
						    	        @endif
						    	    </p>
						    	</div>
						    </div>
						  </div>

							<h3 class="has-text-primary">Ajustes PDF</h3>

							<div class="columns">
						    <div class="column is-one-fifth p-b-0">
						    	<div class="field {{ $errors->has('pdf_color') ? 'has-error' : '' }}">
						    	    <label for="pdf-color" class="label is-small tooltip" data-tooltip="Color que se aplicará a los títulos de la factura PDF.">Color secundario (títulos) <span class="has-text-primary">*</span></label>

						    	    <p class="control has-icons-left color-picker-wrapper" data-tooltip="Haz click para cambiar el color">
						    	        <input id="pdf-color" type="text" class="input is-small {{ $errors->has('pdf_color') ? 'is-danger' : '' }}" name="pdf_color" value="{{$user->pdf_color or old('pdf_color')}}">
						    	        <span class="icon is-small is-left"><i class="mdi mdi-palette"></i></span>
						    	        <span id="color-picker" class="tooltip" data-tooltip="Haz click para elegir un color" style="color:{{$user->pdf_color}}"><i class="mdi mdi-palette"></i></span>

						    	        @if($errors->has('pdf_color'))
						    	            <p class="help is-danger">{{ $errors->first('pdf_color') }}</p>
						    	        @endif
						    	    </p>
						    	</div>
						    </div>
						  </div>

						  <div class="columns">
						  	<div class="column p-b-0">
						  		<div><span class="switcher-title label is-small">Mostrar logo</span></div>
						  		<label for="show-logo" class="switcher">
							  		<span class="switcher-wrapper">
							  			<input id="show-logo" name="show_logo" type="checkbox" {{$user->show_logo ? 'checked' : ''}}>
											<span class="switcher-controls">
												<span class="switcher-true">Sí</span>
												<span class="switcher-limit"></span>
												<span class="switcher-false">No</span>
											</span>
										</span>
									</label>
						  	</div>
						  </div>

						  <div class="columns">
						  	<div class="column p-b-0">
						  		<div><span class="switcher-title label is-small">Mostrar pubilcidad (footer)</span></div>
						  		<label for="show-advertising" class="switcher">
							  		<span class="switcher-wrapper">
							  			<input id="show-advertising" name="show_advertising" type="checkbox" {{$user->show_advertising ? 'checked' : ''}}>
											<span class="switcher-controls">
												<span class="switcher-true">Sí</span>
												<span class="switcher-limit"></span>
												<span class="switcher-false">No</span>
											</span>
										</span>
									</label>
						  	</div>
						  </div>

						  <div class="columns">
						  	<div class="column p-b-0">
						  		<div><span class="switcher-title label is-small m-b-10">Cambiar logo del PDF</span></div>
						  		{{-- <b-field>
							        <b-upload accept=".png, .jpg, .jpeg" name="custom_logo" v-model="customLogo">
							            <a class="button is-primary">
							                <b-icon icon="upload"></b-icon>
							                <span>Subir nuevo logo</span>
							            </a>
							        </b-upload>
							        <span class="file-name">{{$user->custom_logo ? $user->custom_logo : 'Logo FactuDent'}}</span>
							    </b-field> --}}

							    <div id="logo-previewer-container" data-defaultlogo="{{asset('images/factudent-logo.png')}}">
							    	<img src="{{$user->customLogoFilePath() ? $user->customLogoFilePath() : asset('images/factudent-logo.png')}}" alt="Logo facturas" id="logo-previewer" width="225">
										<a class="button is-link is-small m-l-10 btn-set-default-logo {{$user->custom_logo_filename ? 'visible' : ''}}">
									    <span class="icon">
									      <i class="mdi mdi-tooth"></i>
									    </span>
									    <span>Restablecer logo FactuDent</span>
									  </a>
							    </div>
									<div id="custom-logo-upload">
										<span class="select-file-fake-container">
											<a class="button is-primary is-small select-file-fake-button">
										    <span class="icon">
										      <i class="fa fa-upload"></i>
										    </span>
										    <span>Seleccionar archivo</span>
										  </a>
										  <input type="file" name="custom_logo" id="custom-logo-file-input" accept="image/jpg, image/jpeg, image/png" />
										  <input type="hidden" name="remove_custom_logo" id="remove-custom-logo-input" value="0">
										</span>
										<span class="filename">
											{{$user->custom_logo_filename ? $user->custom_logo_filename : 'Ningún archivo seleccionado'}}
										</span>
									</div>
									@if($errors->has('custom_logo'))
		    	            <p class="help is-danger">{{ $errors->first('custom_logo') }}</p>
		    	        @endif
						  	</div>
						  </div>

					    <div class="control is-pulled-right">
					    		<a href="{{route('app.index')}}" class="button m-t-10 m-r-10 is-rounded">Cancelar</a>
					        <button type="submit" class="button m-t-10 is-primary is-rounded">Guardar ajustes</button>
					    </div>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
	@include('partials.scripts.colpick')

	<script>
		jQuery(document).ready(function($) {

			$('#pdf-color').click(function(e) {
				$(this).blur();
				$('#color-picker').click();
			});

			var previous_colorpicker_color = '{{$user->pdf_color}}';

			$('.colpick_default').click(function(e) {
				previous_colorpicker_color = '#00d1b2';
			});

			$('#color-picker').colpick({
				layout:'hex',
				submit:0,
				color: '{{$user->pdf_color}}',
				onChange:function(hsb,hex,rgb,el,bySetColor) {
					if((rgb.r > 240) && (rgb.g > 240) && (rgb.b > 240)){
						var colorpicker_color = '#f8f8f8';
					}else{
						var colorpicker_color = '#'+hex;
					}
					$('#color-picker').css('color', colorpicker_color);
				},
				onSubmit:function(hsb,hex,rgb,el,bySetColor){
					$('#pdf-color').val('#'+hex);
					if((rgb.r > 240) && (rgb.g > 240) && (rgb.b > 240)){
						var colorpicker_color = '#f8f8f8';
						previous_colorpicker_color = '#f8f8f8';
					}else{
						var colorpicker_color = '#'+hex;
						previous_colorpicker_color = '#'+hex;
					}
					$('#color-picker').css('color', colorpicker_color);
					$('.colpick_hex').hide();
				},
				onHide:function(hsb,hex,rgb,el,bySetColor){
					// $('#color-picker').css('color', previous_colorpicker_color);
				}
			});

		});
	</script>
@endpush