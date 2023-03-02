@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'discount_codes.remove'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center alert alert-{{$discount_code->status?'warning':'success'}}">{{$discount_code->status?'Inactivo':'Activo'}}</div>        	
            <form action="/discount-code/delete" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $discount_code->id }}" name="discount_code_id">
                             
              <div class="alert alert-danger">
                <p><h2>¿Realmente desea eliminar el Codigo de Descuento: {{ $discount_code->code }}?</h2></p>
                <p>Esta accion borrara la informacion definitivament de la base de datos.</p>
              </div>
                           
              <button type="submit" class="btn btn-primary">Borrar</button>
            </form> 
        </div>
    </div>
</div>
@endsection
