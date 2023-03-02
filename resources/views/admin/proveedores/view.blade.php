@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.proveedores.view'])
<div class="container-fluid">
    <div class="row">
      <div class="col"><h2>Store: {{ $shop->name }}</h2></div>
    </div>
    <div class="row">
        <div class="col col-md-6">
          <img src="{{ $proveedor->image }}" class="rounded mx-auto d-block" alt="...">
        </div>
        <div class="col col-md-6">    
            <dl class="row">
              <dt class="col-sm-3">Name</dt>
              <dd class="col-sm-9">{{ $proveedor->name }}</dd>

              <dt class="col-sm-3">Description</dt>
              <dd class="col-sm-9">{{ $proveedor->description }}</dd>

              <dt class="col-sm-3">Address</dt>
              <dd class="col-sm-9">{{ $proveedor->address }}</dd>

              <dt class="col-sm-3">Phone</dt>
              <dd class="col-sm-9">{{ $proveedor->phone }}</dd>
              
              <dt class="col-sm-3">Email</dt>
              <dd class="col-sm-9">{{ $proveedor->email }}</dd>

            </dl>
        </div>
    </div>
</div>
@endsection
