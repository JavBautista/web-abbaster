@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'sellers.add'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Admin. Afiliados</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
          	<form action="/seller/update" method="post">
				{{ csrf_field() }} 
				<input type="hidden" value="{{ $seller->id }}" name="seller_id">
				<div class="form-group">
					<label for="mail">Mail</label>                
					<input id="mail" type="text" class="form-control" name="mail" value="{{$seller->mail}}"  readonly>
				</div>
				<div class="form-group">
					<label for="name">Name<span class="text-danger small">*</span></label>                
					<input id="name" type="text" class="form-control {{$errors->has('name')?' is-invalid':''}}" name="name" value="{{ old('name',$seller->name) }}"  required>
					@if ($errors->has('name'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif          
				</div>
				<div class="form-group">
					<label for="phone">Phone<span class="text-danger small">*</span></label>                
					<input id="phone" type="text" class="form-control {{$errors->has('phone')?' is-invalid':''}}" name="phone" value="{{ old('phone',$seller->phone) }}"  required>
					@if ($errors->has('phone'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('phone') }}</strong>
						</span>
					@endif          
				</div>
				<div class="form-group">
					<label for="movil">Movil<span class="text-danger small">*</span></label>                
					<input id="movil" type="text" class="form-control {{$errors->has('movil')?' is-invalid':''}}" name="movil" value="{{ old('movil',$seller->movil) }}"  required>
					@if ($errors->has('movil'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('movil') }}</strong>
						</span>
					@endif          
				</div>
				<div class="form-group">
					<label for="address">Address<span class="text-danger small">*</span></label>                
					<input id="address" type="text" class="form-control {{$errors->has('address')?' is-invalid':''}}" name="address" value="{{ old('address',$seller->address) }}"  required>
					@if ($errors->has('address'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('address') }}</strong>
						</span>
					@endif          
				</div>
				<div class="form-group">
					<label for="zip_code">Zip Code<span class="text-danger small">*</span></label>                
					<input id="zip_code" type="text" class="form-control {{$errors->has('zip_code')?' is-invalid':''}}" name="zip_code" value="{{ old('zip_code',$seller->zip_code) }}"  required>
					@if ($errors->has('zip_code'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('zip_code') }}</strong>
						</span>
					@endif          
				</div>
				<div class="form-group">
					<label for="district">District<span class="text-danger small">*</span></label>                
					<input id="district" type="text" class="form-control {{$errors->has('district')?' is-invalid':''}}" name="district" value="{{ old('district',$seller->district) }}"  required>
					@if ($errors->has('district'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('district') }}</strong>
						</span>
					@endif          
				</div>
				<div class="form-group">
					<label for="city">City<span class="text-danger small">*</span></label>                
					<input id="city" type="text" class="form-control {{$errors->has('city')?' is-invalid':''}}" name="city" value="{{ old('city',$seller->city) }}"  required>
					@if ($errors->has('city'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('city') }}</strong>
						</span>
					@endif          
				</div>
				<div class="form-group">
					<label for="state">State<span class="text-danger small">*</span></label>                
					<input id="state" type="text" class="form-control {{$errors->has('state')?' is-invalid':''}}" name="state" value="{{ old('state',$seller->state) }}"  required>
					@if ($errors->has('state'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('state') }}</strong>
						</span>
					@endif          
				</div>
				
				<div class="form-group">
					<label for="status">Status<span class="text-danger small">*</span></label>
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
