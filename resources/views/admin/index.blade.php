@extends('layouts.app_main_dashboard')
@section('content')

<div class="container" style="margin-top:50px"></div>
<!-- @ include('admin.breadcrumb',['item'=>'index']) -->
<!-- Container Shops-->
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h2 class="mt-2">Tiendas</h2>
    <div class="row">
      @forelse($shops as $shop)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
              <!-- Badge Notificaciones -->
              <div class="row float">
                  <div class="col">
                      @if($notification_questions[$shop->id])
                      <span class="float-right badge badge-danger">
                          <span class="fa fa-bell fa-2x"></span>
                      </span>
                      @else
                          <span class="float-right text-white">
                            <span class="fa fa-check-circle fa-2x"></span>
                          </span>
                      @endif
                  </div>
              </div>
              <!--./ Badge Notificaciones-->

            @if($shop->logo)
              <img class="card-img-top" src="{{ $shop->getLogoStore($shop->logo) }}" alt="Logo {{ $shop->name  }}">
            @else
              @switch($shop->name )
                  @case('Eagletek MX')
                      <img class="card-img-top" src="{{ asset('assets/images/abbaster/eagletek_logo.png') }}" alt="Logo {{ $shop->name  }}">
                      @break
                  @case('ZiotRobotic')
                      <img class="card-img-top" src="{{ asset('assets/images/abbaster/ziotrobotik_logo.jpg') }}" alt="Logo {{ $shop->name  }}">
                      @break
                  @case('SOLARTEK MEXICO')
                      <img class="card-img-top" src="{{ asset('assets/images/abbaster/solartek_logo.png') }}" alt="Logo {{ $shop->name  }}">
                      @break

                  @default
                      <img class="card-img-top" src="{{ asset('assets/eagletek/no-image.png') }}" alt="Sin Imagen">
              @endswitch
            @endif

            <div class="card-body">
                <h5 class="card-title">{{ $shop->name }}</h5>
                <p class="card-text"><small class="text-muted">{{ $shop->created_at }}</small></p>
                <a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}" class="btn btn-block btn-primary">Entrar</a>
            </div>
          </div>
        </div>
      @empty
        <p>Sin Datos</p>
      @endforelse
    </div><!--./row-->
</div><!--./container Shops -->
@endsection
