@extends('layouts.app_dashboard')
@section('content')
<main class="main">
  <div class="container">
    @include('admin.breadcrumb',['item'=>'store.services.index'])
    <admin-services :shop_id="{{$shop_id}}"></admin-services>
  </div><!--./container-->
</main>
@endsection