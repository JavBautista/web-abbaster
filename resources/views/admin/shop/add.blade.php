@extends('layouts.app_main_dashboard')

@section('content')
<div class="container">
  <div class="card mt-4">
    <div class="card-body">
      <h2>Nueva Tienda</h2>

      <form action="/admin/stores/create" method="post">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="name">Nombre de la tienda</label>
          <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" aria-describedby="nameStorelHelp" placeholder="Enter Store Name">
          <small id="nameStorelHelp" class="form-text text-muted">Ingrese nombre de la tienda.</small>
          @if($errors->has('name'))
            @foreach($errors->get('name') as $error)
              <div class="invalid-feedback">{{ $error }}</div>
            @endforeach
          @endif
        </div>

        <div class="form-group">
          <label for="description">Descripción</label>
          <input type="text" class="form-control" id="description" name="description" placeholder="Enter Store Description">
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" id="status" name="status">
            <option value='0'>Activa</option>
            <option value='1'>Inactiva</option>
          </select>
        </div>

        <div class="form-group">
          <label for="dynamic">Tipo de tienda</label>
          <select class="form-control" id="dynamic" name="dynamic">
            <option value='0'>Manual</option>
            <option value='1'>Dinamica</option>
          </select>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection
