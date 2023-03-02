@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'sellers.view'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-5">

			<dl class="row">        			
				<dt class="col-sm-3"> Email</dt>
				<dd class="col-sm-9">{{ $seller->mail }}</dd>

				<dt class="col-sm-3"> Nombre</dt>
				<dd class="col-sm-9">{{ $seller->name }}</dd>

				<dt class="col-sm-3"> Telefono</dt>
				<dd class="col-sm-9">{{ $seller->phone }}</dd>

				<dt class="col-sm-3"> Movil</dt>
				<dd class="col-sm-9">{{ $seller->movil }}</dd>

				<dt class="col-sm-3"> CP</dt>
				<dd class="col-sm-9">{{ $seller->zip_code }}</dd>

				<dt class="col-sm-3"> Direccion</dt>
				<dd class="col-sm-9">{{ $seller->address }}</dd>

				<dt class="col-sm-3"> Colonia</dt>
				<dd class="col-sm-9">{{ $seller->district }}</dd>

				<dt class="col-sm-3"> Ciudad</dt>
				<dd class="col-sm-9">{{ $seller->city }}</dd>

				<dt class="col-sm-3"> Estado</dt>
				<dd class="col-sm-9">{{ $seller->state }}</dd>
			</dl>

        </div>
		<div class="col-md-5">

			<dl class="row">  
				@forelse($discount_codes as $discount_code)      			
					<dt class="col-sm-3"> Codigo</dt>
					<dd class="col-sm-9">{{ $discount_code->code }}</dd>
				@empty
                	<h3>Sin codigos asignados.</h3>
                @endforelse
			</dl>

		</div>


    </div>
</div>
@endsection
