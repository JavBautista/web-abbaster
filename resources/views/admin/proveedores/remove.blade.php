@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.proveedores.edit.remove'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Store: {{ $shop->name }}</h2>
            <h3>Edit Delete Proveedor {{ $proveedor->name }}</h3>
            <hr>
            <form action="{{ url('/proveedores/delete') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $proveedor->id }}" name="proveedor_id">
              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
              
              <div class="alert alert-danger">
                <p><h2>¿Realmente desea eliminar este proveedor?</h2></p>
                <p>Esta accion borrara la informacion definitivament de la base de datos.</p>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
