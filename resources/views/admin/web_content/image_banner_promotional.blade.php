@extends('layouts.app_dashboard')
@section('content')
<div class="main">
	@include('admin.web_content.breadcrumb',['item'=>'image_banner_promotional'])
	<div class="container-fluid">
	    @if(Session::has('alert'))
	      <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	    @endif
	    <hr>
	    @if($shop->promotional_banner_image)

		    <div class="card">
			  <img class="card-img-top" src="{{ $shop->getImageStore($shop->promotional_banner_image) }}" alt="{{ $shop->name }}" >
			  <div class="card-body">
			    <form action="{{ route('shop.web_content.delete_banner_promotional') }}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="shop_id" value="{{ $shop->id }}">
					<button type="submit" id="inputGroupFileAddonMainImage" class="btn btn-danger btn-block">Eliminar</button>
				</form>
			  </div>
			</div>

	    @else
		    <div class="row justify-content-center">
		        <div class="col-md-10">

		          <form action="{{ route('shop.web_content.upload_banner_promotional') }}" method="post" enctype="multipart/form-data">
		              @csrf
		              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
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
@endsection
