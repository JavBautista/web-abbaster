@extends('layouts.app_dashboard')
@section('content')
<main class="main">
@include('admin.breadcrumb',['item'=>'store.categories.index'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <p><a href="{{ route('categories.add',['shop_id'=>$shop->id]) }}" class="btn btn-outline-primary float-right mb-2">Nueva Categoria</a></p>
            <p><a href="{{ route('categories.slugs',['shop_id'=>$shop->id]) }}" class="btn btn-secondary mb-2">Admin. Slugs</a> &nbsp;<a href="{{ route('categories.order_by',['shop_id'=>$shop->id]) }}" class="btn btn-secondary mb-2">Admin. Orden</a></p>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Root</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)

                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug?'Si':'No'}}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @php
                                echo isset($array_roots[$category->root])?$array_roots[$category->root]:'Padre';
                                @endphp
                            </td>
                            <td>@php echo ($category->status)?'Activo':'Baja'; @endphp </td>
                            <td><a href="{{ route('categories.view',['category_id'=>$category->id]) }}" class="text text-primary">[Detalle]</a></td>
                            <td><a href="{{ route('categories.edit',['category_id'=>$category->id]) }}" class="text text-primary">[Editar]</a></td>
                            <td><a href="{{ route('categories.image',['category_id'=>$category->id]) }}">[Image]</a></td>
                            <td><a href="{{ route('categories.edit.status',['category_id'=>$category->id]) }}" class="text text-secondary">[Status]</a></td>
                            <td><a href="{{ route('categories.remove',['category_id'=>$category->id]) }}" class="text text-danger">[Remove]</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8">Sin Datos que mostrar</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
</div>
</main>
@endsection
