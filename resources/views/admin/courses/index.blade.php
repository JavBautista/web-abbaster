@extends('layouts.app_dashboard')
@section('content')
<main class="main">
  <div class="container">
    @include('admin.breadcrumb',['item'=>'store.courses.index'])
    <admin-courses :shop_id="{{$shop_id}}"></admin-courses>
  </div><!--./container-->
</main>
@endsection
