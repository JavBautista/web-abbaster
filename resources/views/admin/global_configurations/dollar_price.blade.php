@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'dollar_price'])
  <dollar-price></dollar-price>
@endsection
