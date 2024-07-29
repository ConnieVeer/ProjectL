@if(session()->has('success'))
<div class="col-md-6 alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-label="close">
	<span aria-hidden="true">&times;</span>
	</button>
  {!! session()->get('success') !!}
</div>
@endif
