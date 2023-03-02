@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'web_content.testimonios.edit_img'])
<div class="container">

      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      <div class="card mt-4">
        <div class="card-header">Editar Imagen {{$testimonio->autor}} </div>
        <div class="card-body">
		      @if($testimonio->image)

		        <div class="card">
		          <img class="card-img-top" src="{{ $testimonio->getImageStore($testimonio->image) }}" alt="{{ $testimonio->name }}" width="25%">
		          <div class="card-body">
		            <form action="{{ route('global.testimonio.delete.image') }}" method="post" enctype="multipart/form-data">
		              @csrf
		              <input type="hidden" name="testimonio_id" value="{{ $testimonio->id }}">
		              <button type="submit" id="inputGroupFileAddonMainImage" class="btn btn-danger btn-block">Eliminar</button>
		            </form>
		          </div>
		        </div>
					@else
			        <div class="row justify-content-center">
			          <div class="col-md-10">

			            <form action="{{ route('global.testimonio.upload.image') }}" method="post" enctype="multipart/form-data">
			              @csrf
			              <input type="hidden" value="{{ $testimonio->id }}" name="testimonio_id">
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


</div><!--./container-->
@endsection