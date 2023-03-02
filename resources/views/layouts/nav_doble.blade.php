<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
  <!-- One of the primary actions on mobile is to call a business - This displays a phone button on mobile only -->
  <div class="navbar-toggler-right">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
  </div>
  <div class="collapse navbar-collapse flex-column " id="navbar">
    <ul class="navbar-nav  w-100 justify-content-center px-3">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        javier
      </li>
      <li class="nav-item dropdown">
       Ivette
      </li>
      <li class="nav-item dropdown">
        Domi
      </li>
    </ul>
    <ul class="navbar-nav justify-content-center w-100 bg-secondary px-3">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        tito
      </li>
      <li class="nav-item dropdown">
        search
      </li>
      <li class="nav-item dropdown">
        otro?
      </li>
    </ul>
  </div>

</nav>




<nav class="navbar navbar-expand-lg navbar-dark bg-abbaster">
      <div class="navbar-toggler-right">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-abbaster" aria-controls="navbar-abbaster" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <!--
      <a class="navbar-brand" href="/">Abbaster</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-abbaster" aria-controls="navbar-abbaster" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      -->
      <div class="collapse navbar-collapse flex-column " id="navbar">
        <ul class="navbar-nav  w-100 justify-content-center px-3">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            javier
          </li>
          <li class="nav-item dropdown">
           Ivette
          </li>
          <li class="nav-item dropdown">
            Domi
          </li>
        </ul>
        <ul class="navbar-nav justify-content-center w-100 bg-secondary px-3">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            tito
          </li>
          <li class="nav-item dropdown">
            search
          </li>
          <li class="nav-item dropdown">
            otro?
          </li>
        </ul>
      </div>

      <div class="collapse navbar-collapse" id="navbar-abbaster">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="/eagletekmexico" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Eagletek México</a>
            <div class="dropdown-menu" aria-labelledby="dropdown09">
              <a class="dropdown-item" href="/eagletekmexico/store">Store</a>
              @foreach($categories as $category)
                @if($category->shop_id==1)
                  @if($category->slug)
                    <a class="dropdown-item" href="{{ route('eagletekmexico.store.category.slug',$category->slug) }}">{{$category->name}}</a>
                  @else
                    <a class="dropdown-item" href="{{ route('eagletekmexico.store.category',$category->id) }}">{{$category->name}}</a>
                  @endif
                @endif
              @endforeach
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="/ziotrobotik" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ZIoT Robotik</a>
            <div class="dropdown-menu" aria-labelledby="dropdown09">
              <a class="dropdown-item" href="/ziotrobotik/store">Store</a>
              @foreach($categories as $category)
                @if($category->shop_id==2)
                  @if($category->slug)
                    <a class="dropdown-item" href="{{ route('ziotrobotik.store.category.slug',$category->slug) }}">{{$category->name}}</a>
                  @else
                    <a class="dropdown-item" href="{{ route('ziotrobotik.store.category',$category->id) }}">{{$category->name}}</a>
                  @endif
                @endif
              @endforeach
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="/solartekmexico" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Solartek</a>
            <div class="dropdown-menu" aria-labelledby="dropdown09">
              <a class="dropdown-item" href="/solartekmexico/store">Store</a>
              @foreach($categories as $category)
                @if($category->shop_id==3)
                  @if($category->slug)
                    <a class="dropdown-item" href="{{ route('solartek.store.category.slug',$category->slug) }}">{{$category->name}}</a>
                  @else
                    <a class="dropdown-item" href="{{ route('solartek.store.category',$category->id) }}">{{$category->name}}</a>
                  @endif
                @endif
              @endforeach
            </div>
          </li>

           <li class="nav-item">
              <a href="https://blog.abbaster.com"class="nav-link">Blog</a>
            </li>

            <li class="nav-item">
              <a href="/como-comprar/"class="nav-link">¿Cómo comprar?</a>
            </li>
            <li class="nav-item">
              <a href="/access/"class="nav-link">Registrarse</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">

          <li class="nav-item">

          </li>

          <!--<li class="nav-item">
            <form class="form-inline mt-2" action="{{ route('ababster.search') }}">
              <input class="form-control mr-sm-2" type="text" name="query" placeholder="Cerraduras, cámaras, GPS, etc." aria-label="Search" required>
              <button class="btn btn-outline-light my-2 my-sm-0">Buscar</button>
            </form>
          </li>-->

          <li class="nav-item">
             <a href="https://www.facebook.com/abbaster.mx/" class="nav-link"><span class="fab fa-facebook fa-2x"></span></a>
          </li>
          <li class="nav-item">
             <a href="https://wa.me/5212225353084" class="nav-link"><span class="fab fa-whatsapp fa-2x"></span>&nbsp;</a>
          </li>
          @if (Route::has('login'))
            <li class="nav-item">
              @auth
                <a  class="nav-link" href="{{ url('/dashboard') }}"><i class="fa fa-2x fa-user"></i></a>
              @else
                <a  class="nav-link" href="{{ route('login') }}"> <i class="fa fa-2x fa-user"></i></a>
              @endauth
            </li>
          @endif
        </ul>
        <form class="form-inline d-inline w-25" action="{{ route('ababster.search') }}">
              <div class="input-group mt-1">
                <input type="text" name="query" class="form-control" placeholder="Cerraduras, cámaras, GPS, etc." aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-light" id="button-addon2"><i class="fa fa-search"></i></button>
                </div>
              </div>
        </form>
      </div>
    </nav>