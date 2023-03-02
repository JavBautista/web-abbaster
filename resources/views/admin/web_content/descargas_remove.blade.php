@extends('layouts.app_dashboard')
@section('content')
<div class="main">
    @include('admin.web_content.breadcrumb',['item'=>'descargas.delete'])
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center alert alert-{{$document->status?'warning':'success'}}">{{$document->status?'Inactivo':'Activo'}}</div>
                <form action="/web_content/delete-file" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{ $document->id }}" name="document_id">

                  <div class="alert alert-danger">
                    <p><h2>¿Realmente desea eliminar el archivo: {{ $document->name }}?</h2></p>
                    <p>Esta accion borrara la informacion definitamente de la base de datos.</p>
                  </div>

                  <button type="submit" class="btn btn-primary">Borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
