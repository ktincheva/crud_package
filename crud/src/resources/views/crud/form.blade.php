<form role="form">
  {{-- Show the erros, if any --}}
  @if (isset($errors) && $errors->any())
  	<div class="callout alert-danger">
        <h4>{{ trans('validation.please_fix') }}</h4>
        <ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
  @endif

  {{-- Show the inputs --}}
  @foreach ($settings->fields as $field)
    <!-- load the view from the application if it exists, otherwise load the one in the package -->
	@if(view()->exists('crud::fields.'.$field['type']))
		@include('crud::fields.'.$field['type'], array('field' => $field))
	@else
		@include('crud.fields::'.$field['type'], array('field' => $field))
	@endif
  @endforeach
</form>

{{-- For each form type, load its assets, if needed --}}
{{-- But only once per field type (no need to include the same css/js files multiple times on the same page) --}}
<?php
	$loaded_form_types_css = array();
	$loaded_form_types_js = array();
?>

@section('head')
	
	
@endsection

@section('scripts')
	
@endsection