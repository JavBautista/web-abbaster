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
            @forelse($projects as $project)
				<div class="col-lg-3 col-md-6">
	              <div class="card mb-4 shadow-sm">
	                <img class="card-img-top" src="{{ $project->image }}" width="100px" alt="Card image cap">
	                <div class="card-body">
	                	<p class="card-title"><strong>{{ $project->title }}</strong></p>
                        <p>{{ $project->description }}</p>	                  		                	
	                </div>
	              </div>
	            </div>
            @empty
                <h2>No se econtraron resultados de proyectos.</h2>
            @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
