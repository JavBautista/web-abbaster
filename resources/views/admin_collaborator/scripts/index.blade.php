@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Scripts</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">         

            <h2 class="mt-4">Scripts</h2>
            <div class="list-group mt-2">
                @forelse($scripts as $script)             
                    <a href="{{ route('users.scripts.show',['script_id'=>$script->id]) }}" class="list-group-item list-group-item-action">{{ $script->title }}</a>
                @empty
                    <li class="list-group-item">Sin Datos que mostrar</li>
                @endforelse

            </div>        
            {{ $scripts->links() }}

        </div>
    </div>
</div>
@endsection
