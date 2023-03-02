@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'scripts.index'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
          <h2>Nuevo Script</h2>
            <form action="/scripts/create" method="post">
              {{ csrf_field() }} 
              
              <div class="form-group">
                <label for="title">Title</label>                
                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}"  required autofocus>
                @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif          
              </div>

              <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="9">{{ old('content') }}</textarea>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0'>Active</option>
                  <option value='1'>Inactive</option>
                </select>
              </div>
                           
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
</div>
@endsection
