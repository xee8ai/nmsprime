@extends ('layouts.default')

@include ('layouts.header')

<hr>

@section ('content')

@yield('content_top')

<hr>
<p align="right">
	@yield('content_top_2')
</p>

<hr>

	@yield('content_left')

@stop