@extends('layouts.app')
@section('content')
@include('admin.cedis.breadcrumb',['item'=>'operation.recepcion.index'])
<div class="container">
    @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif

	<operation-recepcion></operation-recepcion>

</div><!--./container-fluid-->
@endsection
