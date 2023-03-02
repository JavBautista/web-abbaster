@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Store: {{ $category->shop->name }}</h2>
            <h3>Edit Delete Categorie {{ $category->name }}</h3>
            <hr>
            <form action="{{ url('/categories/delete') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $category->id }}" name="category_id">
              
              <div class="alert alert-danger">
                <p><h2>¿Realmente desea eliminar esta categoria?</h2></p>
                <p>Esta accion borrara la informacion definitivament de la base de datos.</p>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
