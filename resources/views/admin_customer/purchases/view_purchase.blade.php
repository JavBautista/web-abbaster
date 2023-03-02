@extends('layouts.app_customer')
@section('content')
@include('admin_customer.breadcrumb',['item'=>'purchases.view'])
<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card mb-2">
                <div class="card-body">
                    <div class="alert alert-info text-center">
                        <h4>Compra #{{ $purchase->id }} - Estatus: {{ $sale_status }}</h4>
                    </div>
                    <div class="row">
                        <div class="col">
                            <dl class="row">
                                <dt class="col-sm-3"> Metodo de pago</dt>
                                <dd class="col-sm-9">{{ $purchase->payment_method }}</dd>

                                <dt class="col-sm-3"> Tracking</dt>
                                <dd class="col-sm-9">{{ $purchase->tracking_number }}</dd>

                                <dt class="col-sm-3"> Creación</dt>
                                <dd class="col-sm-9">{{ $purchase->created_at }}</dd>

                                <dt class="col-sm-3"> Observaciones</dt>
                                <dd class="col-sm-9">{{ $purchase->observations }}</dd>
                            </dl>
                        </div>
                    </div>
                </div><!--./card-body-->
            </div><!--./card-->
            <!--Row Contenido Compra-->
            <div class="row">
                    <div class="col-md-6">
                     <div class="card">
                         <div class="card-body">

                            <h5>Detalle</h5>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Qty</th>
                                        <th>Costo</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->PurchaseDetail; as $row)
                                        @php
                                            $sub=$row->price * $row->qty;
                                        @endphp
                                        <tr>
                                            <td class="small">
                                                @if(isset($row->product->image))
                                                    <img src="{{$row->product->image }}" alt="{{$row->key }}" class="img-thumbnail" width="50px">
                                                @endif
                                                <p><strong>{{$row->name}}</strong></p></td>
                                            <td class="small">{{$row->qty}}</td>
                                            <td class="small">${{ number_format($row->price,2)}}</td>
                                            <td class="small">${{ number_format($sub,2)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="3"><strong>Subtotal</strong></td>
                                        <td><strong><em>${{ $purchase->subtotal }}</em></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3"><strong>Envio</strong></td>
                                        <td><strong><em>${{ $purchase->shipping }}</em></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3"><strong>Descuento</strong></td>
                                        <td><strong><em>-${{ $purchase->discount }}</em></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right" >
                                            <h4><strong> TOTAL MXN ${{ number_format($purchase->total,2) }} </strong></h4>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                         </div>
                     </div>
                    </div><!--./col-6-->

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <h5>Datos de la compra</h5>
                                <dl class="row small">
                                    <dt class="col-sm-4"> Email</dt>
                                    <dd class="col-sm-8">{{ $customer->mail }}</dd>

                                    <dt class="col-sm-4"> Quien recibe</dt>
                                    <dd class="col-sm-8">{{ $purchase->name }}</dd>

                                    <dt class="col-sm-4"> Teléfono</dt>
                                    <dd class="col-sm-8">{{ $purchase->phone }}</dd>

                                    <dt class="col-sm-4"> Móvil</dt>
                                    <dd class="col-sm-8">{{ $purchase->movil }}</dd>



                                    <dt class="col-sm-4"> Dirección</dt>
                                    <dd class="col-sm-8">{{ $purchase->address }} {{ $purchase->number_out }} {{ $purchase->number_int }} {{ $purchase->district }}<br> {{ $purchase->zip_code }} <br> {{ $purchase->city }} {{ $purchase->state }}</dd>


                                    <dt class="col-sm-4"> Referencia</dt>
                                    <dd class="col-sm-8">{{ $purchase->reference }}</dd>

                                    <dt class="col-sm-4"> Detalles</dt>
                                    <dd class="col-sm-8">{{ $purchase->detail }}</dd>
                                </dl>
                            </div>
                        </div>

                        @if($purchase->status==14)
                            <a href="{{ route('customer.reload.shoppincart',['purchase_id'=>$purchase->id])}}" class="btn btn-success btn-block">Finalizar!</a>
                        @endif
                    </div><!--./col-6-->
            </div><!--./Row Contenido Compra-->
        </div><!--./col-md-10-->

    </div><!--./row justify-content-center-->
</div><!--./container-->
@endsection
