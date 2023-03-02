@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'scripts.index'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">        	

            <h2>Scripts</h2>
            @if(Session::has('alert'))
				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
			@endif
          	<p><a href="{{ route('scripts.add') }}" class="btn btn-outline-primary float-right mb-2">Nuevo Script</a></p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Sttaus</th>                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($scripts as $script)             
                    <tr> 
						<td><a href="{{ route('scripts.view',['script_id'=>$script->id]) }}">{{$script->title}}</a></td>
						<td>{{ $script->status ? 'Inactivo':'Activo' }} </td>
						<td><a href="{{ route('scripts.edit',['script_id'=>$script->id]) }}">Editar</a></td>
						<td><a href="{{ route('scripts.remove',['script_id'=>$script->id]) }}">Borar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">Sin Datos que mostrar</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $scripts->links() }}

        </div>
    </div>
</div>
@endsection
