@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard/">Vendedores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tabla de Procentajes</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th>Prodctos</th>
                        <th>1-14 <br>Pzs. Vendidas</th>
                        <th class="table-success">15-20 <br>Pzs. Vendidas</th>
                        <th>20 <br>Pzs. Vendidas</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                      <th scope="row">De 1 a $500.00</th>
                      <td>5%</td>
                      <td class="table-success">10%</td>
                      <td>15%</td>
                    </tr>
                    <tr>
                      <th scope="row">De 501.00 a $1000.00</th>
                      <td>7.5%</td>
                      <td class="table-success">12%</td>
                      <td>15%</td>
                    </tr>
                    <tr class="table-success">
                      <th scope="row">De $1001.00 a $2000.00</th>
                      <td>10%</td>
                      <td>13%</td>
                      <td>15%</td>
                    </tr>
                    <tr>
                      <th scope="row">De $2001.00 en adelante</th>
                      <td>12%</td>
                      <td class="table-success">15%</td>
                      <td>20%</td>
                    </tr>
                </tbody>
            </table>

 
        </div>
    </div>
</div>
@endsection
