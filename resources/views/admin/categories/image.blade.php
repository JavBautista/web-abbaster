@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.categories.image'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">          
              <h2>Imagen de Catogoria</h2>
              <img src="{{ $category->image }}" alt="{{ $category->name }}" class="img img-thumbnail">

              <form action="/categories/update/main_image" method="post" enctype="multipart/form-data">
                  
                      {{ csrf_field() }}                      

                      <input type="hidden" name="category_id" value="{{ $category->id }}">
                      <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                      <div class="input-group mb-3">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="main_image" name="main_image" required>
                          <label class="custom-file-label" for="main_image" aria-describedby="inputGroupFileAddonMainImage">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <button type="submit" id="inputGroupFileAddonMainImage" class="input-group-text">Upload</button>
                        </div>
                      </div>

              </form>
            
           
                      
        </div>
    </div>
</div>
@endsection
