@extends('layouts.app')
@section('content')
@include('admin.purchase_orders.breadcrumb',['item'=>'create'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">        	
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <h2>Nueva Orden de Compra</h2>

      <form class="needs-validation" action="{{ route('purchase-orders.store') }} " method="post">
<!--
proveedor
folio_proveedor
precio_dolar
fecha_entrega_estimada
documento_adjunto
observaciones
-->
        @csrf


        <div class="form-group">
            <label for="proveedor">Proveedor<span class="text-danger small">*</span></label>
            <input type="text" class="form-control {{($errors->has('proveedor'))?'is-invalid':'' }}" id="proveedor" name="proveedor" placeholder="Ingrese nombre o descripción del proveedor" value="{{ old('proveedor','') }}" required>
            @if($errors->has('proveedor'))
              @foreach($errors->get('proveedor') as $error)
                <div class="invalid-feedback">{{ $error }}</div>
              @endforeach          
            @endif
        </div>



        
        <div class="form-group">
          <label for="folio_proveedor">Folio externo de proveedor</label>
          <input type="text" class="form-control" id="folio_proveedor" name="folio_proveedor" placeholder="Ingrese folio o numero proporcionado por el proveedor">
        </div>

        <div class="form-group">
          <label for="precio_dolar">Precio del dolar<span class="text-danger small">*</span></label>
          <input type="number" min="0" step="0.01" class="form-control {{($errors->has('precio_dolar'))?'is-invalid':'' }}" id="precio_dolar" name="precio_dolar" placeholder="Ingrese precio del dolar actual" value="{{ old('precio_dolar','') }}" required>
          @if($errors->has('precio_dolar'))
              @foreach($errors->get('precio_dolar') as $error)
                <div class="invalid-feedback">{{ $error }}</div>
              @endforeach          
          @endif
        </div>

        <div class="form-group">
          <label for="fecha_entrega_estimada">Fecha de entrega estimada<span class="text-danger small">*</span></label>                
          <input id="fecha_entrega_estimada" name="fecha_entrega_estimada" type="text" class="datepicker form-control {{$errors->has('fecha_entrega_estimada')?' is-invalid':''}}" value="{{ old('fecha_entrega_estimada',$start_date) }}" required> 
          @if($errors->has('fecha_entrega_estimada'))
              @foreach($errors->get('fecha_entrega_estimada') as $error)
                <div class="invalid-feedback">{{ $error }}</div>
              @endforeach          
          @endif    
        </div>

        <div class="form-group">
          <label for="observaciones">Obsrevaciones</label>
          <textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
        </div>

        <button class="btn btn-primary" type="submit">Guardar</button>
      </form>
      
    </div>
  </div>
</div>
@endsection
