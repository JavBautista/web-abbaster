@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/dashboard/users/scripts">Scripts</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">         

            <h2 class="mt-4">{{ $script->title}}</h2>
            <hr>
            <pre><p class="text-justify">{{ $script->content }}</p></pre>        
        </div>
    </div>
</div>
@endsection
