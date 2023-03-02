@if(!$product->status)
	@php
		$inventories=$product->inventoryProduct;
        $stock_ex=0;
        $sales_limit_web = $product->sales_limit_web;
        $_tmp=0;
        foreach($inventories as $inventory) $_tmp += $inventory->exhibition;
		$stock_ex=($_tmp >= $sales_limit_web)?$sales_limit_web:$_tmp;
	@endphp
	@if($stock_ex)
		<form action="/shopping-cart/new-add-to-cart" method="post">
			@csrf
			<input type="hidden" name='shop_id' value="{{ $product->category->shop->id }}">
			<input type="hidden" name='shop_name' value="{{ $product->category->shop->name }}">
			<input type="hidden" name='shop_slug' value="{{ $product->category->shop->slug }}">

			<input type="hidden" name='category_id' value="{{ $product->category->id }}">
			<input type="hidden" name='category_name' value="{{ $product->category->name }}">
			<input type="hidden" name='category_slug' value="{{ $product->category->slug }}">

			<input type="hidden" name='id' value="{{ $product->id }}">
			<input type="hidden" name='key' value="{{ $product->key }}">
			<input type="hidden" name='qty' value="1">
			<input type="hidden" name='name' value="{{ $product->name }}">
			<input type="hidden" name='price' value="{{ $product->retail }}">
			<input type="hidden" name='image' value="{{ $product->image }}">
			<input type="hidden" name='stock_exhibition' value="{{ $stock_ex }}">
			<input type="hidden" name='product_slug' value="{{ $product->slug }}">
			<button type="submit" class="btn btn-outline-primary"> <i class="fa fa-cart-plus"></i></button>
		</form>
	@endif
@endif