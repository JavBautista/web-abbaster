@extends('layouts.app_dashboard')
@section('content')
<main class="main">
  <div class="container">
      <div class="card mt-4 mb-4">
        <div class="card-body">
          Bienvenido a {{ $shop->name }} seleecione una opcion del menu lateral.
        </div>
  </div>
</main>
@endsection
