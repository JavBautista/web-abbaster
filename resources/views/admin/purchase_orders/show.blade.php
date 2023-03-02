@extends('layouts.app')
@section('content')
@include('admin.purchase_orders.breadcrumb',['item'=>'show'])
<div class="container-fluid">
  @if(Session::has('alert'))
    <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
  @endif

  @if($purchase_order->estatus == 'creado')
  <a class="btn btn-warning mb-2"  href="{{ route('purchase-orders.edit',['purchase_order_id'=>$purchase_order->id]) }}"> <span class="fa fa-edit"></span> Editar orden de Compra</a>
  @elseif($purchase_order->estatus == 'surtir')
  <a class="btn btn-info mb-2"  href="{{ route('purchase-orders.surtir',['purchase_order_id'=>$purchase_order->id]) }}"> <span class="fa fa-edit"></span> Surtir</a>
  @endif
  <div class="card">
    <div class="card-body">
      <div class="row">

        <div class="col-6 col-md-4">
          <dl class="row">
                <dt class="col-sm-4">Estatus</dt>
                <dd class="col-sm-8"> {{ $purchase_order->estatus }}</dd>

                <dt class="col-sm-4">Proveedor</dt>
                <dd class="col-sm-8"> {{ $purchase_order->proveedor }}</dd>

                <dt class="col-sm-4">Folio Proveedor</dt>
                <dd class="col-sm-8"> {{ $purchase_order->folio_proveedor }}</dd>

                <dt class="col-sm-4">Precio Dolar</dt>
                <dd class="col-sm-8"> {{ $purchase_order->precio_dolar }}</dd>

          </dl>
        </div>

        <div class="col-6 col-md-4">
          <dl class="row">
                <dt class="col-sm-4">Entrega Estimada</dt>
                <dd class="col-sm-8"> {{ $purchase_order->fecha_entrega_estimada }}</dd>

                <dt class="col-sm-4">Entrega Real</dt>
                <dd class="col-sm-8"> {{ $purchase_order->fecha_entrega_real }}</dd>
                <dt class="col-sm-4">Total</dt>
                <dd class="col-sm-8"> {{ $purchase_order->monto_total }}</dd>
                <dt class="col-sm-4">Documento Adjunto</dt>
                <dd class="col-sm-8">{{ $purchase_order->documento_adjunto }}</dd>
          </dl>
        </div>


      <div class="col-6 col-md-4">
          <dl class="row">
                <dt class="col-sm-4">Observaciones</dt>
                <dd class="col-sm-8"> {{ $purchase_order->observaciones }}</dd>
                <dt class="col-sm-4">Creó</dt>
                <dd class="col-sm-8"> {{ $purchase_order->user_created }}</dd>
                <dt class="col-sm-4">Creación</dt>
                <dd class="col-sm-8"> {{ $purchase_order->created_at }}</dd>

          </dl>
        </div>

      </div>
    </div><!--.card-body-->
  </div><!--.card-->


  <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Producto</th>
                            <th>Qty</th>
                            <th>Cost</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase_order_detail as $articulo)
                        <tr>
                            <td>{{ $articulo->product }}</td>
                            <td>{{ $articulo->qty }}</td>
                            <td>{{ $articulo->cost }}</td>
                            <td>{{ $articulo->status }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>

</div>
@endsection
