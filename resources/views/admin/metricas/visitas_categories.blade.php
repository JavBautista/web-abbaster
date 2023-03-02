@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.metricas.breadcrumb',['item'=>'visitas.categories'])

  <visitas-categorias></visitas-categorias>

@endsection
