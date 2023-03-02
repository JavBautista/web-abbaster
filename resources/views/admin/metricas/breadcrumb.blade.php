<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	@switch($item)
	    @case('visitas.web')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Visitas Web</li>
	    @break
	    @case('visitas.web.range')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Visitas Web Por Rango</li>
	    @break
	    @case('visitas.web.mes')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item"><a href="/admin/metricas">Metricas</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Visitas Web Por Mes</li>
	    @break
	    @case('visitas.products')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Visitas Productos</li>
	    @break
	    @case('visitas.categories')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Visitas Categorias</li>
	    @break
	    @case('visitas.charts')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Charts</li>
	    @break


    @endswitch

  </ol>
</nav>