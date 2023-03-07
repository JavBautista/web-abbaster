@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.categories.add'])

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Nueva Cetgoria</h2>
            <form action="{{ route('categories.create',['shop_id'=>$shop->id]) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }} 
              <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" aria-describedby="nameStorelHelp" placeholder="Enter Category Name">
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese nombre de la categoria.</small>
                @if($errors->has('name'))
                  @foreach($errors->get('name') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="description">Description Name</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Category Description">
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0'>Active</option>
                  <option value='1'>Inactive</option>
                </select>
              </div>

              <div class="form-group">
                <label for="root">Raiz</label>
                <select class="form-control" id="root" name="root">
                  <option value='0'>Raiz</option>
                  @foreach($categories as $category)                                      
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
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
