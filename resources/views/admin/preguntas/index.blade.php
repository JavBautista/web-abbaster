@extends('layouts.app_dashboard')
@section('content')
<main class="main">
@include('admin.breadcrumb',['item'=>'store.preguntas.index'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
            <h2>PREGUNTAS</h2>
            @forelse($questions as $question)
                <hr>
                <div class="row">
                  <div class="col col-md-3">
                    <div class="container" style="width: 12rem;">
                      <img class="card-img-top" src="{{ $question->product->image }}" alt="{{ $question->product->name }}">
                    </div>
                  </div>
                  <div class="col col-md-9">
                    <h5>{{ $question->product->name }} <br> <span class="small text-muted">{{ $question->created_at }}</span></h5>
                    <p>{{ $question->question }}</p>
                    <form action="/preguntas/answers/add" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" value="{{ $question->id }}" name="question_id">
                      <div class="form-group">
                        <textarea require class="form-control" id="answer" name="answer" rows="3">{{ old('answer') }}</textarea>
                      </div>
                      <div class="row">
                        <div class="col-6"><button type="submit" class="btn btn-eagletek">Responder</button></div>
                        <div class="col-6">
                          <ul class="nav justify-content-end">
                          <li class="nav-item">
                          <a class="nav-link text-danger" href="{{ route('questions.delete',['id'=>$question->id]) }}"><span class="fa fa-trash"></span>&nbsp;Borrar</a>
                          </li>
                          </ul>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
            @empty
                <p>Sin Datos que mostrar</p>
            @endforelse

        </div>
    </div>
</div>
</main>
@endsection
