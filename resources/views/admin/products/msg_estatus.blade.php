<div class="row">
	<div class="col">
	  @if($product->status)
	    <div class="alert alert-danger text-center">{{ $product->name }}: <strong>INACTIVO</strong></div>
	  @else
	    <div class="alert alert-info text-center">{{ $product->name }}: <strong>ACTIVO</strong></div>
	  @endif
	</div>
</div>