@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.cedis.breadcrumb',['item'=>'index'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      <h2>CEDIS</h2>
        <div class="list-group">
    			 <a href="{{ route('cedis.warehouse') }}" class="list-group-item list-group-item-action">Almacenes</a>
           <a href="{{ route('cedis.operation') }}" class="list-group-item list-group-item-action">Operacion</a>
        </div>
    </div>
  </div>
</div>
@endsection
