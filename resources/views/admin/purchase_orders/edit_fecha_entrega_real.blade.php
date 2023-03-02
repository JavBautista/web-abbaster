
@extends('layouts.app')
@section('content')
@include('admin.purchase_orders.breadcrumb',['item'=>'edit-fecha-entrega-real'])
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-10">        	
      
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <h2>Editar Fecha Entrega Real : Orden de compra</h2>
      <div class="row">
        <div class="col-2">
           @include('admin.purchase_orders.menu')
        </div>
        <div class="col-10">
        	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae saepe similique tempora temporibus ducimus sunt cupiditate expedita molestiae laboriosam rerum. Ab illum perspiciatis debitis deleniti adipisci earum, reprehenderit optio rerum.
        </div>

      </div>
  

    </div>
  </div>
</div>
@endsection

