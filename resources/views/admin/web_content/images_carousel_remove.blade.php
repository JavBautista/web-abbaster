@extends('layouts.app_dashboard')
@section('content')
<div class="main">
    @include('admin.web_content.breadcrumb',['item'=>'images_carousel_remove'])
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <form action="/web_content/images-carousel-delete" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{ $item->id }}" name="item_id">
                  <div class="text-center alert alert-danger">
                    <p><h2>¿Realmente desea eliminar el item del carousel ?</h2></p>
                    <p>Esta accion borrara la informacion definitamente de la base de datos.</p>
                    <img src="{{ $item->getImageStore($item->image) }}" alt="{{ $item->title }}" width="25%" class="img img-thumbnail">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text">{{ $item->content }}</p>
                    <p class="card-text muted">Align: {{ $item->align }}</p>
                  </div>

                  <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
