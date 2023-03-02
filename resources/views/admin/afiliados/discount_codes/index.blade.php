@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'discount_codes.index'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Codigos de Descuento</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif

			<p><a href="/dashboard/afiliados/discount-codes/add" class="btn btn-outline-primary float-right mb-2">Nuevo Codigo</a></p>    
          	<table class="table">
                <thead>
                    <tr>
						<th>Codigo</th>
						<th>Status</th>
						<th>Tipo Codigo</th>
						<th>Tipo Descuento</th>
						<th>Descuento</th>
						<th>Num. Usos</th>
						<th>Usos Permitidos</th>
						<th>Inicio</th>
						<th>Finalizacion</th>
						<th>Afilaido</th>
						<th>Tienda</th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($discount_codes as $discount_code)

                        <tr>
							<td>{{ $discount_code->code}}</td>
							<td>{{ $discount_code->status?'Inactivo':'Activo' }}</td>
							<td>{{ $discount_code->type_code?'Promocion':'Afiliado'}}</td>
							<td>{{ ucfirst($discount_code->type_discount) }}</td>
							<td>{{ $discount_code->discount}}</td>
							<td>{{ $discount_code->number_uses}}</td>
							<td>{{ $discount_code->limit_uses}}</td>
							<td>{{ $discount_code->start_date}}</td>
							<td>{{ $discount_code->finish_date}}</td>
							<td>{{ $data_joins[ $discount_code->id ]['seller_name'] }}</td>
							<td>{{ $data_joins[ $discount_code->id ]['shop_name'] }}</td>
							<td>
								<a href="{{ route('discoount_code.remove',['code_id'=>$discount_code->id])}}">[Eliminar]</a>
								<a href="{{ route('discoount_code.edit.status',['code_id'=>$discount_code->id])}}">[{{$discount_code->status?'Activar':'Deshabilitar'}}]</a>
							</td>
                        </tr>
                    @empty
                        <tr><td colspan="8">Sin Datos que mostrar</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $discount_codes->links() }}
            

        </div>
    </div>
</div>
@endsection
