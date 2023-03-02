@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.metricas.breadcrumb',['item'=>'visitas.products'])

  <visitas-productos></visitas-productos>

@endsection
