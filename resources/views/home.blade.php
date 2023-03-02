@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                @php
                    $title_user=(Auth::user()->hasRole('admin'))? 'Administrador' : 'Usuario';
                @endphp
                
                <div class="card-header">Dashboard {{ $title_user }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->hasRole('admin'))                        
                        <div class="list-group">
                          @forelse($shops as $shop)                                
                                <a href="{{ url('/admin/store', $shop->id ) }}" class="list-group-item list-group-item-action">{{ $shop->name }}</a>
                            @empty
                                <p>Sin Datos</p>
                            @endforelse
                          </div>                     
                    @else
                        <div>Acceso usuario</div>
                    @endif                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
