@extends('layouts.app')
@section('content')
@include('admin.cedis.breadcrumb',['item'=>'warehouse.create'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif

      <h2>Nuevo Almacen</h2>

      <form class="needs-validation" action="{{ route('warehouse.store') }} " method="post">
        @csrf
        <div class="form-group">
            <label for="name">Nombre<span class="text-danger small">*</span></label>
            <input type="text" class="form-control {{($errors->has('name'))?'is-invalid':'' }}" id="name" name="name" placeholder="Ingrese nombre o descripción del proveedor" value="{{ old('name','') }}" required>
            @if($errors->has('name'))
              @foreach($errors->get('name') as $error)
                <div class="invalid-feedback">{{ $error }}</div>
              @endforeach
            @endif
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
      </form>

    </div>
  </div>
</div>
@endsection
