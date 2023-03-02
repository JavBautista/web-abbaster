@extends('layouts.app_customer')
@section('content')
<div class="container-fluid">
@include('admin_customer.breadcrumb',['item'=>'messages.index'])
	<customer-messages :user_id="{{$user_id}}"></customer-messages>
</div>
@endsection
