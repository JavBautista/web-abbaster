@extends('layouts.app_main_dashboard')
@section('content')
<div class="container">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      <div class="card mt-4">
 				<div class="card-header">Estatus de ordenes de compra</div>
 				<div class="card-body">
      		<a href="{{ route('global-configurations.statuses_po.create') }}" class="btn btn-primary">Nuevo Registro</a>
					<table class="table mt-2">
							<thead>
					        <tr>
					            <th>ID</th>
					            <th>Description</th>
					        </tr>
					    </thead>
					    <tbody>
					    @forelse($statuses as $status)
					        <tr>
					        	<td>{{ $status->id }}</td>
					        	<td>{{ $status->description }}</td>
					        	<td></td>
					        </tr>
					    @empty
					        <tr><td colspan="2">Sin Datos que mostrar</td></tr>
					    @endforelse
					    </tbody>
					</table>
				</div>
      </div>
</div>
@endsection
