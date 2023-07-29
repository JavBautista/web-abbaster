@extends('layouts.app_abbaster')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <h2>PROYECTOS</h2>
          <hr>
          <p>Bienvenido/a a Abbaster.com, tu aliado en el mundo del desarrollo y automatización tecnológica.</p> 
          <p>Somos una empresa dedicada a brindar soluciones innovadoras para particulares, empresas e industrias. 
          Nuestro enfoque se centra en ofrecer proyectos a medida que optimizan tus procesos y mejoran la eficiencia en todas las áreas. Explora nuestro sitio y descubre cómo nuestra experiencia y conocimientos pueden transformar tu realidad tecnológica.</p>
          <p>¡Estamos emocionados de acompañarte en este viaje hacia la excelencia tecnológica!</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
            @foreach($projects as $project)

            <div class="col-lg-3">
              <div class="card h-100 mb-2">
                <a href="{{ route('project.detail',['slug'=>$project->slug]) }}">
                  <img class="card-img-top card-img-scale" src="{{ $project->image }}" alt="{{ $project->title }}">
                </a>
                <div class="card-body">
                  <p class="card-title">{{ $project->title }}</p>
                </div>
                <div class="card-footer bg-transparent border-light">
                      <a href="{{ route('project.detail',['slug'=>$project->slug]) }}" class="btn btn-abbaster">Ver detalle <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
              </div>
            </div><!-- /.col-lg-4 -->
            @endforeach
          </div><!-- /.row -->

        </div>
    </div>

    @include('parts.formulario_contacto')


</div>
@endsection
