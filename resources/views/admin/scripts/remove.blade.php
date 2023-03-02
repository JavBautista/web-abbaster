@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'scripts.remove'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center alert alert-{{$script->status?'warning':'success'}}">{{$script->status?'Inactivo':'Activo'}}</div>        	
            <form action="/scripts/update" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $script->id }}" name="script_id">
                             
              <div class="alert alert-danger">
                <p><h2>¿Realmente desea eliminar el script: {{ $script->title }}?</h2></p>
                <p>Esta accion borrara la informacion definitivament de la base de datos.</p>
              </div>
                           
              <button type="submit" class="btn btn-primary">Borrar</button>
            </form> 
        </div>
    </div>
</div>
@endsection
