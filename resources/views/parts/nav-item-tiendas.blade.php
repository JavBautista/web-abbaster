<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Tiendas
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      @php
        $shops= getShops();
      @endphp
      @foreach($shops as $shop)
        @if($shop->dynamic)
          <a class="dropdown-item" href="/shop/{{$shop->slug}}">{{$shop->name}}</a>
        @else
          <a class="dropdown-item" href="/{{$shop->slug}}">{{$shop->name}}</a>
        @endif
      @endforeach
      <a class="dropdown-item" href="/">Inicio Abbaster</a>
    </div>
</li>