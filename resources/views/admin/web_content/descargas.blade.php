@extends('layouts.app_dashboard')
@section('content')
<div class="main">
  @include('admin.web_content.breadcrumb',['item'=>'descargas'])
  <div class="container-fluid">
      @if(Session::has('alert'))
                <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
              @endif
      <div class="row justify-content-center">
          <div class="col-md-4">


              <form action="/web_content/upload" method="post" enctype="multipart/form-data">

                {{ csrf_field() }}

                <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                <div class="form-group">
                  <label for="name">Nombre<span class="text-danger small">*</span></label>
                  <input id="name" type="text" class="form-control {{$errors->has('name')?' is-invalid':''}}" name="name" value="{{ old('name') }}" placeholder="Nombre del documento" required autofocus>
                  @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="description">Descripcion<span class="text-danger small">*</span></label>
                  <input id="description" type="text" class="form-control {{$errors->has('description')?' is-invalid':''}}" name="description" value="{{ old('description') }}" placeholder="Agregue una breve descripcion del documento" required>
                  @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('description') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id="status" name="status">
                    <option value='0'>Active</option>
                    <option value='1'>Inactive</option>
                  </select>
                </div>

                <div class="input-group mb-3">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="document" name="document" required>
                    <label class="custom-file-label" for="document" aria-describedby="inputGroupFileAddonMainImage">Seleecionar Archivo</label>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>

              </form>

          </div>
          <div class="col-md-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)

                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->name }}</td>
                            <td>{{ $document->description }}</td>
                            <td>
                              <a href="{{route('descargas.download_file',['file'=>$document->id])}}">[Descargar]</a>&nbsp;
                              <a href="{{route('dashboard.store.web.descargas.status',['shop_id'=>$shop->id,'file_id'=>$document->id])}}">[{{ $document->status?'Mostrar':'Ocultar' }}]</a>&nbsp;
                              <a href="{{route('dashboard.store.web.descargas.remove',['shop_id'=>$shop->id,'file_id'=>$document->id])}}">[Eliminar]</a>&nbsp;
                            </td>

                        </tr>
                    @empty
                        <tr><td colspan="8">Sin Datos que mostrar</td></tr>
                    @endforelse
                </tbody>
            </table>
          </div>
      </div>
  </div>
</div>
@endsection
