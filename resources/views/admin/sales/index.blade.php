@extends('layouts.app_dashboard')
@section('content')
<main class="main">
@include('admin.breadcrumb',['item'=>'store.sales.index'])
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <form class="form" method="POST" action="/sales/select-filter-search">
                {{ csrf_field() }}
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="filter_status">Esattus</label>
                      <select class="form-control" id="filter_status" name="filter_status">>
                        <option value="0">TODOS</option>
                        @foreach($status as $data)
                            <option value="{{$data->id}}" {{ ($sales_filter_status==$data->id)?'selected':'' }}>{{$data->status}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="filtro">Filtro</label>
                      <select id="filtro" name="filtro" class="form-control">
                        <option value="ninguno" {{ $sales_filter_filtro=='ninguno'?'selected':'' }}>Ninguno</option>
                        <option value="cliente" {{ $sales_filter_filtro=='cliente'?'selected':'' }}>Cliente</option>
                        <option value="compra"  {{ $sales_filter_filtro=='compra'?'selected':''  }}>No. Compra</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="buscar">Buscar</label>
                      <input type="text" class="form-control" id="buscar" name="buscar" value="{{$sales_filter_buscar}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-lg btn-primary"> <i class="fa fa-search"></i> Filtrar</button>
            </form>

        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(Session::has('alert'))
                <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
            @endif

            <div class="mt-2 mb-2"><strong><em>Total de Registros: {{ $count_sales }}</em></strong></div>

            @forelse($sales as $sale)
                @php
                    $desc_status='';
                    foreach ($status as $val)
                        if($val->id == $sale->status){
                            $desc_status= $val->status;
                            break;
                        }//.if
                    $link_tracking_number = ($sale->tracking_number)?$sale->tracking_number:'Add Tracking';
                @endphp
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Compra #{{$sale->id}}</h5><span class="small text-muted">{{$sale->created_at}}</span>
                            <p><strong>Status:</strong>&nbsp;{{$desc_status}}</p>
                            <p><strong>Pago:</strong>&nbsp;{{$sale->payment_method}}</p>
                            <p><strong>#OP.EXT:</strong>&nbsp;{{$sale->no_transaction}}</p>
                            
                            <p><strong>Total:</strong>&nbsp;${{$sale->total}}</p>
                            <a class="btn btn-sm btn-info" href="{{ route('dashboard.store.sales.view',['shop_id'=> $shop->id,'sale_id'=> $sale->id]) }}"><span class="fa fa-eye"></span>
                            </a>
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('dashboard.store.sales.chat',['shop_id'=> $shop->id,'sale_id'=> $sale->id]) }}"><span class="fa fa-comments "></span>
                            </a>
                            <hr>
                            @if($sale->status==13 || $sale->status==14)
                            <a class="btn btn-sm btn-warning" href="{{ route('dashboard.store.sales.edit',['shop_id'=> $shop->id,'sale_id'=> $sale->id]) }}">Modificar
                            </a>
                            @else
                            <a class="btn btn-sm btn-primary" href="{{ route('dashboard.store.sales.edit.tracking',['shop_id'=> $shop->id,'sale_id'=> $sale->id]) }}">
                                {{ $link_tracking_number }}
                            </a>
                            @endif
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.store.sales.edit.status',['shop_id'=> $shop->id,'sale_id'=> $sale->id]) }}"><span class="fa fa-edit"></span>&nbsp;Estatus
                            </a>


                        </div>
                        <div class="col-md-3">
                            <h5>Comprador</h5>
                            @if(isset($sale->customer))
                                <p>{{ $sale->customer->name }}</p>
                                <p>{{ $sale->customer->mail }}</p>
                                <p>{{ $sale->customer->movil }}</p>
                                <p>{{ $sale->customer->state }}</p>
                            @else
                                <p><em class="text-danger">(Los datos del comprador no fueron encontrados)</em></p>
                            @endif
                        </div>
                        <div class="col-md-5">
                            @foreach($sale->PurchaseDetail as $product)
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
            {{ $sales->links() }}
        </div>
    </div>
</div>
</main>
@endsection
