@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.sales.edit.tracking'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('admin.sales.part_info_sale')

            <form action="{{ url('/sales/update/tracking') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $purchase->id }}" name="purchase_id">
              <input type="hidden" value="{{ $shop->id }}" name="shop_id">

               <div class="form-group">
                <label for="tracking_number">Tracking Number</label>                
                <input id="tracking_number" type="text" class="form-control{{ $errors->has('tracking_number') ? ' is-invalid' : '' }}" name="tracking_number" value="{{ old('tracking_number') }}"  required autofocus>
                @if ($errors->has('tracking_number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('tracking_number') }}</strong>
                    </span>
                @endif          
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            
            </form>
            
    </div><!--./row-->

</div>
@endsection
