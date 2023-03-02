@extends('layouts.app_dashboard')
@section('content')
<div class="main">
    @include('admin.breadcrumb',['item'=>'store.configuraciones.edit_shipping'])
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(Session::has('alert'))
    				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    			@endif

                <form action="/configurations/update" method="post">
                  {{ csrf_field() }}

                  <input type="hidden" value="{{ $shop->id }}" name="shop_id">
                  <input type="hidden" value="{{ $shipping_id }}" name="shipping_id">
                  <input type="hidden" value="{{ $tipo_shipping }}" name="tipo_shipping">

                  <div class="form-group">
                    <label for="shipping_cost">Costo del envio:</label>
                    <input id="shipping_cost" type="number" min="0" step="1" class="form-control{{ $errors->has('shipping_cost') ? ' is-invalid' : '' }}" name="shipping_cost" value="{{ old('shipping_cost',$shipping_cost) }}"  required autofocus>
                    @if ($errors->has('shipping_cost'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('shipping_cost') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="shipping_from">Envio a partir de:</label>
                    <input id="shipping_from" type="number" min="0" step="1" class="form-control{{ $errors->has('shipping_from') ? ' is-invalid' : '' }}" name="shipping_from" value="{{ old('shipping_from',$shipping_from) }}"  required>
                    @if ($errors->has('shipping_from'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('shipping_from') }}</strong>
                        </span>
                    @endif
                  </div>


                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
