@extends('ccc::layouts.master')

@section('content')

	<table class="table table-bordered">

	{{ Form::model($view_var, array('route' => array($form_update, $view_var->id), 'method' => 'put', 'files' => true, 'id' => 'EditForm')) }}

		@include($form_path, $view_var)

	{{ Form::close() }}

	</table>
@stop
