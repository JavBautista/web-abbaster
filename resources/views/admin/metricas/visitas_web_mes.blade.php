@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.metricas.breadcrumb',['item'=>'visitas.web.mes'])
  <visitas-web-mes></visitas-web-mes>

@endsection
