@extends('layouts.app_customer')
@section('content')
@include('admin_customer.breadcrumb',['item'=>'purchases.index'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @forelse($purchases as $purchase)
                @php
                    $desc_status='';
                    foreach ($status as $val)
                        if($val->id == $purchase->status){
                            $desc_status= $val->status;
                            break;
                        }//.if
                    $link_tracking_number = ($purchase->tracking_number)?$purchase->tracking_number:'Add Tracking';
                @endphp
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Compra #{{$purchase->id}} <span class="small text-muted"><em>{{$purchase->created_at}}</em></span></h5>
                            <p class="small"><strong>Status:</strong>&nbsp;{{$desc_status}}</p>
                            <p class="small"><strong>Medio de pago:</strong>&nbsp;{{($purchase->payment_method == 'Guardado')?'NO DEFINIDO':$purchase->payment_method}}</p>
                            <p class="small"><strong>Total:</strong>&nbsp;MXN ${{ number_format($purchase->total,2)}}</p>
                            <hr>
                            <h5>Destino</h5>
                            <dl class="row small">
                              <dt class="col-sm-4">Recibe</dt>
                              <dd class="col-sm-8">{{ $purchase->name }}</dd>

                              <dt class="col-sm-4">Mail</dt>
                              <dd class="col-sm-8">{{ $purchase->mail }}</dd>

                              <dt class="col-sm-4">Tel.</dt>
                              <dd class="col-sm-8">{{ $purchase->movil }}</dd>

                              <dt class="col-sm-4">Dirección</dt>
                              <dd class="col-sm-8">{{ $purchase->address }} {{ $purchase->number_out }} {{ $purchase->number_int }}</dd>

                              <dt class="col-sm-4">&nbsp;</dt>
                              <dd class="col-sm-8">{{ $purchase->zip_code }} {{ $purchase->state }}, {{ $purchase->city }} </dd>

                              <dt class="col-sm-4">Referencia</dt>
                              <dd class="col-sm-8">{{ $purchase->reference }}</dd>
                            </dl>
                            <a href="{{ route('customer.purchase.view',['purchase_id'=>$purchase->id])}}" class="btn btn-success btn-block">Ver Compra</a>
                        </div>

                        <div class="col-md-6">
                            @foreach($purchase->PurchaseDetail as $product)

                            <div class="row">
                                <div class="col-3">
                                  @if(isset($product->product->image))
                                    <img src="{{$product->product->image }}" alt="{{$product->key }}" class="img-thumbnail" width="50px">
                                  @endif
                                </div>
                                <div class="col-9">
                                    <p class="small">{{$product->name }}</p>
                                    <p class="small">MXN ${{ number_format($product->price,2) }}&nbsp;<span class="text-muted"> Qty {{$product->qty }}</span></p>
                                </div>
                            </div>

                            <hr>
                            @endforeach
                        </div>

                    </div>

                  </div>
                </div>
            @empty
                <h3>Sin Datos que mostrar</h3>
            @endforelse

        </div>
    </div>
</div>
@endsection
