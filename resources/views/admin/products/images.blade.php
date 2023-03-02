@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.images'])
<div class="container-fluid">
    @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-10">
          @include('admin.products.msg_estatus')
          <div class="row">
            <div class="col-4">

              <h3>Main Image</h3>
              <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img img-thumbnail">

              <form action="/products/update/main_image" method="post" enctype="multipart/form-data">
                  
                      {{ csrf_field() }}                      

                      <input type="hidden" name="product_id" value="{{ $product->id }}">
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
            <div class="col-8">
              <h3>Images del Producto</h3>

              <form action="/products/add/image" method="post" enctype="multipart/form-data">
                  
                      {{ csrf_field() }}                      

                      <input type="hidden" name="product_id" value="{{ $product->id }}">
                      <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                      <div class="input-group mb-3">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="image" name="image" required>
                          <label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddonMainImage">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <button type="submit" id="inputGroupFileAddonMainImage" class="input-group-text">Upload</button>
                        </div>
                      </div>

              </form>
              <hr>
              <div class="row">
              @forelse($product->images as $image)
                <div class="col-6">
                  <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{ $image->getStoreImage($image->image) }}" alt="Card image cap">
                    <div class="card-body">
                      <form action="/products/delete/image" method="post">
                        {{ csrf_field() }} 
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                      </form>
                    </div>
                  </div>                  
                </div>
              @empty
                  <p>Sin Images</p>
              @endforelse
              </div>


            </div>
          </div>            
                      
        </div>
    </div>
</div>
@endsection
