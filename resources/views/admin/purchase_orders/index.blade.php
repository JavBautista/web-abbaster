@extends('layouts.app')
@section('content')
@include('admin.purchase_orders.breadcrumb',['item'=>'index'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif

      <a href="{{ route('purchase-orders.create') }}" class="mb-2 btn btn-primary"><i class="fa fa-plus"></i> Orden de Compra</a>


      @forelse($purchase_orders as $purchase_order)
        <div class="card" style="margin-bottom: 0 !important;">
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <h5>No. {{ $purchase_order->id }} <span class="badge badge-info">{{ $purchase_order->estatus }}</span> </h5>
                <dl class="row">
                  <dt class="col-sm-4">Folio Ext</dt>
                  <dd class="col-sm-8">{{ $purchase_order->folio_proveedor }}</dd>
                  <dt class="col-sm-4">Description</dt>
                  <dd class="col-sm-8">{{ $purchase_order->proveedor }}</dd>
                </dl>
                <a href="{{ route('purchase-orders.show',['purchase_order_id'=>$purchase_order->id ]) }}" class="btn btn-success">Ver detalle</a>
              </div>
              <div class="col-6">
                <dl class="row">

                  <dt class="col-sm-4">Entrega Estimada</dt>
                  <dd class="col-sm-8">{{ $purchase_order->fecha_entrega_estimada }}</dd>

                  <dt class="col-sm-4">Creación</dt>
                  <dd class="col-sm-8">{{ $purchase_order->created_at }}</dd>

                  <dt class="col-sm-4">Creó</dt>
                  <dd class="col-sm-8">{{ $purchase_order->user_created }}</dd>
                </dl>


              </div>
            </div>
          </div>
        </div>

      @empty
          <tr><dd colspan="5">Sin Datos que mostrar</dd></tr>
      @endforelse


    </div>
  </div>
</div>
@endsection
