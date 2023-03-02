@extends('layouts.app')
@section('content')
@include('admin.cedis.breadcrumb',['item'=>'warehouse.index'])
<div class="container">
    @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif
    <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Almacenes
                <a class="btn btn-info" href="{{ route('cedis.warehouse.create') }}"> <i class="fa fa-plus"></i> Nuevo</a>
            </div>
            <div class="card-body">
                <!------------------------------------------------------------------------------------------------------>
                @forelse($warehouses as $warehouse)
                    <warehouse-component :warehouse_id="{{$warehouse->id}}"></warehouse-component>
                @empty
                    Sin Datos que mostrar
                @endforelse

                <!------------------------------------------------------------------------------------------------------>
            </div><!--./card-body-->
        </div><!--./card-->

</div><!--./container-fluid-->
@endsection
