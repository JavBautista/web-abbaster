<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	@switch($item)
    	@case('index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item active" aria-current="page">Afiliados</li>
            @break
      <!--PORCENTAJES COMISIONES-->
      @case('porcentajes_comisiones.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">Porcentajes Comisiones</li>
            @break
      <!--SELLERS-->
      @case('sellers.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">Admin. Afiliados</li>
            @break
      @case('sellers.add')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/sellers">Admin. Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
            @break
      @case('sellers.view')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/sellers">Admin. Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">Detalle</li>
            @break
      @case('sellers.edit')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/sellers">Admin. Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar</li>
            @break
      @case('sellers.edit.status')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/sellers">Admin. Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar Status</li>
            @break
      @case('sellers.user|')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/sellers">Admin. Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">User</li>
            @break
      <!--CODIGOS DE DESCUENO-->
      @case('discount_codes.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item active" aria-current="page">Codigos de Descuento</li>
            @break
      @case('discount_codes.add')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/discount-codes">Codigos de Descuento</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
            @break
      @case('discount_codes.remove')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/discount-codes">Codigos de Descuento</a></li>
          <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
            @break
      @case('discount_codes.edit.status')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados">Afiliados</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/afiliados/discount-codes">Codigos de Descuento</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar Status</li>
            @break

    @endswitch

  </ol>
</nav>