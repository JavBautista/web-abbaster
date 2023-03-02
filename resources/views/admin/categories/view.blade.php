@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Store: {{ $category->shop->name }}</h2>
            <hr>
            <dl class="row">
              <dt class="col-sm-3">Name</dt>
              <dd class="col-sm-9">{{ $category->name }}</dd>

              <dt class="col-sm-3">Description</dt>
              <dd class="col-sm-9">{{ $category->description }}</dd>

              <dt class="col-sm-3">Root</dt>
              @if($category->root==0)
                <dd class="col-sm-9">Categoria Padre</dd>
              @else
                <dd class="col-sm-9">{{ $root_category->name }}</dd>
              @endif
            </dl>
            <img src="{{ $category->image }}" class="rounded mx-auto d-block" alt="...">

        </div>
    </div>
</div>
@endsection
