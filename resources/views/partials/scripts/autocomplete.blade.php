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

    var calle = componentForm['route'],
    		numero = componentForm['street_number'],
    		localidad = componentForm['locality'],
    		provincia = componentForm['administrative_area_level_2'],
    		ccaa = componentForm['administrative_area_level_1'],
    		pais = componentForm['country'],
    		cp = componentForm['postal_code'];
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