@extends('layouts.app_shops')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="row">
				  <h2>Descargas</h2>
			    @if(Session::has('alert'))
    				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    			@endif
				  <table class="table">
              <thead>
                  <tr>
                      <th>Nombre</th>
                      <th>Descripcion</th>
                      <th>&nbsp;</th>

                  </tr>
              </thead>
              <tbody>
                  @forelse($documents as $document)

                      <tr>
                          <td>{{ $document->name }}</td>
                          <td>{{ $document->description }}</td>
                          <td><a href="{{route('euderm.descargas.download.file',['file'=>$document->id])}}">[Descargar]</a></td>

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