@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'index'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif

      <h2>CONFIGURACIONES GLOBALES</h2>
      <div class="list-group">
        <a href="{{ route('global-configurations.web_content') }}" class="list-group-item list-group-item-action">Contenido Web Abbaster</a>

        <a href="{{ route('global-configurations.statuses_po') }}" class="list-group-item list-group-item-action">Statuses Purchase Order</a>


        <a href="{{ route('global-configurations.shops') }}" class="list-group-item list-group-item-action">Tiendas</a>

        <a href="{{ route('global-configurations.dollar_price') }}" class="list-group-item list-group-item-action">Precio Dollar</a>

      </div>

    </div>
  </div>
</div>
@endsection
