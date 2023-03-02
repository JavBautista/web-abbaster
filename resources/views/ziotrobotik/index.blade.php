@extends('layouts.app_ziotrobotik')

@section('content')
<div class="container-fluid">
      @if($carousel)
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          @php $num_slide=0; @endphp
          @foreach($carousel as $item)
            <li data-target="#myCarousel" data-slide-to="{{$num_slide}}" class="{{ $num_slide?'':'active' }}"></li>
          @php $num_slide++; @endphp
          @endforeach
        </ol>
        <div class="carousel-inner">
          @php $active = 'active'; @endphp
          @foreach($carousel as $item)
          <div class="carousel-item {{$active}}">
            @php $active=''; @endphp
            <a href="{{ ($item->url)?$item->url:'#' }}">
              <img class="d-block w-100" src="{{ $item->getImageStore($item->image) }}" alt="{{ $item->title }}">
            </a>
            <div class="container">
              <div class="carousel-caption text-{{$item->align}}">
                <h2>{{ $item->title }}</h2>
                <p>{{ $item->content }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      @else
        <h1>Bienvenido a ZIoT Robotik.</h1>
      @endif
</div>
<div class="container-fluid">

      <div class="container presentacion">

        <div class="row">
          <div class="col-4">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('assets/ziotrobotik/logo_ziotrobotik.png') }}" alt="ZIoT Image Landing">
          </div>
          <div class="col-8">
            <h2 class="featurette-heading">Robotica Aplicada <span class="text-muted"> ¡Tienda, Consultoria y Desarrollo!</span></h2>
            <p class="lead">Empresa Mexicana, originaria de Puebla Pue. Somos un equipo de Ingenieros emprendedores con ganas de crear, desarrollar y hacer crecer nuestro entorno a través de la tecnología. Nuestro equipo   de ingenieros en mecatrónica,  ciencias de la computación e Industriales ofrecen lo mejor de si para ofrecer productos y servicios de la mas alta calidad, ¡conocenos!</p>
          </div>
        </div>

      </div>
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="{{ asset('assets/ziotrobotik/landing_tienda.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h2>Tienda</h2>
            <p>Todo los que buscas para tu proyectos: Impresora 3D, Tarjetas de desarrollo, Integrados, sensores, etc. Para todas las áreas: Comunicación e interfaces, Optoelectrónica, Mecánica y mucho mucho mas. La mejor calidad y un buen precio. ¡No  solo vendemos por vender, queremos que ayudarte a crecer!</p>
            <p><a class="btn btn-ziot-blue" href="/ziotrobotik/store" role="button">Visitar Tienda &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="{{ asset('assets/ziotrobotik/landing_academia.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h2>Educación</h2>
            <p>Creemos firmemente que en México y cualquier parte de este planeta, la educación es el verdadero factor de cambio no solo para el futuro sino para el presente mismo. El conocimiento tecnológico es la herramienta de hoy. Nos interesa que la educación no solo sea teórica, sino practica. </p>
            <p><a class="btn btn-ziot-blue" href="#" role="button">Saber mas detalles &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="{{ asset('assets/ziotrobotik/landing_proyectos.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h2>Proyectos</h2>
            <p>!No hay proyectos pequeños! Robótica aplicada al alcance de tu mano:  domótica, IoT, educación, industria, pymes. Nuestro grupo de ingenieros están para apoyarte. ¿Que proyecto traes entre manos?  ¡Dejemos de hacer solo teoría y hagamos cosas grandes!</p>
            <p><a class="btn btn-ziot-blue" href="#" role="button">Ver Proyectos &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">
        @if(count($products_featured))
        <div class="container marketing mt-4">

          <h2 class=" text-right display-4">LO MEJOR PARA TUS PROYECTOS</h2>

          <!-- Three columns of text below the carousel -->
          <div class="row">
            @foreach($products_featured as $product_featured)
            <div class="col-lg-4">
              <div class="card mb-2" style="width: 18rem;">
                <div class="text-center mt-2">
                  @if($product_featured->slug)
                    <a href="{{ route('ziotrobotik.store.product.slug',$product_featured->slug) }}">
                      <img class="thumbnail" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                    </a>
                  @else
                    <a href="{{ route('ziotrobotik.store.category.product',['category_id'=>$product_featured->category->id,'product_id'=>$product_featured->id])}}">
                      <img class="thumbnail" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                    </a>
                  @endif


                </div>
                <div class="card-body">
                  @include('parts.show_stars_product',['num_stars'=>$product_featured->stars])
                  <p class="card-title">{{ $product_featured->name }}</p>
                  <h3 class="card-text float-right text-ziotrobotik"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product_featured->retail) }}  </strong></h3>
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
                    </p>
                  @endif
                  <br><br>
                  @if($product_featured->slug)
                    <a href="{{ route('ziotrobotik.store.product.slug',$product_featured->slug) }}" class="btn btn-ziot-red">Ver mas...</a>
                  @else
                    <a href="{{ route('ziotrobotik.store.category.product',['category_id'=>$product_featured->category->id,'product_id'=>$product_featured->id])}}" class="btn  btn-ziot-red">Ver mas...</a>
                  @endif
                </div>
              </div>
            </div><!-- /.col-lg-4 -->
            @endforeach
          </div><!-- /.row -->
          <!-- /END THE FEATURETTES -->
        </div><!-- /.container -->
        <hr>
        @endif




        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">¡Oh yeah, ser Ingeniero es lo mejor!&nbsp;<span class="text-muted">Orgullasamente Mexicanos.</span></h2>
            <p class="lead">¡Somos mas que solo teoría! Creemos que existen miles, millones! de seres humanos con capacidades increíbles para  crear, emprender, enseñar, desarrollar. Solo basta creerlo y perder el miedo para arriesgarse a hacer aquello que sabemos puede ser posible. En ZIoT Robotik buscamos sacar del papel las ideas y llevarlas a la practica.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('assets/ziotrobotik/landing_playera_m.jpg') }}"  alt="Generic placeholder image">
          </div>
        </div>
        <hr class="featurette-divider">
        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Nos apasiona: <span class="text-muted">Descubrir, desarrollar y crecer.</span></h2>
            <p class="lead">Buscamos la disrupción en todo lo que hacemos, salimos fuera de los modelos comunes para ofrecer los mejores productos y servicios. No buscamos solo hacer "negocio" buscamos crear nuevas oportunidades para nuestros clientes, emprendedores y todo aquellos que como nosotros nos apasiona la tecnología.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('assets/ziotrobotik/EBeax80XoAEXQ7J.jpg') }}" alt="Generic placeholder image">
          </div>
        </div>




        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">¡Un libro, un café <span class="text-muted"> y a emprender!</span></h2>
            <p class="lead">Dicen que si te dedicas a lo que te gusta, nunca tendrás que trabajar. Emprender se dice fácil y en este mismo instante hay miles de personas luchando por sus sueños. En ZIoT Robotik queremos brindarte nuestra experiencia y apoyo, no importa si eres, estudiante, quieres emprender o ya estas en ello, si quieres desarrollar algo nuevo y no sabes por donde empezar, contactanos estamos para crecer juntos.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('assets/ziotrobotik/D-Z_2JOX4AIuCB-.jpg') }}" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="container marketing mt-4">

          <h2 class="display-4">Los ultimos integrantes de la familia ZIoT Robotik</h2>

          <!-- Three columns of text below the carousel -->
          <div class="row">
            @foreach($products as $product)
            <div class="col-lg-4">
              <div class="card mb-2" style="width: 18rem;">
                <div class="text-center mt-2">
                  <img class="thumbnail" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                </div>
                <div class="card-body">
                  @include('parts.show_stars_product',['num_stars'=>$product->stars])
                  <p class="card-title">{{ $product->name }}</p>
                  <h3 class="card-text float-right text-ziotrobotik"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product->retail) }}  </strong></h3>
                  @php
                    $_existe_shipping=false;
                    $_shipping=0;
                    if(isset($product->category->shop->shipping->shipping_from)){
                      $_existe_shipping=true;
                      $_shipping=$product->category->shop->shipping->shipping_from;
                    }
                  @endphp
                  @if($_existe_shipping && ($product->retail>$_shipping))
                    <p>
                      <h5 class="text-success"><strong><i class="fa fa-shipping-fast"></i> Envio Gratis</strong></h5>
                    </p>
                  @endif
                  <br><br>
                  @if($product->slug)
                    <a href="{{ route('ziotrobotik.store.product.slug',$product->slug) }}" class="btn btn-ziot-blue">Ver mas...</a>
                  @else
                    <a href="{{ route('ziotrobotik.store.category.product',['category_id'=>$product->category->id,'product_id'=>$product->id])}}" class="btn  btn-ziot-blue">Ver mas...</a>
                  @endif
                </div>
              </div>
            </div><!-- /.col-lg-4 -->
            @endforeach
          </div><!-- /.row -->
          <!-- /END THE FEATURETTES -->
        </div><!-- /.container -->
        <hr>


        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->

</div>
@endsection