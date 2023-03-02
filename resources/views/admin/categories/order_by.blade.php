@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.categories.orderby'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(Session::has('alert'))
                <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
            @endif
            @if ($errors->has('slug'))
                <p class="text-center alert alert-danger">{{ $errors->first('slug') }}</p>
            @endif 
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Orden Actual</th>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->order_by }}</td>
                            <td>
                                <form class="form-inline" action="/categories/order-by/update" method="post">
                                  {{ csrf_field() }} 
                                  <input type="hidden" value="{{ $category->id }}" name="category_id">
                                  <input type="hidden" value="up" name="command">
                                  <button type="submit" class="btn btn-primary mb-2">Subir</button>
                                </form>
                            </td>
                            <td>
                                <form class="form-inline" action="/categories/order-by/update" method="post">
                                  {{ csrf_field() }} 
                                  <input type="hidden" value="{{ $category->id }}" name="category_id">
                                  <input type="hidden" value="down" name="command">
                                  <button type="submit" class="btn btn-primary mb-2">Bajar</button>
                                </form>                                
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">Sin Datos que mostrar</td></tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection
