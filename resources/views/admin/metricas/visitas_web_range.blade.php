@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.metricas.breadcrumb',['item'=>'visitas.web.range'])
	<visitas-web-range></visitas-web-range>
@endsection
