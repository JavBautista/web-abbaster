@extends('layouts.app')
@section('content')
@include('admin.cedis.breadcrumb',['item'=>'warehouse.image'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif

      <h2>Imagen</h2>
      @if($warehouse->image)

        <div class="card">
          <img class="card-img-top" src="{{ $warehouse->getImageStore($warehouse->image) }}" alt="{{ $warehouse->name }}" >
          <div class="card-body">
            <form action="{{ route('warehouse.delete.image') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">
              <button type="submit" id="inputGroupFileAddonMainImage" class="btn btn-danger btn-block">Eliminar</button>
            </form>
          </div>
        </div>

      @else
        <div class="row justify-content-center">
          <div class="col-md-10">

            <form action="{{ route('warehouse.upload.image') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" value="{{ $warehouse->id }}" name="warehouse_id">
              <div class="input-group mb-3">
              <div class="custom-file">
              <input type="file" class="custom-file-input" id="image" name="image" required>
              <label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddonMainImage">Seleecionar Archivo</label>
              </div>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

          </div>
        </div>
      @endif


    </div>
  </div>
</div>
@endsection
