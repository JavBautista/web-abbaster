@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.proveedores.add'])

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Nuevo Proveedor</h2>
            <form action="/proveedores/create" method="post" enctype="multipart/form-data"> 
              {{ csrf_field() }} 

              <input type="hidden" value="{{ $shop->id }}" name="shop_id">

              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" aria-describedby="nameStorelHelp" placeholder="Enter Name">
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese nombre del proveedor.</small>
                @if($errors->has('name'))
                  @foreach($errors->get('name') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description">
              </div>

              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
              </div>

              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter E-Mail">
              </div>

              <div class="form-group">
                <label for="commentary">Commentary</label>
                <textarea class="form-control" id="commentary" name="commentary" rows="3"></textarea>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0'>Active</option>
                  <option value='1'>Inactive</option>
                </select>
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddonImage">Imagen</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="inputGroupFileAddonImage">
                  <label class="custom-file-label" for="image">Choose file</label>
                </div>
              </div>

            
              
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
