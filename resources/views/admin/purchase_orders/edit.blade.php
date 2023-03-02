@extends('layouts.app')
@section('content')
@include('admin.purchase_orders.breadcrumb',['item'=>'edit'])
<div class="container-fluid">
  @if(Session::has('alert'))
    <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
  @endif

<!--  <admin-po-detail :purchase_order="{ {$purchase_order->id }}"></admin-po-detail> -->
  <admin-po-products :purchase_order="{{$purchase_order->id }}"></admin-po-products>

</div>
@endsection
