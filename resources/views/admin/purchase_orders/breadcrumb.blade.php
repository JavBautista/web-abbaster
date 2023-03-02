<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    @switch($item)

      @case('index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item active" aria-current="page">Ordenes de Compra</li>
      @break

      @case('create')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/purchase-orders">Ordenes de Compra</a></li>
          <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
      @break

      @case('show')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/purchase-orders">Ordenes de Compra</a></li>
          <li class="breadcrumb-item active" aria-current="page"> OC #{{ $purchase_order->id }}</li>
      @break

      @case('edit')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/purchase-orders">Ordenes de Compra</a></li>
          <li class="breadcrumb-item"><a href='/dashboard/purchase-orders/{{$purchase_order->id}}/show'>OC #{{ $purchase_order->id }}</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Editar</li>
      @break

      @case('edit-status')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/purchase-orders">Ordenes de Compra</a></li>
          <li class="breadcrumb-item active" aria-current="page"> OC #{{ $purchase_order->id }}</li>
          <li class="breadcrumb-item active" aria-current="page"> Editar Status </li>
      @break

      @case('edit-fecha-entrega-fecha-real')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/purchase-orders">Ordenes de Compra</a></li>
          <li class="breadcrumb-item active" aria-current="page"> OC #{{ $purchase_order->id }}</li>
          <li class="breadcrumb-item active" aria-current="page"> Editar Fecha Entrega Real </li>
      @break

        @case('surtir')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="/dashboard/purchase-orders">Ordenes de Compra</a></li>
          <li class="breadcrumb-item"><a href='/dashboard/purchase-orders/{{$purchase_order->id}}/show'>OC #{{ $purchase_order->id }}</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Surtir</li>
      @break


    @endswitch

  </ol>
</nav>