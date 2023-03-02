@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'discount_codes.add'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Codigos de Descuento</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
          	<form action="/discount-code/create" method="post">
				{{ csrf_field() }} 		
				<h3>Codigo: {{$key}}</h3>
<!--
				<input type="hidden" value="{ { $key }}" name="code">
-->
				<div class="form-group">
					<label for="code">Code<span class="text-danger small">*</span></label>                
					<input id="code" type="text" class="form-control {{$errors->has('code')?' is-invalid':''}}" name="code" value="{{ $key }}" readonly>
					@if ($errors->has('code'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('code') }}</strong>
						</span>
					@endif          
				</div>

				<div class="form-group">
					<label for="status">Status<span class="text-danger small">*</span></label>
					<select class="form-control" id="status" name="status">
						<option value='0'>Active</option>
						<option value='1'>Inactive</option>
					</select>
				</div>
						
				<div class="form-group">
					<label for="start_date">Fceha Inicio<span class="text-danger small">*</span></label>                
					<input id="start_date" type="text" class="datepicker form-control {{$errors->has('start_date')?' is-invalid':''}}" name="start_date" value="{{ old('start_date',$start_date) }}"  required>
					@if ($errors->has('start_date'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('start_date') }}</strong>
						</span>
					@endif          
				</div>

				<div class="form-group">
					<label for="finish_date">Fceha Fin<span class="text-danger small">*</span></label>                
					<input id="finish_date" type="text" class="datepicker form-control {{$errors->has('finish_date')?' is-invalid':''}}" name="finish_date" value="{{ old('finish_date',$finish_date) }}"  required>
					@if ($errors->has('finish_date'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('finish_date') }}</strong>
						</span>
					@endif          
				</div>
								
				
				<div class="form-group">
					<label for="type_code">Tipo de Codigo<span class="text-danger small">*</span></label>
					<select class="form-control" id="type_code" name="type_code">
						<option value='0'>Para Afiliado</option>
						<option value='1'>De Promocion</option>
					</select>
				</div>
				<div class="form-group">
					<label for="type_discount">Tipo de Decsuento<span class="text-danger small">*</span></label>
					<select class="form-control" id="type_discount" name="type_discount">
						<option value='monto'>$ Monto</option>
						<option value='porcentaje'>% Porcentaje</option>
					</select>
				</div>

				<div class="form-group">
					<label for="discount">Discount<span class="text-danger small">*</span></label>                
					<input id="discount" type="number" min="0" step="1" class="form-control {{$errors->has('discount')?' is-invalid':''}}" name="discount" value="{{ old('discount',0) }}"  required>
					@if ($errors->has('discount'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('discount') }}</strong>
						</span>
					@endif          
				</div>

				<div class="form-group">
					<label for="limit_uses">Limite Usos<span class="text-danger small">*</span></label>
					<select class="form-control" id="limit_uses" name="limit_uses">
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
					</select>
				</div>


				<div class="form-group">
					<label for="shop">Tienda<span class="text-danger small">*</span></label>
					<select class="form-control" id="shop" name="shop">
						<option value='0'>Todas</option>
						@foreach($shops as $shop)                                      
                        	<option value="{{ $shop->id }}">{{ $shop->name }}</option>
                  		@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="seller">Afiliado<span class="text-danger small">*</span></label>
					<select class="form-control" id="seller" name="seller">
						<option value='0'>Todas</option>
						@foreach($sellers as $seller)                                      
                        	<option value="{{ $seller->id }}">{{ $seller->name }}</option>
                  		@endforeach	
					</select>
				</div>


				

              
              <button type="submit" class="btn btn-primary">Submit</button>
			</form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
