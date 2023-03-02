@php
  $link_route = '#';
  //Para tiendas dinamicas
  if($sg_product->category->shop->dynamic){

    if($sg_product->slug){
      $link_route=route('shops.store.product.slug',[
        'shop_slug'=>$sg_product->category->shop->slug,
        'product_slug'=> $sg_product->slug
      ]);
    }else{
      $link_route=route('shops.store.product.id',[
        'shop_slug'=>$sg_product->category->shop->slug,
        'product_id'=> $sg_product->id
      ]);
    }

  }else{
    //Para tiendas manuales
    if($sg_product->slug){
      $link_route=route($sg_product->category->shop->slug.'.store.product.slug',$sg_product->slug);
    }else{
      $link_route=route($sg_product->category->shop->slug.'.store.category.product',['product_id'=>$sg_product->id, 'category_id'=>$sg_product->category->id]);
    }

  }//if-else

  $_existe_shipping=false;
  $_shipping=0;
  if(isset($sg_product->category->shop->shipping->shipping_from)){
    $_existe_shipping=true;
    $_shipping=$sg_product->category->shop->shipping->shipping_from;
  }
@endphp
<div class="card border-0 h-100 mb-6">
  <a href="{{$link_route}}">
    <img class="card-img-top card-img-scale" src="{{ $sg_product->image }}" alt="{{ $sg_product->name }}">
  </a>
  <div class="card-body text-center">
    <a href="{{$link_route}}" class="card-link text-dark">{{ $sg_product->getShortNameAttribute($sg_product->name) }}</a >
    <h3 class="card-text"><strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($sg_product->retail) }} </strong></h3>
    @if($_existe_shipping && ($sg_product->retail>$_shipping))
      <h5 class="text-success"><strong><i class="fa fa-shipping-fast"></i> Envio Gratis</strong></h5>
    @endif
  </div>
</div>
