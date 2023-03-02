@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            <h2>Store: {{ $category->shop->name }}</h2>
            <h3>Edit Status Categorie {{ $category->name }}</h3>
            <hr>
            <form action="{{ url('/categories/update/status') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $category->id }}" name="category_id">
              
              <div class="alert alert-warning">
                <p><h2>¿Realmente dese cambiar el estatus de la categoria?</h2></p>
                <p>Actve para ser visible; Inactive para no moastrarse al publico.</p>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0' {{ $seller->status==0?'selected':'' }}   >Active</option>
                  <option value='1' {{ $seller->status==1?'selected':'' }}   >Inactive</option>
                </select>
              </div>              
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
