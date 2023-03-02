@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <h2 class="mt-2">Admin Usuario</h2>
            <div class="list-group mt-4">                 
                <a href="dashboard/users/scripts" class="list-group-item list-group-item-action">Scripts</a>
            </div>
 
        </div>
    </div>
</div>
@endsection
