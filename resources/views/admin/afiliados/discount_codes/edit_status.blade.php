@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'discount_codes.edit.status'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
          	<form action="/discount-code/update/status" method="post">
				{{ csrf_field() }} 
				<input type="hidden" value="{{ $discount_code->id }}" name="discount_code_id">
				
				<div class="alert alert-warning">
	                <p><h2>¿Realmente dese cambiar el estatus del codigo {{ $discount_code->code }}?</h2></p>
	                <p>Activo para ser visible; Inactivo para no poder usarse.</p>
				</div>
				
				<div class="form-group">
					<label for="status">Status</label>
					<select class="form-control" id="status" name="status">
						<option value='0' {{ $discount_code->status==0?'selected':'' }} >Activo</option>
						<option value='1' {{ $discount_code->status==1?'selected':'' }} >Inactivo</option>
					</select>
				</div>

              
              <button type="submit" class="btn btn-primary">Submit</button>
			</form>
        </div>
    </div>
</div>
@endsection
