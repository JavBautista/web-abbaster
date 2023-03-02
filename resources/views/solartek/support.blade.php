@extends('layouts.app_eagletek')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        	<div class="row">

				<div class="col-md-4">
	              <div class="card mb-4 shadow-sm">
	                <img class="card-img-top" src="http://lorempixel.com/400/200/?{{ random_int(100,500) }}" width="100px" alt="Card image cap">
	                <div class="card-body">
	                  <p class="card-text">Manuales</p>
	                  <button type="button" class="btn btn-lg btn-block btn-primary">Ver mas...</button>
	                </div>
	              </div>
	            </div>   

	            <div class="col-md-4">
	              <div class="card mb-4 shadow-sm">
	                <img class="card-img-top" src="http://lorempixel.com/400/200/?{{ random_int(100,500) }}" width="100px" alt="Card image cap">
	                <div class="card-body">
	                  <p class="card-text">Software</p>
	                  <button type="button" class="btn btn-lg btn-block btn-primary">Ver mas...</button>
	                </div>
	              </div>
	            </div>                

            </div>
        </div>
    </div>
</div>
@endsection