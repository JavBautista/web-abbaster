@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.inventories.index'])
<div class="container-fluid">
    <h2>Inventories</h2>
    @include('admin.products.info_product')
    <div class="row">
      <div class="col">    
        <p><a href="{{ route('products.inventories.add',['shop_id'=>$shop->id,'product_id'=>$product->id]) }}" class="btn btn-outline-primary float-right mb-2">Nuevo Registro</a></p>
        <p><h3>Stock Total: {{ $stock_total }}</h3></p>            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Created</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Exhibition</th>
                        <th>Defective</th>                        
                        <th>Lost</th>                       
                        <th>Sale</th>                       
                        <th>Total</th>
                        <th>&nbsp;</th>                       
                    </tr>
                </thead>
                <tbody>
                  @forelse($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->id }}</td>
                        <td>{{ $inventory->created_at }}</td>
                        <td>{{ $inventory->description }}</td>
                        <td>{{ $inventory->stock }}</td>                     
                        <td>{{ $inventory->exhibition }}</td>                     
                        <td>{{ $inventory->defective }}</td>                        
                        <td>{{ $inventory->lost }}</td>                        
                        <td>{{ $inventory->sale }}</td>                        
                        <td>{{ $inventory->total }}</td>
                        <td>[<a href="{{ route('products.inventories.edit',['shop_id'=>$shop->id,'product_id'=>$product->id,'inventory_id'=>$inventory->id]) }}">Editar Inventario</a>]</td>                        
                    </tr>
                @empty
                    <tr><td colspan="8">Sin Datos que mostrar</td></tr>
                @endforelse
                </tbody>
            </table>
      </div>     
    </div>

</div>
@endsection
