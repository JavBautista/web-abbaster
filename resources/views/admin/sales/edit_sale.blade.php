@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.sales.edit'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(Session::has('alert'))
                <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
            @endif 
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
                         <div class="card-body">

                            <h5>Detalle</h5>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>

                                        <th >Producto</th>
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
                                                <p>{{$row->name}}</p>
                                            </td>
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
                            <div class="card-body">

                                <h5>Datos de la compra</h5>
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

                    </div><!--./col-6-->

            </div><!--./row-->


            <h3>Opciones de modificación</h3>
            <div class="card-group">
                
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Actualice el costo del envio</h5>
                        <p>
                        @if($purchase->shipping>0)                                                     
                            <form action="/sales/remove/shipping" method="post">
                                @csrf
                                <input type="hidden" name='purchase_id' value="{{ $purchase->id }}">
                                <button type="submit" class="btn btn-warning btn-block mb-4 mx-2">Quitar Envio</button>
                            </form>
                        @else                              
                            <form action="/sales/restore/shipping" method="post">
                                @csrf
                                <input type="hidden" name='purchase_id' value="{{ $purchase->id }}">
                                <button type="submit" class="btn btn-info btn-block mb-4 mx-2">Restaurar Envio</button>
                            </form>
                        @endif
                        </p>
                    </div>
                </div><!--./card 1-->
           
                <div class="card">
                    <div class="card-body">  
                        <h5 class="card-title text-center">Actualice el costo de la Nota</h5> 
                        <div class="alert alert-danger text-center">
                            <p>Verifique el <strong>costo</strong> antes de propocionarle al cliente la confirmación de pago.</p>
                        </div>
                        <form action="/sales/update/total" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name='purchase_id' value="{{ $purchase->id }}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tipo-modificacion">Tipo de actualizacion</label>
                                    <select class="custom-select" name="tipo-modificacion">
                                        <option value="total">Modificar directamente Total</option>
                                        <option value="monto">Monto a descontar</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="monto">Monto</label>
                                    <input type="number" min="0" step="1.0" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" id="monto" name="monto" placeholder="0" value="{{ old('title') }}" required>
                                    @if ($errors->has('monto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('monto') }}</strong>
                                        </span>
                                    @endif  
                                </div>  
                            </div>
                            <button type="submit" class="btn btn-danger">Actualizar</button>
                        </form>             
                    </div>
                </div><!--./card 2-->

            </div><!--./card-group-->

        </div><!--./col-md-10-->
    </div><!--./row-->

</div>
@endsection
