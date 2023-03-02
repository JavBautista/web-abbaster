@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.add'])

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Nuevo Producto</h2>
            <form action="/products/create" method="post" enctype="multipart/form-data">
              {{ csrf_field() }} 

              <input type="hidden" value="{{ $shop->id }}" name="shop_id">

              <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select class="form-control" id="proveedor" name="proveedor">
                  @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id}}">{{ $proveedor->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="category">Categoy</label>
                <select class="form-control" id="category" name="category">
                   @foreach($categories as $category)
                    <option value="{{ $category->id}}" @if($category->id==$category_id) selected @endif>{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>


              <div class="form-group">
                <label for="key">Key</label>
                <input type="text" class="form-control @if($errors->has('key')) is-invalid @endif" id="key" name="key" aria-describedby="nameStorelHelp" placeholder="Enter Name">
                <small id="nameStorelHelp" class="form-text text-muted">Key</small>
                @if($errors->has('key'))
                  @foreach($errors->get('key') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="barcode">Barcode</label>
                <input type="text" class="form-control @if($errors->has('barcode')) is-invalid @endif" id="barcode" name="barcode" aria-describedby="nameStorelHelp" placeholder="Enter Barcode">
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese nombre.</small>
                @if($errors->has('barcode'))
                  @foreach($errors->get('barcode') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" aria-describedby="nameStorelHelp" placeholder="Enter Name">
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese nombre.</small>
                @if($errors->has('name'))
                  @foreach($errors->get('name') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
              </div>

              <div class="form-group">
                <label for="cost">Cost</label>
                <input type="number" min="0" step="1" class="form-control" id="cost" name="cost" placeholder="Enter Cost">
              </div>
              
              <div class="form-group">
                <label for="retail">Retail</label>
                <input type="number" min="0" step="1" class="form-control" id="retail" name="retail" placeholder="Enter Retail">
              </div>

              <div class="form-group">
                <label for="wholesale">Wholesale</label>
                <input type="number" min="0" step="1" class="form-control" id="wholesale" name="wholesale" placeholder="Enter Wholesale">
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0'>Active</option>
                  <option value='1'>Inactive</option>
                </select>
              </div>

              <div class="form-group">
                <label for="url_video">Url Video</label>
                <input type="text" class="form-control @if($errors->has('url_video')) is-invalid @endif" id="url_video" name="url_video"placeholder="Enter URL Video">
                @if($errors->has('url_video'))
                  @foreach($errors->get('url_video') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>
              
              <!--
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddonImage">Imagen</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="inputGroupFileAddonImage">
                  <label class="custom-file-label" for="image">Choose file</label>
                </div>
              </div>
            -->
              
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
