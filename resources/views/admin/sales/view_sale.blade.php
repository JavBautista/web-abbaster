@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.sales.view'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <h2>Detalle de la Compra #{{ $purchase->id }}</h2>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="alert alert-info text-center">
                        <h4>Estatus: {{ $sale_status }}</h4>
                    </div>
                    <div class="row">
                        <div class="col">
                            <dl class="row">
                                <dt class="col-sm-3"> Metodo de pago</dt>
                                <dd class="col-sm-9">{{ $purchase->payment_method }}</dd>

                                <dt class="col-sm-3"> Tracking</dt>
                                <dd class="col-sm-9">{{ $purchase->tracking_number }}</dd>

                                <dt class="col-sm-3"> Creación</dt>
                                <dd class="col-sm-9">{{ $purchase->created_at }}</dd>

                                <dt class="col-sm-3"> Observaciones</dt>
                                <dd class="col-sm-9">{{ $purchase->observations }}</dd>
                            </dl>
                        </div>
                    </div>
                </div><!--./card-body-->
            </div><!--./card-->


            <div class="row">

                    <div class="col-6">
                        <div class="card">
                          <div class="card-header">Detalle de la compra</div>
                         <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Qty</th>
                                        <th>Costo</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->PurchaseDetail; as $row)
                                        @php
                                            $sub=$row->price * $row->qty;
                                        @endphp
                                        <tr>
                                            <td class="small">
                                                @if(isset($row->product->image))
                                                    <img src="{{$row->product->image }}" alt="{{$row->key }}" class="img-thumbnail" width="50px">
                                                @endif
                                                <p><strong>{{$row->name}}</strong></p></td>
                                            <td class="small">{{$row->qty}}</td>
                                            <td class="small">${{ number_format($row->price,2)}}</td>
                                            <td class="small">${{ number_format($sub,2)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="3"><strong>Subtotal</strong></td>
                                        <td><strong><em>${{ $purchase->subtotal }}</em></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3"><strong>Envio</strong></td>
                                        <td><strong><em>${{ $purchase->shipping }}</em></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3"><strong>Descuento</strong></td>
                                        <td><strong><em> ${{ $purchase->discount }}</em></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right" >
                                            <h4><strong> TOTAL MXN ${{ number_format($purchase->total,2) }} </strong></h4>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                         </div>
                     </div>


                    </div><!--./col-6-->

                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">Datos de la compra</div>
                            <div class="card-body">
                                <dl class="row small">
                                    <dt class="col-sm-4"> Email</dt>
                                    <dd class="col-sm-8">{{ $customer->mail }}</dd>

                                    <dt class="col-sm-4"> Quien recibe</dt>
                                    <dd class="col-sm-8">{{ $purchase->name }}</dd>

                                    <dt class="col-sm-4"> Teléfono</dt>
                                    <dd class="col-sm-8">{{ $purchase->phone }}</dd>

                                    <dt class="col-sm-4"> Móvil</dt>
                                    <dd class="col-sm-8">{{ $purchase->movil }}</dd>



                                    <dt class="col-sm-4"> Dirección</dt>
                                    <dd class="col-sm-8">{{ $purchase->address }} {{ $purchase->number_out }} {{ $purchase->number_int }} {{ $purchase->district }}<br> {{ $purchase->zip_code }} <br> {{ $purchase->city }} {{ $purchase->state }}</dd>


                                    <dt class="col-sm-4"> Referencia</dt>
                                    <dd class="col-sm-8">{{ $purchase->reference }}</dd>

                                    <dt class="col-sm-4"> Detalles</dt>
                                    <dd class="col-sm-8">{{ $purchase->detail }}</dd>
                                </dl>
                            </div>
                        </div>

                        @if ($existe_curso)
                            <div class="card">
                                <div class="card-header">Existen Cursos</div>
                                <div class="card-body">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                    @endif
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Curso</th>
                                                <th>Estado</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cursos as $data)
                                                <tr>
                                                    <td class="small">{{$data['curso']}}</td>
                                                    <td class="small">
                                                        @if ($data['asignado']==0)
                                                            <span class="badge badge-warning">Inhabilitado</span>
                                                        @else
                                                            <span class="badge badge-success">Habilitado</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($data['asignado']==0)
                                                        <form method="post" action="{{route('customer.course.store', [
                                                              'shop_id'=>$shop->id,
                                                              'sale_id'=>$purchase->id,
                                                              'course_id'=>$data['curso_id'],
                                                              'customer_id'=>$customer->id
                                                            ] )}}">
                                                            @method('POST')
                                                            @csrf
                                                            <button type="submit" class="btn btn-info btn-sm">Permitir acceso</button>
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        @endif


                    </div><!--./col-6-->

            </div><!--./row-->

        </div><!--./col-md-10-->
    </div><!--./row-->

</div>
@endsection
