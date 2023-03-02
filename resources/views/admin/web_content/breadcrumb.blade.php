<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	@switch($item)

    @case('about_us')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Ubout Us</li>
          @break
    @case('services')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Services</li>
          @break
    @case('descargas')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Descargas</li>
          @break
    @case('descargas.delete')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.web.descargas', [ 'id'=>$shop->id] ) }}">Descargas</a></li>
          <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
          @break

    @case('images_carousel_index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item active" aria-current="page">Images Carousel</li>
          @break
    @case('images_carousel_add')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.web.images_carousel', [ 'id'=>$shop->id] ) }}">Images Carousel</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
          @break
    @case('images_carousel_edit')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.web.images_carousel', [ 'id'=>$shop->id] ) }}">Images Carousel</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
          @break
    @case('images_carousel_remove')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.web.images_carousel', [ 'id'=>$shop->id] ) }}">Images Carousel</a></li>
          <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
          @break

    @case('image_banner_promotional')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item active" aria-current="page">Imagen Banner Promocional</li>
          @break


    @case('seccion_descripcion')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item active" aria-current="page">Seccion Descripcion</li>
          @break
    @case('productos_destacados')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item active" aria-current="page">Productos Destacados</li>
          @break
    @case('productos_nuevos')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>

          <li class="breadcrumb-item active" aria-current="page">Productos Nuevos</li>
          @break


    @endswitch

  </ol>
</nav>