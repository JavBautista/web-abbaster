@extends('layouts.app_dashboard')
@section('content')
<main class="main">
    @include('admin.web_content.breadcrumb',['item'=>'images_carousel_index'])
    <div class="container-fluid">
        @if(Session::has('alert'))
          <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-10">
            	<p><a href="{{ route('dashboard.store.web.images_carousel.add',['shop_id'=>$shop->id]) }}" class="btn btn-primary mb-2">Agregar Nueva Imagen</a></p>

                <div class="row">
                @forelse($carousel as $reg)
                    <div class="col-md-4">
                      <div class="card mb-4 shadow-sm">
                        <img class="card-img-top" src="{{ $reg->getImageStore( $reg->image) }}" width="100px" alt="{{ $reg->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $reg->title }}</h5>
                            <p class="card-text">{{ $reg->content }}</p>
                            @if($reg->url)
                             <p class="card-text text-small text-muted">URL {{ $reg->url }}</p>
                            @endif
                            <p class="card-text muted">Align: {{ $reg->align }}</p>
                            <div class="row">
                                <div class="col-6">
                                    <form class="" action="{{route('images-carousel.update-order')}}" method="post">
                                      @csrf
                                      <input type="hidden" value="{{ $reg->id }}" name="img_id">
                                      <input type="hidden" value="up" name="command">
                                      <button type="submit" class="btn btn-info btn-block">&lt;&lt;</button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <form class="" action="{{route('images-carousel.update-order')}}" method="post">
                                      @csrf
                                      <input type="hidden" value="{{ $reg->id }}" name="img_id">
                                      <input type="hidden" value="down" name="command">

                                      <button type="submit" class="btn btn-info btn-block">&gt;&gt;</button>
                                    </form>
                                </div>
                            </div>


                            <hr>
                            <a href="{{ route('dashboard.store.web.images_carousel.edit',['shop_id'=>$shop->id, 'item_id'=>$reg->id]) }}" class="btn btn-info">Editar</a>
                            <a href="{{ route('dashboard.store.web.images_carousel.remove',['shop_id'=>$shop->id, 'item_id'=>$reg->id]) }}" class="btn btn-danger">Borrar</a>
                        </div>
                      </div>
                    </div>

                @empty
                    <h2>Sin Datos que mostrar</h2>
                @endforelse

                </div>

            </div>
        </div>
    </div>
</main>
@endsection
