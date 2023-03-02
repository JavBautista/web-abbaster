@extends('layouts.app')
@section('content')
@include('admin.cedis.breadcrumb',['item'=>'operation.index'])
<div class="container">
    @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif

    <h2>OPERACIÓN</h2>
    <div class="list-group">
      <a href="{{ route('cedis.operation.recepcion') }}" class="list-group-item list-group-item-action">Recibir Mercancia</a>
    </div>

</div><!--./container-fluid-->
@endsection
