@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.metricas.breadcrumb',['item'=>'visitas.web'])

  <visitas-web></visitas-web>

@endsection
