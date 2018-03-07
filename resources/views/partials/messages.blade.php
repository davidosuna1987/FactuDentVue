@if(Session::has('message'))
	<div class="snackbar {{Session::has('message-type') ? Session::get('message-type') : ''}}">
		{{Session::get('message')}} <a href="#">OK</a>
	</div>
@endif