@extends ('Layout.split84-nopanel')

@section('content_top')

	<li class="active"><a href={{route($route_name.'.index')}}>
	{{\App\Http\Controllers\BaseViewController::__get_view_icon(isset($view_var[0]) ? $view_var[0] : null)}}
	{{ \App\Http\Controllers\BaseViewController::translate_view($route_name.'s', 'Header', 2) }}</a>
	</li>

@stop

@section('content_left')

	<!-- Search Field
	@DivOpen(12)
		@DivOpen(8)
			{{ Form::model(null, array('route'=>$route_name.'.fulltextSearch', 'method'=>'GET')) }}
				@include('Generic.searchform')
			{{ Form::close() }}
		@DivClose()
	@DivClose()-->
	@DivOpen(12)
		<h1 class="page-header">
		{{\App\Http\Controllers\BaseViewController::__get_view_icon(isset($view_var[0]) ? $view_var[0] : null)}}
		{{$headline}}
		</h1>

		@if ($create_allowed)
			{{ Form::open(array('route' => $route_name.'.create', 'method' => 'GET')) }}
				<button class="btn btn-primary m-b-15" style="simple">
					<i class="fa fa-plus fa-lg m-r-10" aria-hidden="true"></i>
					{{ \App\Http\Controllers\BaseViewController::translate_view('Create '.$b_text, 'Button' )}}
				</button>
			{{ Form::close() }}
		@endif
	@DivClose()

	<!-- database entries inside a form with checkboxes to be able to delete one or more entries -->
	@DivOpen(12)

		{{ Form::open(array('route' => array($route_name.'.destroy', 0), 'method' => 'delete')) }}

			@if (isset($query) && isset($scope))
				<h4>Matches for <tt>{{ $query }}</tt> in <tt>{{ $scope }}</tt></h4>
			@endif

			<!-- <table> -->
			<br>

			<?php $controller = NameSpaceController::get_controller_name(); ?>
			
			{{ $controller::make_tree_table() }}

			<!-- </table> -->


		<!-- delete/submit button of form -->
			<button class="btn btn-danger btn-primary m-r-5 m-t-15" style="simple">
					<i class="fa fa-trash-o fa-lg m-r-10" aria-hidden="true"></i>
					{{ \App\Http\Controllers\BaseViewController::translate_view('Delete', 'Button') }}
			</button>
			{{ Form::close() }}


	@DivClose()

@stop



      <!-- <link href="{{asset('components/assets-admin/plugins/jstree/dist/themes/default/style.min.css') }}" rel="stylesheet"> -->
