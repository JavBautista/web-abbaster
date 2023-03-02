@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Store: {{ $category->shop->name }}</h2>
            <h3>Edit Categorie {{ $category->name }}</h3>
            <hr>
            <form action="{{ url('/categories/update') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $category->id }}" name="category_id">
              <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" aria-describedby="nameStorelHelp" placeholder="Enter Category Name" value="{{ $category->name }}">
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese nombre de la categoria.</small>
                @if($errors->has('name'))
                  @foreach($errors->get('name') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="description">Description Name</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Category Description" value="{{ $category->description }}">
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0' @if($category->status==0) selected @endif >Active</option>
                  <option value='1' @if($category->status==1) selected'@endif >Inactive</option>
                </select>
              </div>

              <div class="form-group">
                <label for="root">Raiz</label>
                <select class="form-control" id="root" name="root">
                  <option value='0'>Raiz</option>
                  @foreach($categories as $select_category)                                      
                        <option value="{{ $select_category->id }}" @if($category->root==$select_category->id ) selected @endif>{{ $select_category->name }}</option>
                  @endforeach
                </select>
              </div>
              
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
