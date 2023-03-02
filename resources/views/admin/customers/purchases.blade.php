@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.customers.purchases'])
<div class="container">
    <div class="mt-2 mb-2">
      <strong><em>Total de Registros: {{ $count_purchases }}</em></strong>
    </div>
    <div class="row justify-content-center">
        
        @forelse($purchases as $purchase)
            @php
                $desc_status='';
                foreach ($status as $val)
                    if($val->id == $purchase->status){
                        $desc_status= $val->status;
                        break;
                    }//.if
            @endphp
            <div class="card">
              <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Compra #{{$purchase->id}} <span class="small text-muted">{{$purchase->created_at}}</span></h5>
                        <p><strong>Status:</strong>&nbsp;{{$desc_status}}</p>
                        <p><strong>Pago:</strong>&nbsp;{{$purchase->payment_method}}</p>
                        <p><strong>Total:</strong>&nbsp;${{$purchase->total}}</p>

                        
                    
                        <!--<a class="btn btn-outline-info" href="{ { route('dashboard.store.purchases.view',['shop_id'=> $shop->id,'purchase_id'=> $purchase->id]) }}"><span class="fa fa-eye"></span>&nbsp;Ver
                        </a>-->
                    </div>
                    <div class="col-md-3">
                        <h5>Comprador</h5>
                        @if(isset($purchase->customer))
                            <p>{{ $purchase->customer->name }}</p>
                            <p>{{ $purchase->customer->mail }}</p>
                            <p>{{ $purchase->customer->movil }}</p>
                            <p>{{ $purchase->customer->state }}</p>
                        @else
                            <p><em class="text-danger">(Los datos del comprador no fueron encontrados)</em></p>
                        @endif                                
                    </div>
                    <div class="col-md-5">
                        @foreach($purchase->PurchaseDetail as $product)
                            @if( isset($product->product->image))
                                <p class="small"><img src="{{$product->product->image }}" alt="{{$product->key }}" class="img-thumbnail" width="50px">
                                &nbsp; {{$product->name }}
                            @else
                                <p class="small">{{$product->name }}</p>
                            @endif 
                            <p class="small">${{$product->price }}&nbsp;<span class="text-muted"> Qty {{$product->qty }}</span></p>
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
@endsection
