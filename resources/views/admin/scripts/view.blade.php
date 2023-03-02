@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'scripts.view'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	
        	<div class="text-center alert alert-{{$script->status?'warning':'success'}}">{{$script->status?'Inactivo':'Activo'}}</div>
            <h2 class="mt-4">{{ $script->title}}</h2>
            <hr>
            <pre><p class="text-justify">{{ $script->content }}</p></pre>   

        </div>
    </div>
</div>
@endsection
