@extends('layouts.admin')

@section('content')

<div class="col-md-12">
	@if(isset($harvest))
	    {{ Form::model($harvest, ['route' => ['harvests.update', $harvest->id], 'method' => 'patch']) }}
	@else
	    {{ Form::open(['route' => 'harvests.store']) }}
	@endif

	@if (Session::has('message'))
	    <div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{ Session::get('message') }}</div>
	@endif


	@if($errors->any())
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			{{ implode('', $errors->all('<li class="error">:message</li>')) }}
		</div>
	@endif

</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('base_url', 'URL') }}
	{{ Form::text('base_url', Input::old('base_url'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('metadata_prefix', 'Metadata prefix') }}
	{{ Form::text('metadata_prefix', Input::old('metadata_prefix'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('set_name', 'Názov setu') }}
	{{ Form::text('set_name', Input::old('set_name'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('set_spec', 'Špecifikácia setu') }}
	{{ Form::text('set_spec', Input::old('set_spec'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('set_description', 'Popis setu') }}
	{{ Form::textarea('set_description', Input::old('set_description'), array('class' => 'form-control')) }}	
	</div>
</div>

<div class="col-md-12 text-center">
	{{ Form::submit('Uložiť', array('class' => 'btn btn-default')) }} &nbsp; 
	{{ link_to_route('harvests.index', 'Zrušiť', null, array('class' => 'btn btn-default')) }}
	{{Form::close() }}
</div>

@stop