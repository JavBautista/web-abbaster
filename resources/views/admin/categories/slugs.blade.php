@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.categories.slugs'])
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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <td>&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <form class="form-inline" action="/categories/slug/update" method="post">
                                  {{ csrf_field() }} 
                                  <input type="hidden" value="{{ $category->id }}" name="category_id">
                                  <label class="sr-only" for="slug">Slug</label>
                                  <input type="text" class="form-control mb-2 mr-sm-2" id="slug" name="slug" value="{{$slugs[$category->id]}}" required>
                                  <button type="submit" class="btn btn-primary mb-2">Guardar</button>
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
