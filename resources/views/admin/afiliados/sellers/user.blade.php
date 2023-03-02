@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'sellers.user'])
<div class="container-fluid">
	@if(Session::has('alert'))
		<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	@endif
    <div class="row justify-content-center">

        <div class="col-md-5">

			<dl class="row">        			
				<dt class="col-sm-3"> Email</dt>
				<dd class="col-sm-9">{{ $seller->mail }}</dd>

				<dt class="col-sm-3"> Nombre</dt>
				<dd class="col-sm-9">{{ $seller->name }}</dd>
				@if($seller->user_id)
				<dt class="col-sm-3"> Usuario de Sistema</dt>
				<dd class="col-sm-9">Activo</dd>
				@endif
			</dl>
			@if(!$seller->user_id)
                <form method="POST" action="/seller/user/create">
                    @csrf                        
                    <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-block">Crear</button>
                        </div>
                    </div>
                </form>
            @endif


        </div>		
    </div>
</div>
@endsection
