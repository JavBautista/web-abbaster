<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	@switch($item)
  		@case('index')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">CEDIS</li>
	    	@break
	    @case('operation.index')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item"><a href="{{ route('cedis') }}">CEDIS</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Operación</li>
	    	@break
	    @case('operation.recepcion.index')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item"><a href="{{ route('cedis') }}">CEDIS</a></li>
	    	<li class="breadcrumb-item"><a href="{{ route('cedis.operation') }}">Operación</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Recepcion</li>
	    	@break
	    @case('warehouse.index')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>

			<li class="breadcrumb-item active" aria-current="page">Almacenes</li>
	    	@break
	    @case('warehouse.create')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item"><a href="{{ route('cedis') }}">CEDIS</a></li>
	    	<li class="breadcrumb-item"><a href="{{ route('cedis.warehouse') }}">Almacenes</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Nuevo Almacen</li>
	    	@break
	    @case('warehouse.image')
	    	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item"><a href="{{ route('cedis') }}">CEDIS</a></li>
	    	<li class="breadcrumb-item"><a href="{{ route('cedis.warehouse') }}">Almacenes</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Imagen</li>
	    	@break

    @endswitch

  </ol>
</nav>