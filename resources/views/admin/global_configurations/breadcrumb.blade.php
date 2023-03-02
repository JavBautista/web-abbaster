<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    @switch($item)

      @case('dollar_price')
          <!--Dollar Price -->
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations">Configuraciones Globales</a></li>
          <li class="breadcrumb-item active" aria-current="page">Precio Dollar</li>
      @break
      <!--Statuses Purchase Orders -->
      @case('statuses_po.create')
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations/statuses-purchase-order">Statuses Purches Order</a></li>
          <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
      @break


      <!--Shops-->
      @case('shops.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations">Configuraciones Globales</a></li>
          <li class="breadcrumb-item active" aria-current="page">Shops</li>
      @break

      @case('shops.edit.status')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations">Configuraciones Globales</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations/shops">Shops</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar Estatus</li>
      @break

      @case('shops.edit.datos')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations">Configuraciones Globales</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations/shops">Shops</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar Datos</li>
      @break

      @case('shops.edit.tipo')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations">Configuraciones Globales</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations/shops">Shops</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar tipo de tienda</li>
      @break

      @case('shops.logo')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations">Configuraciones Globales</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/global-configurations/shops">Shops</a></li>
          <li class="breadcrumb-item active" aria-current="page">Logo</li>
      @break

      <!--WEB Content Section-Testimonios-->
      @case('web_content.testimonios.edit_img')
          <li class="breadcrumb-item"><a href="{{route('global-configurations.web_content.testimonios')}}">Testimonios</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar imagen</li>
      @break

      <!--WEB Content-Carousel-->
      @case('web_content.caroulsel.add')
          <li class="breadcrumb-item"><a href="{{route('global-configurations.web_content.carousel')}}">Carousel</a></li>
          <li class="breadcrumb-item active" aria-current="page">Agregar</li>
      @break
      @case('web_content.caroulsel.edit')
          <li class="breadcrumb-item"><a href="{{route('global-configurations.web_content.carousel')}}">Carousel</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar</li>
      @break
      @case('web_content.caroulsel.remove')
          <li class="breadcrumb-item"><a href="{{route('global-configurations.web_content.carousel')}}">Carousel</a></li>
          <li class="breadcrumb-item active" aria-current="page">Borrar</li>
      @break

       <!--WEB Content Productos Destacados-->
      @case('web_content.destacados')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item active" aria-current="page">Productos Destacados</li>
      @break

    @endswitch

  </ol>
</nav>