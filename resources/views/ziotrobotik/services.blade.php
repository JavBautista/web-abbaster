@extends('layouts.app_ziotrobotik')

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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!--@ include('parts.form_change_show_tax')-->
            <div class="row">
            @foreach($services as $service)
                @include('parts.card_service_store')
            @endforeach
            </div>
            {{ $services->links() }}
        </div>
    </div>

    @include('parts.formulario_contacto',['shop_id'=>$shop->id])
</div>
@endsection