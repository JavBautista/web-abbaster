@extends('layouts.app')
@section('content')
@include('admin.afiliados.breadcrumb',['item'=>'sellers.index'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Admin. Afiliados</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif

			<p><a href="{{ route('seller.add') }}" class="btn btn-outline-primary float-right mb-2">Nuevo Afiliado</a></p>    
          	<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mail</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)

                        <tr>
                            <td>{{ $seller->id }}</td>
                            <td>{{ $seller->mail }}</td>
                            <td>{{ $seller->name }}</td>
                            <td>{{ $seller->address }}</td>
                            <td>{{ $seller->phone }}</td>
                            <td>{{ $seller->status?'Baja':'Activo'}}</td>
                            
                            <td><a href="{{ route('seller.view',['seller_id'=>$seller->id]) }}" class="text text-primary">[Detalle]</a></td>
                            <td><a href="{{ route('seller.edit',['seller_id'=>$seller->id]) }}" class="text text-primary">[Editar]</a></td>
                            <td><a href="{{ route('seller.edit.status',['seller_id'=>$seller->id]) }}" class="text text-secondary">[Status]</a></td>
                            <td><a href="{{ route('seller.sysuser',['seller_id'=>$seller->id]) }}" class="text text-secondary">[User]</a></td>
                            <!--
                            <td><a href="{ { route('categories.image',['seller_id'=>$seller->id]) }}">[Image]</a></td>
                            <td><a href="{ { route('categories.remove',['seller_id'=>$seller->id]) }}" class="text text-danger">[Remove]</a></td>-->
                        </tr>
                    @empty
                        <tr><td colspan="8">Sin Datos que mostrar</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $sellers->links() }}
            

        </div>
    </div>
</div>
@endsection
