@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'scripts.edit'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center alert alert-{{$script->status?'warning':'success'}}">{{$script->status?'Inactivo':'Activo'}}</div>        	
            <form action="/scripts/update" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $script->id }}" name="script_id">
              
              <div class="form-group">
                <label for="title">Title</label>                
                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $script->title ) }}"  required autofocus>
                @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif          
              </div>

              <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="9">{{ old('content', $script->content ) }}</textarea>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0' {{($script->status==0)?'selected':''}} >Active</option>
                  <option value='1' {{($script->status==1)?'selected':''}} >Inactive</option>
                </select>
              </div>
                           
              <button type="submit" class="btn btn-primary">Submit</button>
            </form> 
        </div>
    </div>
</div>
@endsection
