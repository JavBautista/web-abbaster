@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.proveedores.edit.status'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Store: {{ $shop->name }}</h2>
            <h3>Edit Status Proveedor {{ $proveedor->name }}</h3>
            <hr>
            
            <form action="{{ url('/proveedores/update/status') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $proveedor->id }}" name="proveedor_id">
              
              <div class="alert alert-warning">
                <p><h2>¿Realmente dese cambiar el estatus del Proveedor?</h2></p>
                <p>Actve para ser visible; Inactive para no moastrarse al publico.</p>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0' @if($proveedor->status==0) selected @endif >Active</option>
                  <option value='1' @if($proveedor->status==1) selected'@endif >Inactive</option>
                </select>
              </div>              
              <button type="submit" class="btn btn-primary">Submit</button>
            
            </form>
        
        </div>
    </div>
</div>
@endsection
