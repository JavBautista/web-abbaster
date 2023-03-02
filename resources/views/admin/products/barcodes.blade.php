@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.products.barcodes'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(Session::has('alert'))
                <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
            @endif
            @if ($errors->has('barcode'))
                <p class="text-center alert alert-danger">{{ $errors->first('barcode') }}</p>
            @endif

            <div class="container-fluid">
                <div class="alert alert-danger text-center">
                    <p><i class="fa fa-warning"></i> IMPORTANTE: Al actualizar el código de barras de un producto debe actualizar los códigos impresos. El código modificado dejara de existir en la BD.</p>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Codigo</th>
                        <td>&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->barcode }}</td>
                            <td>
                                <form class="form-inline" action="/products/barcode/update" method="post">
                                  @csrf
                                  <input type="hidden" value="{{ $product->id }}" name="product_id">
                                  <label class="sr-only" for="barcode">Codigo</label>
                                  <input type="text" class="form-control mb-2 mr-sm-2" id="barcode" name="barcode" value="{{$barcodes[$product->id]}}" required>
                                  <button type="submit" class="btn btn-primary mb-2">Guardar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">Sin Datos que mostrar</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
