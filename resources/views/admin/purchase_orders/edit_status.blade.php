@extends('layouts.app')
@section('content')
@include('admin.purchase_orders.breadcrumb',['item'=>'edit-status'])
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-10">        	
      
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <h2>Editar  Status : Orden de compra</h2>
      <div class="row">
        <div class="col-2">
           @include('admin.purchase_orders.menu')
        </div>
        <div class="col-10">
          
          <form action="{{ route('purchase-orders.update-status') }} " method="post">
          @csrf

          <div class="form-group">
            <label for="exampleFormControlSelect1">Example select</label>
            <select class="form-control" id="exampleFormControlSelect1">
              @foreach($statuses as $status) 
                <option>{{$status->description}}</option>
              @endforeach
            </select>
          </div>
          
          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>  
        </div>

      </div>
  

    </div>
  </div>
</div>
@endsection

