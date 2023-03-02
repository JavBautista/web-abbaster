@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'porcentajes_comisiones.index'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Porcentajes Comisiones</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
          	
            

        </div>
    </div>
</div>
@endsection
