@extends('layouts.app_dashboard')
@section('content')
<main class="main">
@include('admin.breadcrumb',['item'=>'store.proveedores.index'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <p><a href="{{ route('proveedores.add',['shop_id'=>$shop->id]) }}" class="btn btn-outline-primary float-right mb-2">Nuevo Proveedor</a></p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>EMail</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->description }}</td>
                        <td>{{ $proveedor->name }}</td>
                        <td>{{ $proveedor->address }}</td>
                        <td>{{ $proveedor->phone }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>@php echo ($proveedor->status)?'Activo':'Baja'; @endphp </td>
                        <td><a href="{{ route('proveedores.view',['shop_id'=>$shop->id,'proveedor_id'=>$proveedor->id]) }}" class="text text-primary">[Detalle]</a></td>
                        <td><a href="{{ route('proveedores.edit',['shop_id'=>$shop->id,'proveedor_id'=>$proveedor->id]) }}" class="text text-primary">[Edit]</a></td>
                        <td><a href="{{ route('proveedores.edit.status',['shop_id'=>$shop->id,'proveedor_id'=>$proveedor->id]) }}" class="text text-secondary">[Status]</a></td>
                        <td><a href="{{ route('proveedores.remove',['shop_id'=>$shop->id,'proveedor_id'=>$proveedor->id]) }}" class="text text-danger">[Remove]</a></td>
                    </tr>
                @empty
                    <tr><td colspan="9">Sin Datos que mostrar</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $proveedores->links() }}
        </div>
    </div>
</div>
</main>
@endsection
