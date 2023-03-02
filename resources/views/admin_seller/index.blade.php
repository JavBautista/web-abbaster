@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Vendedores</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <h2 class="mt-2">Admin Vendedores</h2>        
             <a href="/vendedores/tabla-porcentajes" class="list-group-item list-group-item-action">Tabla de Procentajes</a>
             <a href="/vendedores/ventas" class="list-group-item list-group-item-action">Mis Ventas</a>
             <a href="#" class="list-group-item list-group-item-action">Comisiones</a>
             

 
        </div>
    </div>
</div>
@endsection
