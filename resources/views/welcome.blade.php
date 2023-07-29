@extends('layouts.app_abbaster')

@section('content')
  @php
    $abbaster_info=getAbbasterInformation();
    $style=($abbaster_info->style_color_bg!='')?"color: $abbaster_info->style_color_txt !important; background-color: $abbaster_info->style_color_bg !important;":'';
  @endphp
  @if($seccion_carousel->show)
    <h2 class="text-center display-4 mt-4">{{$seccion_carousel->title}}</h2>
    <h4 class="text-center mt-4">{{$seccion_carousel->description}}</h4>
    @if($carousel->count())
              <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel" data-pause="false">
                <div class="carousel-inner">
                  @php  $active=true;  @endphp
                  @foreach($carousel as $reg)
                    <div class="carousel-item {{ ($active)?'active':''}}">
                      <a href="{{ ($reg->url)?$reg->url:'#' }}">
                        <img class="d-block w-100" src="{{ $reg->getImageStore( $reg->image) }}" alt="{{$reg->name}}">
                      </a>
                    </div>
                    @php $active=false; @endphp
                  @endforeach

                  <div class="overlay">
                    <div class="container">
                      <div class="row align-items-center">
                        <div class="col-md-12 text-center">
                          <!--
                          <h1 class="display-2">ABBASTER</h1>
                          <h2> Innovation & Solution at your fingertips</h2>
                          -->
                        </div>
                      </div>
                    </div>
                  </div><!--./overlay-->
                </div>
              </div>
          @endif
  @endif

  @if($destacados->show)
    <section class="bg-azul-x">
      @if(count($products_featured))
        <div class="container marketing">
          <br>
          <h2 class=" text-center display-4 mt-4">{{$destacados->title}}</h2>
          <h4>{{$destacados->description}}</h4>
          <!-- Three columns of text below the carousel -->
          <div class="row">
            @foreach($products_featured as $product_featured)
            @php
                $link_route = '#';
                //Para tiendas dinamicas
                if($product_featured->category->shop->dynamic){

                  if($product_featured->slug){
                    $link_route=route('shops.store.product.slug',[
                      'shop_slug'=>$product_featured->category->shop->slug,
                      'product_slug'=> $product_featured->slug
                    ]);
                  }else{
                    $link_route=route('shops.store.product.id',[
                      'shop_slug'=>$product_featured->category->shop->slug,
                      'product_id'=> $product_featured->id
                    ]);
                  }

                }else{
                  //Para tiendas manuales
                  if($product_featured->slug){
                    $link_route=route($product_featured->category->shop->slug.'.store.product.slug',$product_featured->slug);
                  }else{
                    //echo $product_featured->category->shop->slug;
                    if(isset($product_featured->category->id) && isset($product_featured->id)){

                    $link_route=route($product_featured->category->shop->slug.'.store.category.product',['category_id'=>$product_featured->category->id,'product_id'=>$product_featured->id]);

                    }
                  }

                }//if-else
            @endphp
            <div class="col-lg-3">
              <div class="card h-100 mb-2">
                <a href="{{$link_route}}">
                  <img class="card-img-top card-img-scale" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}">
                </a>
                <div class="card-body">
                  @include('parts.show_stars_product',['num_stars'=>$product_featured->stars])
                  <br><br>
                  <p class="card-title">{{ $product_featured->getShortNameAttribute($product_featured->name) }}</p>

                  <h4 class="card-text text-abbaster"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product_featured->retail) }} </strong></h4>

                  <p class="card-text small text-left">
                    <em>por {{ $product_featured->category->shop->name }}</em>
                    <img src="{{ $product_featured->category->shop->getLogoStore($product_featured->category->shop->logo)}}" alt="{{$product_featured->category->shop->logo}}" class="logo-txt-center" width="30px">
                  </p>

                  @php
                    $_existe_shipping=false;
                    $_shipping=0;
                    if(isset($product_featured->category->shop->shipping->shipping_from)){
                      $_existe_shipping=true;
                      $_shipping=$product_featured->category->shop->shipping->shipping_from;
                    }
                  @endphp
                  @if($_existe_shipping && ($product_featured->retail>$_shipping))
                  <p>
                    <h5 class="text-success"><strong><i class="fa fa-shipping-fast"></i> Envio Gratis</strong></h5>
                    <p class="text-muted small">A partir de ${{ number_format($_shipping,2)}}</p>
                  </p>
                  @endif

                </div>
                <div class="card-footer bg-transparent border-light">

                  <div class="row">
                    <div class="col-4">
                      @include('parts.product_add_to_cart',['product'=>$product_featured])
                    </div>
                    <div class="col-8">
                      <a href="{{ $link_route  }}" class="btn btn-abbaster" style="{{$style}}">Ver detalle <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- /.col-lg-4 -->
            @endforeach
          </div><!-- /.row -->
          <!-- /END THE FEATURETTES -->


        </div><!-- /.container -->

        @endif
    </section>
  @endif
  <section>
   
      <div class="card mb-3" style="{{$style}}">
        <div class="row no-gutters">
          
          <div class="col-md-8">
            <div class="card-body">
              <h2 class="text-center">PROYECTOS</h2>
              <p class="mt-4">Descubre nuestros innovadores proyectos de desarrollo y automatización tecnológica en <strong>Abbaster.com</strong> </p>
              <p>Diseñamos soluciones personalizadas para particulares, empresas e industrias. Desde implementaciones domésticas hasta sistemas complejos a nivel industrial, nuestros proyectos abarcan una amplia gama de necesidades. </p>
              <p>Explora nuestras propuestas vanguardistas y encuentra la solución perfecta para optimizar tus procesos. ¡Haz clic aquí para conocer más detalles sobre cada proyecto!
              </p>
              <p class="align-center">
                <a href="/proyectos/" class="btn btn-primary float-right ">MAS INFORMACIÓN <i class="fa fa-arrow-circle-right"></i> </a>
              </p>
            </div>
          
          </div>
          <div class="col-md-4">
            <img src="{{ asset('assets/proyectos.png') }}" class="card-img" alt="...">
          </div>
        </div>
      </div>


  </section>
  @if($acceso_tiendas->show)
    <section>
      <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h2 class="display-4">{{$acceso_tiendas->title}}</h2>
        <p class="lead">{{$acceso_tiendas->description}}</p>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row">

          @foreach($shops as $shop)
              @if(isset( $tdas_accesos[$shop->id]))
                @php
                  $link_shop = ($shop->dynamic)?route('shops.index',$shop->slug):"/$shop->slug";
                @endphp
                <div class="col-md-3">
                  <div class="card mb-4 shadow-sm h-100">

                    <a href="{{ $link_shop }}">
                      <img class="card-img-top card-img-scale" src="{{$shop->getLogoStore($shop->logo)}}" alt="{{ $shop->name }}">
                    </a>

                    <div class="card-footer bg-transparent border-light">
                      <a href="{{ $link_shop }}"class="btn btn-block btn-abbaster" style="{{$style}}">{{ $shop->name }}</a>
                    </div>

                  </div>
                </div>
              @endif
            @endforeach
        </div>

      </div>
    </section>
  @endif


  @if($metodos_pagos->show)
    <section class="container-fluid">
      <h3 class="mt-2">{{$metodos_pagos->title}}</h3>
      <h4>{{$metodos_pagos->description}}</h4>
      <img src="{{ $metodos_pagos->getImageStore($metodos_pagos->image) }}" alt="{{ $metodos_pagos->title }}"  class="img-fluid" >
    </section>
  @endif

  @if($seccion_testimonios->show && $testimonios)
    <section class="testimonios mt-4 mb-4">
       <div class="container">
        <h2>{{$seccion_testimonios->title}}</h2>
        @foreach($testimonios as $testimonio)
          <div class="card testimonios mb-3">
            <div class="row no-gutters">
              <div class="col-md-3">
                <img class="rounded-circle" src="{{$testimonio->getImageStore($testimonio->image)}}" alt="Imagen de {{$testimonio->autor }}" width="200px" height="200px">
              </div>
              <div class="col-md-9">
                <div class="card-body">
                    <h5 class="card-title"><strong>{{$testimonio->title}}</strong></h5>
                    <p class="card-text">"{{$testimonio->description}}"</p>
                    <p class="card-text float-right">
                      <small class="text-muted"><strong>{{$testimonio->autor}} <em>{{$testimonio->job}}</em></strong></small>
                      @if($testimonio->web)
                        <br>
                        <small class="text-muted">{{$testimonio->web}}</small>
                      @endif
                      @if($testimonio->contact)
                        <br>
                        <small class="text-muted">{{$testimonio->contact}}</small>
                      @endif
                      @if($testimonio->city)
                        <br>
                        <small class="text-muted"> <strong>{{$testimonio->city}}</strong></small>
                      @endif
                      <small class="text-muted">&nbsp;{{$testimonio->created_at}}</small>
                    </p>

                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>
      </section>
  @endif

  @if($seccion_crece->show)
    <section>

      <div class="card mb-3" style="{{$style}}">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="{{ asset('assets/250420_abbaster.jpg') }}" class="card-img" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h2>{{$seccion_crece->title}}</h2>
              {!! $section_crece !!}

              <a href="/crece/" class="btn btn-light">Vamos <i class="fa fa-arrow-circle-right"></i> </a>
            </div>
          </div>
        </div>
      </div>

    </section>
  @endif


  @if($logos_tiendas->show)

    <section>
      <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h2 class="display-4">{{$logos_tiendas->title}}</h2>
        <p class="lead">{{$logos_tiendas->description}}</p>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row mb-2">
          <div class="card-deck">

            @foreach($shops as $shop)
              @if(isset( $tdas_logos[$shop->id]))
                <div class="card">
                  <img class="card-img-top" src="{{$shop->getLogoStore($shop->logo)}}" alt="logo-{{$shop->name}}">
                  <div class="card-footer text-center bg-white border-light">
                    <h5>{{$shop->name}}</h5>
                  </div>
                </div>
              @endif
            @endforeach

          </div>

        </div>
      </div>
    </section>
  @endif


  @include('parts.formulario_contacto')

@endsection