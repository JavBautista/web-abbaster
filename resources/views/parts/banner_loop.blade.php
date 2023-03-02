@php
  $seccion_banner_loop = getBannerLoop();
@endphp
@if($seccion_banner_loop && isset($seccion_banner_loop->show) && $seccion_banner_loop->show)
  <div class="banner_loop">
    <div class="slider_bl">
      <div class="slide_bl-track">
        @for ($i = 0; $i < 5 ; $i++)
          <div class="slide_bl">
              <img src="{{ $seccion_banner_loop->getImageStore($seccion_banner_loop->image1) }}" height="100" alt="" />
          </div>
          <div class="slide_bl">
            <img src="{{ $seccion_banner_loop->getImageStore($seccion_banner_loop->image2) }}" height="100" alt="" />
          </div>
          <div class="slide_bl">
            <img src="{{ $seccion_banner_loop->getImageStore($seccion_banner_loop->image3) }}" height="100" alt="" />
          </div>
          <div class="slide_bl">
            <img src="{{ $seccion_banner_loop->getImageStore($seccion_banner_loop->image4) }}" height="100" alt="" />
          </div>
        @endfor

        </div>
      </div>
    </div>
  </div>
@endif