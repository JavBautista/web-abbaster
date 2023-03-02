@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'index'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Afiliados</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
          	
            <div class="list-group">
                 <a href="/dashboard/afiliados/discount-codes/" class="list-group-item list-group-item-action">Codigos de Descuento</a>
                 <a href="/dashboard/afiliados/sellers/" class="list-group-item list-group-item-action">Admin. Afiliados</a>
                 <a href="/dashboard/afiliados/porcentajes-comisiones/" class="list-group-item list-group-item-action">Admin. Procentajes de Comisiones</a>

                
            
            </div>

        </div>
    </div>
</div>
@endsection
