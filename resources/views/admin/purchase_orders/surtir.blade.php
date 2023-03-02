@extends('layouts.app')
@section('content')
@include('admin.purchase_orders.breadcrumb',['item'=>'surtir'])
<div class="container-fluid">
  @if(Session::has('alert'))
    <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
  @endif
	<admin-po-products-surtir :purchase_order="{{$purchase_order->id}}"></admin-po-products-surtir>
</div>
@endsection
