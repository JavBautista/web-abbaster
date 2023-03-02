@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'web_content.caroulsel.remove'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="{{ route('global.web.carousel.delete') }}" method="post">
              @csrf 
              <input type="hidden" value="{{ $item->id }}" name="item_id">                             
              <div class="text-center alert alert-danger">
                <h3> <i class="fa fa-exclamation-circle"></i> ¿Realmente desea eliminar el item del carousel ?</h3>
                <h4>Esta accion borrara la informacion definitamente de la base de datos.</h4>
                <img src="{{ $item->getImageStore($item->image) }}" alt="{{ $item->title }}" width="25%" class="img img-thumbnail">
                <h5 class="card-title">{{ $item->title }}</h5>
                <p class="card-text">{{ $item->content }}</p>
              </div>
                           
              <button type="submit" class="btn btn-danger">Borrar</button>
            </form> 
        </div>
    </div>
</div>
@endsection
