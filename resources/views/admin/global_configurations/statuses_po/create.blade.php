@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'statuses_po.create'])
<div class="container">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      <div class="card mt-4">
        <div class="card-header">Nuevo Estatus de ordenes de compra</div>
        <div class="card-body">
          <form action="/statuses_po/store" method="post">
            @csrf
            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Descripción" required>
            </div>
            <button class="btn btn-primary" type="submit">Guardar</button>
          </form>
        </div>
      </div>
</div>

@endsection
