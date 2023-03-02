@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'sellers.edit.status'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Admin. Afiliados</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
          	<form action="/seller/update/status" method="post">
				{{ csrf_field() }} 
				<input type="hidden" value="{{ $seller->id }}" name="seller_id">
				
				<div class="alert alert-warning">
	                <p><h2>¿Realmente dese cambiar el estatus del afiliado?</h2></p>
	                <p>Actve para ser visible; Inactive para no moastrarse al publico.</p>
				</div>
				
				<div class="form-group">
					<label for="status">Status</label>
					<select class="form-control" id="status" name="status">
						<option value='0' {{ $seller->status==0?'selected':'' }} >Active</option>
						<option value='1' {{ $seller->status==1?'selected':'' }} >Inactive</option>
					</select>
				</div>

              
              <button type="submit" class="btn btn-primary">Submit</button>
			</form>
        </div>
    </div>
</div>
@endsection
