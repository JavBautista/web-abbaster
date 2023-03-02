@extends('layouts.app_dashboard')
@section('content')
<main class="main">
@include('admin.breadcrumb',['item'=>'store.products.index'])
<div class="container">
    @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif

    <div class="row">
        <div class="col">
            <form method="POST" action="/products/select_category">
            @csrf
                <input type="hidden" name="shop_id" value="{{ $shop_id }}">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="category">Categoría</label>
                  </div>
                  <select class="custom-select" id="category" name="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id}}" @if($category->id==$category_id) selected @endif >{{ $category->name }}</option>
                    @endforeach
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Seleccionar</button>
                  </div>
                </div>
            </form>

        </div>
    </div>
    @if($category_id)
            <nav class="nav navbar-expand-lg navbar-light bg-primary" >
                 <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('products.slugs',['shop_id'=>$shop_id]) }}">Slugs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('products.order_by',['shop_id'=>$shop_id]) }}">Orden</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('products.barcodes',['shop_id'=>$shop_id]) }}">Codigos de Barra</a>
                    </li>
                 </ul>
            </nav>
            <admin-products :shop_id="{{$shop_id}}" :category_id="{{$category_id}}"></admin-products>
    @else
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info text-center mt-4">
                    <h2>Seleccione Categoria</h2>
                </div>
            </div>
        </div>
    @endif
</div><!--./container-fluid-->
</main>
@endsection
