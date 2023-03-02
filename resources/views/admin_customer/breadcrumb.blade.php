<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	@switch($item)
  		@case('index')
	    	<li class="breadcrumb-item active" aria-current="page">Inicio</li>
	    	@break
		<!--PURCHASES-->
	    @case('purchases.index')
	    	<li class="breadcrumb-item" aria-current="page"><a href="/customer">Inicio</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Mis Compras</li>
	    	@break
	    @case('purchases.view')
	    	<li class="breadcrumb-item" aria-current="page"><a href="/customer">Inicio</a></li>
	    	<li class="breadcrumb-item" aria-current="page"><a href="/customer/purchases">Mis Compras</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Ver Compra</li>
	    	@break
	    <!--MESSAGES-->
	    @case('messages.index')
	    	<li class="breadcrumb-item" aria-current="page"><a href="/customer">Inicio</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Mensajes</li>
	    	@break


    @endswitch

  </ol>
</nav>