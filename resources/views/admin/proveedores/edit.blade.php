@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.proveedores.edit'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Store: {{ $shop->name }}</h2>
            <h3>Edit Proveedor {{ $proveedor->name }}</h3>
            <hr>
            <form action="{{ url('/proveedores/update') }}" method="post">
              {{ csrf_field() }} 

              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
              <input type="hidden" value="{{ $proveedor->id }}" name="proveedor_id">

              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" aria-describedby="nameStorelHelp" placeholder="Enter Name" value="{{ $proveedor->name}}">
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese nombre del proveedor.</small>
                @if($errors->has('name'))
                  @foreach($errors->get('name') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ $proveedor->description}}">
              </div>

              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="{{ $proveedor->address}}">
              </div>

              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ $proveedor->phone}}">
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter E-Mail" value="{{ $proveedor->email}}">
              </div>

              <div class="form-group">
                <label for="commentary">Commentary</label>
                <textarea class="form-control" id="commentary" name="commentary" rows="3">{{ $proveedor->commentary }}</textarea>
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
