@extends('layouts.app_dashboard')
@section('content')
 <main class="main">
    <directorio-clientes-shop :shop_id="{{$shop->id}}"></directorio-clientes-shop>
  </main>
@endsection
