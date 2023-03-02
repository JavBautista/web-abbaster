@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'shops.index'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">        	
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <h2>Tiendas</h2>

    @forelse($shops as $shop) 
      <div class="row">        
        <div class="col-2">
          <h6>Logo Publico</h6>
          @switch($shop->name )
                @case('Eagletek MX')
                    <img class="img-thumbnail" src="{{ asset('assets/images/abbaster/eagletek_logo.png') }}" alt="Logo {{ $shop->name  }}">
                    @break
                @case('ZiotRobotic')
                    <img class="img-thumbnail" src="{{ asset('assets/images/abbaster/ziotrobotik_logo.jpg') }}" alt="Logo {{ $shop->name  }}">
                    @break
                @case('SOLARTEK MEXICO')
                    <img class="img-thumbnail" src="{{ asset('assets/images/abbaster/solartek_logo.png') }}" alt="Logo {{ $shop->name  }}">
                    @break
                @case('Euderm')
                    <img class="img-thumbnail" src="{{ asset('assets/images/abbaster/euderm.png') }}" alt="Logo {{ $shop->name  }}">
                    @break
                @case('Roho Seguros')
                    <img class="img-thumbnail" src="{{ asset('assets/images/abbaster/roho.png') }}" alt="Logo {{ $shop->name  }}">
                    @break
            
                @default
                    <img class="img-thumbnail" src="{{ asset('assets/eagletek/no-image.png') }}" alt="Sin Imagen">
            @endswitch
        </div>
        <div class="col-2">
          <h6>Logo Dinamico</h6>
          <img class="img-thumbnail" src="{{ $shop->getLogoStore($shop->logo) }}" alt="Logo {{$shop->name}}">
        </div>
        <div class="col-5">
            <h5>{{ $shop->name }}</h5>
            <p><strong>{{$shop->dynamic?'TIENDA DINAMICA':'TIENDA MANUAL'}}</strong></p>
            <div class="badge badge-{{ $shop->slug?'success':'danger' }}" role="alert">
              {{ $shop->slug?"Slug OK":'Actualice Slug' }}
            </div>


            <div class="badge badge-{{ $shop->status?'danger':'success' }}" role="alert">
              {{ $shop->status?'Inactivo':'Activo' }}
            </div>

            <p> <small class="text-muted">Creación: {{ $shop->created_at }}</small></p>
        </div>
        <div class="col-3">
          <div class="list-group">                 
            <a href="{{ route('global-configurations.shops.edit.status',['shop_id'=>$shop->id]) }}" class="list-group-item list-group-item-action">Editar Status</a>
            <a href="{{ route('global-configurations.shops.edit.datos',['shop_id'=>$shop->id]) }}" class="list-group-item list-group-item-action">Editar Datos</a>
            <a href="{{ route('global-configurations.shops.edit.tipo',['shop_id'=>$shop->id]) }}" class="list-group-item list-group-item-action">Editar Tipo</a>
            <a href="{{ route('global-configurations.shops.logo',['shop_id'=>$shop->id]) }}" class="list-group-item list-group-item-action">Logo</a>
            <a href="#" class="list-group-item list-group-item-action">Secciones</a>
          </div>
        </div>
      </div> 
      <hr>           
    @empty
      <p>Sin Datos</p>
    @endforelse  
      

    </div>
  </div>
</div>
@endsection
