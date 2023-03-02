@extends('layouts.app_solartek')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="display-3">Servicios</h2>
            <span>
            	{!! $content_html !!}
            </span>	
        </div>
    </div>
</div>
@endsection