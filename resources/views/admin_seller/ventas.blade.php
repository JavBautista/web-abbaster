@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard/">Vendedores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ventas</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <h2>Bienvenido {{ $user->vendedor->name  }}</h2>
    
            <ul class="list-group">
                @forelse($user->vendedor->discountCodes as $discount_code)                    
                    <li class="list-group-item"> <strong>{{ $discount_code->code }}</strong> - {{ $discount_code->type_discount=='monto'?'$':'%' }} {{ $discount_code->discount }} </li> 
                @empty
                    <li class="list-group-item">Sin Codigos Asignados</li> 
                @endforelse
            </ul>

            <hr>

            @forelse($sales as $sale)
                @php
                    $desc_status='';
                    foreach ($status as $val)
                        if($val->id == $sale->status){
                            $desc_status= $val->status;
                            break;
                        }//.if                  
                @endphp
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Compra #{{$sale->id}} <span class="small text-muted">{{$sale->created_at}}</span></h5>
                            <p><strong>Status:</strong>&nbsp;{{$desc_status}}</p>
                            <p><strong>Pago:</strong>&nbsp;{{$sale->payment_method}}</p>
                            <p><strong>Total:</strong>&nbsp;${{$sale->total}}</p>                           
                        </div>
                        <div class="col-md-3">
                            <h5>Comprador</h5>
                            <p>{{ $sale->Customer->name }}</p>
                            <p>{{ $sale->Customer->mail }}</p>
                            <p>{{ $sale->Customer->movil }}</p>
                            <p>{{ $sale->Customer->state }}</p>                                
                        </div>
                        <div class="col-md-5">
                            @foreach($sale->PurchaseDetail as $product)

                                <p><!--<img src="{ {$product->product->image }}" alt="{ {$product->key }}" class="img-thumbnail" width="50px">
                                &nbsp;-->{{$product->name }}</p>
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
</div>
@endsection
