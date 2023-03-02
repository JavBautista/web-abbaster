
    @if($shop->promotional_banner_image)
    <img src="{{ $shop->getImageStore($shop->promotional_banner_image) }}" width="100%"  alt="Banner {{$shop->name}}">
    @endif
