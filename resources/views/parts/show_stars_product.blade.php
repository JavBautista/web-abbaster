<div class="txt-orange float-right">
    <!--<span class="fas fa-star-half-alt"></span>-->
    @php
        $entero = floor($num_stars);
        $fraccion = $num_stars - $entero;
        $resto = 5 - ceil($num_stars);
    @endphp

    @for($i=0;$i<$entero;$i++)
        <span class="fas fa-star"></span>
    @endfor

    @if($fraccion)
        <span class="fas fa-star-half-alt" />
    @endif

    @for($i=0;$i<$resto;$i++)
        <span class="far fa-star"></span>
    @endfor

</div>