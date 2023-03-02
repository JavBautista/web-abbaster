@extends('layouts.app_abbaster')
@section('content')
<div class="container">
	@if(Session::has('alert'))
		<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	@endif
	<shopping-cart></shopping-cart>
</div>
@endsection