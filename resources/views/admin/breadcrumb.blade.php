<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	@switch($item)
  		@case('index')
	    	<li class="breadcrumb-item active" aria-current="page">Index</li>
	    	@break

    <!-- ------------------------------------------------Scripts------------------------------------------------------------ -->
    @case('scripts.index')
        <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
        <li class="breadcrumb-item active" aria-current="page">Scripts</li>
          @break
    @case('scripts.view')
        <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
        <li class="breadcrumb-item"><a href="/dashboard/scripts">Scripts</a></li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
          @break
    @case('scripts.edit')
        <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
        <li class="breadcrumb-item"><a href="/dashboard/scripts">Scripts</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
          @break
    @case('scripts.remove')
        <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
        <li class="breadcrumb-item"><a href="/dashboard/scripts">Scripts</a></li>
        <li class="breadcrumb-item active" aria-current="page">Remove</li>
          @break
    <!-- ------------------------------------------------Stores------------------------------------------------------------ -->
    @case('store.index')
        	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	<li class="breadcrumb-item active" aria-current="page">Store</li>
        	@break
    <!-- ------------------------------------------------Services------------------------------------------------------------ -->
    @case('store.services.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Servicios</li>
          @break
    <!-- ------------------------------------------------Courses------------------------------------------------------------ -->
    @case('store.courses.index')
        	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
  	    	<li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
  	    	<li class="breadcrumb-item active" aria-current="page">Cursos</li>
        	@break
    @case('store.courses.admin_course')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.courses.index', [ 'shop_id'=>$shop->id] ) }}">Cursos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Curso</li>
          @break
    <!-- ------------------------------------------------Proveedores------------------------------------------------------------ -->
    @case('store.proveedores.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
          @break

    @case('store.proveedores.view')
        	<li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
	    	  <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
  	    	<li class="breadcrumb-item"><a href="{{ route('dashboard.store.proveedores.index', [ 'shop_id'=>$shop->id] ) }}">Proveedores</a></li>
  	    	<li class="breadcrumb-item active" aria-current="page">Detalle</li>
        	@break

    @case('store.proveedores.add')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.proveedores.index', [ 'shop_id'=>$shop->id] ) }}">Proveedores</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
          @break
    @case('store.proveedores.edit')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.proveedores.index', [ 'shop_id'=>$shop->id] ) }}">Proveedores</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
          @break
    @case('store.proveedores.edit.status')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.proveedores.index', [ 'shop_id'=>$shop->id] ) }}">Proveedores</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Status</li>
          @break
    @case('store.proveedores.edit.remove')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
  	    	<li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
  	    	<li class="breadcrumb-item"><a href="{{ route('dashboard.store.proveedores.index', [ 'shop_id'=>$shop->id] ) }}">Proveedores</a></li>
  	    	<li class="breadcrumb-item active" aria-current="page">Remove</li>
        	@break

    <!-- ------------------------------------------Categorias------------------------------------------------------------------ -->
    @case('store.categories.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Categorias</li>
          @break

   @case('store.categories.add')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.categories.index', [ 'shop_id'=>$shop->id] ) }}">Categorias</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
          @break
  @case('store.categories.slugs')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.categories.index', [ 'shop_id'=>$shop->id] ) }}">Categorias</a></li>
          <li class="breadcrumb-item active" aria-current="page">Slugs</li>
          @break
  @case('store.categories.orderby')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.categories.index', [ 'shop_id'=>$shop->id] ) }}">Categorias</a></li>
          <li class="breadcrumb-item active" aria-current="page">Order By</li>
          @break
    @case('store.categories.image')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.categories.index', [ 'shop_id'=>$shop->id] ) }}">Categorias</a></li>
          <li class="breadcrumb-item active" aria-current="page">Image</li>
          @break

    <!-- ------------------------------------------Productos------------------------------------------------------------------ -->

    @case('store.products.add')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
          @break
    @case('store.products.slugs')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Slugs</li>
          @break
    @case('store.products.barcodes')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Codigos de barras</li>
          @break
    @case('store.products.orderby')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Order By</li>
          @break
    @case('store.products.images')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Images</li>
          @break
    @case('store.products.edit')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar</li>
          @break
    @case('store.products.edit.status')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Status</li>
          @break
    @case('store.products.edit.remove')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Remove</li>
          @break
    @case('store.products.view')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">View</li>
          @break
    <!-- ------------------------------------------Inventories-Productos--------------------------------------------- -->
    @case('store.products.inventories.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Inventories</li>
          @break
    @case('store.products.inventories.add')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.inventories.index', [ 'shop_id'=>$shop->id, 'product_id'=>$product->id ] ) }}">Inventories</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
          @break
    @case('store.products.inventories.edit')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.products.index', [ 'shop_id'=>$shop->id] ) }}">Productos</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.inventories.index', [ 'shop_id'=>$shop->id, 'product_id'=>$product->id ] ) }}">Inventories</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
          @break

     <!-- ------------------------------------------SALES------------------------------------------------------------------ -->
    @case('store.sales.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Ventas</li>
          @break
    @case('store.sales.view')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.sales.index', [ 'shop_id'=>$shop->id] ) }}">Ventas</a></li>
          <li class="breadcrumb-item active" aria-current="page">View</li>
          @break
    @case('store.sales.chat')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.sales.index', [ 'shop_id'=>$shop->id] ) }}">Ventas</a></li>
          <li class="breadcrumb-item active" aria-current="page">Chat</li>
          @break
    @case('store.sales.edit')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.sales.index', [ 'shop_id'=>$shop->id] ) }}">Ventas</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
          @break
    @case('store.sales.edit.tracking')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.sales.index', [ 'shop_id'=>$shop->id] ) }}">Ventas</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Tracking Number</li>
          @break
    @case('store.sales.edit.status')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dashboard.store.sales.index', [ 'ishop_idd'=>$shop->id] ) }}">Ventas</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Status</li>
          @break
    <!-- ------------------------------------------CONFIGURACIONES------------------------------------------------------------------ -->
    @case('store.configuraciones.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Configuraciones</li>
          @break
    @case('store.configuraciones.edit_shipping')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Editar Shiping</li>
          @break
    <!-- ------------------------------------------PREGUNTAS------------------------------------------------------------------ -->
    @case('store.preguntas.index')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Preguntas</li>
          @break

    <!-- ------------------------------------------------CUSTOMERS-------------------------------------------------------------->
    @case('store.customers.purchases')
          <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
          <li class="breadcrumb-item"><a href="{{ route('store.index', [ 'id'=>$shop->id] ) }}">{{ $shop->name }}</a></li>
          <li class="breadcrumb-item"><a href="{{route('dashboard.store.customers.index', ['shop_id'=>$shop->id])}}">Clientes</a></li>
          <li class="breadcrumb-item"><a href="{{route('dashboard.store.customers.show', ['shop_id'=>$shop->id,'customer_id'=>$customer->id])}}">{{$customer->name}}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Compras</li>
          @break

    @endswitch

  </ol>
</nav>