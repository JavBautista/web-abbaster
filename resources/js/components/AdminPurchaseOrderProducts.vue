<template>
<main class="main">
    <div class="card text-white bg-info ">
        <div class="card-body">
            <p class="card-text">Una vez terminada la edicion cambie el estatus de la orden de compra
            <button class="btn btn-primary" @click="updateToStatusRecepcion()"><i class="fa fa-refresh"></i> Pasar a Recepcion</button>
            </p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-6 col-md-6">
              <dl class="row">
                    <dt class="col-sm-4">Estatus</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.estatus"></dd>
                    <dt class="col-sm-4">Creó</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.user_created"></dd>
                    <dt class="col-sm-4">Creación</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.created_at"></dd>
                    <dt class="col-sm-4">Actualización</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.updated_at"></dd>
              </dl>
            </div>
            <div class="col-6 col-md-6">
              <dl class="row">
                    <dt class="col-sm-4">Folio Proveedor</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.folio_proveedor"></dd>
                    <dt class="col-sm-4">Proveedor</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.proveedor"></dd>
                    <dt class="col-sm-4">Precio Dolar</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.precio_dolar"></dd>
                    <dt class="col-sm-4">Observaciones</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.observaciones"></dd>
                    <dt class="col-sm-4">Entrega Estimada</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.fecha_entrega_estimada"></dd>
                    <dt class="col-sm-4">Entrega Real</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.fecha_entrega_real"></dd>
                    <!--
                    <dt class="col-sm-4">Total</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.monto_total"></dd>
                    <dt class="col-sm-4">Documento Adjunto</dt>
                    <dd class="col-sm-8" v-text="purchaseOrder.documento_adjunto"></dd>
                    -->
              </dl>
            </div>


          </div>
          <button class="btn btn-warning" @click="abrirModal('purchase_order','editar_info_po',purchaseOrder)"> Editar Datos Generales <span class="fa fa-edit"></span></button>&nbsp;
        </div><!--.card-body-->
    </div><!--.card-->

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Detalle
                <button type="button" @click="abrirModal('articulo','seleccionar')" class="btn btn-secondary">
                    <i class="fa fa-search"></i>&nbsp;Selecionar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Qty</th>
                            <th>Cost</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="articulo in arrayArticulo " :key="articulo.id">
                            <td v-text="articulo.product"></td>
                            <td>
                                <select class="custom-select" v-model="inputsQty[articulo.id]" @change="updateQty(articulo.id)">
                                    <option v-for="item in 200" :key="item" :value="item">{{item}}</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" min="0" step="1" pattern="^[0-9]+" class="form-control" v-model="inputsCost[articulo.id]" @change="updateCost(articulo.id)">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" @click="deleteArticuloPO(articulo.id)">
                                      <i class="icon-trash"></i>
                                </button>
                                <!--<button type="button" @click="abrirModal('articulo','actualizar', articulo)" class="btn btn-info">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                -->
                                <!--
                                <template v-if="articulo.condicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(articulo.id)">
                                      <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarCategoria(articulo.id)">
                                      <i class="icon-check"></i>
                                    </button>
                                </template>
                                -->
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>

    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div v-if="tipoAccion==1">
                            <div class="form-group">
                                <label>Folio Proveedor</label>
                                <input type="text" class="form-control" v-model="folio_proveedor">
                            </div>
                            <div class="form-group">
                                <label>Proveedor</label>
                                <input type="text" class="form-control" v-model="proveedor">
                            </div>
                            <div class="form-group">
                                <label>Precio Dolar</label>
                                <input type="text" class="form-control" v-model="precio_dolar">
                            </div>
                            <div class="form-group">
                              <label for="observaciones">Obsrevaciones</label>
                              <textarea class="form-control" v-model="observaciones" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Entrega Estimada</label>
                                <date-picker v-model="fecha_entrega_estimada" :config="options"></date-picker>
                            </div>

                            <div class="form-group">
                                <label>Entrega Real</label>
                                <date-picker v-model="fecha_entrega_real" :config="options"></date-picker>
                            </div>

                        </div>
                        <div v-else-if="tipoAccion==3">
                            <p>Productos seleecionados:{{ arrayProductosSeleccionados.length }}</p>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Tiendas</label>
                              </div>
                              <select v-model="select_tienda" class="custom-select" id="inputGroupSelect01" @change="selectTienda()">
                                <option v-for="tienda in arrayTiendas" :key="tienda.id" :value="tienda.id"><span v-text="tienda.name"></span></option>
                              </select>
                            </div>

                            <div v-show="mostrarSelectCategoria">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect02">Categorias</label>
                                  </div>
                                  <select v-model="select_categoria" class="custom-select" id="inputGroupSelect02" @change="selectCategoria()">
                                    <option v-for="categoria in arrayCategorias" :key="categoria.id" :value="categoria.id"><span v-text="categoria.name"></span></option>
                                  </select>
                                </div>
                            </div>

                            <div v-show="mostrarProductos">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Key</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="producto in arrayProductos " :key="producto.id">
                                            <td>
                                                <div class="form-check">
                                                  <input class="form-check-input position-static" type="checkbox" value="option1" @change="checkedProducto(producto.id)" v-model="arrayProdChk[producto.id]" >
                                                </div>
                                            </td>
                                            <td v-text="producto.key"></td>
                                            <td v-text="producto.name"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div><!--./v-show="mostrarProductos"-->

                        </div><!---/v-if="tipoAccion==3">-->
                        <div v-else>
                            <h2>Otra Acción</h2>
                        </div><!--./if-else-->

                        <div v-show="errorArticulo" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">
                                </div>
                            </div>
                        </div><!--./v-show="errorArticulo" -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="updateInfoPO()">Actualizar datos</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="terminarSeleccionArticulos()">Terminar Selección</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal agregar/actualizar-->

</main>
</template>

<script>
    // Import this component
    import datePicker from 'vue-bootstrap-datetimepicker';
    // Import date picker css
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    export default {
        props:['purchase_order'],
        data(){
            return {
                fecha_entrega_estimada:new Date(),
                fecha_entrega_real:new Date(),
                options: {
                  format: 'YYYY-MM-DD',
                  useCurrent: false,
                },

                purchaseOrder:{},
                folio_proveedor:'',
                proveedor:'',
                precio_dolar:'',
                observaciones:'',

                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorArticulo:0,
                errorMostrarMsjArticulo:[],

                arrayArticulo:[],
                arrayTiendas:[],
                arrayCategorias:[],
                arrayProductos:[],
                arrayProdChk:[],
                arrayProductosSeleccionados:[],

                mostrarSelectCategoria:0,
                mostrarProductos:0,
                select_tienda:0,
                select_categoria:0,

                inputsQty:[],
                inputsCost:[],
            }
        },
        components: {
          datePicker
        },
        methods:{
            updateToStatusRecepcion(){
                let me=this;
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea pasar al Estatus de Sutido Orden de Compra?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/purchase-orders/update-status',{
                        'id': me.purchase_order,
                        'estatus': 'recepcion',
                    }).then(function (response){
                        me.cargarInfoPO();
                        swalWithBootstrapButtons.fire(
                          'Actualizacion Correcta!',
                          'El estatus de la Orden de Compra ha cambiado a "Surtido" con exito.',
                          'success'
                        )
                        window.location.href = '/dashboard/purchase-orders/'+me.purchase_order+'/show';
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                  /*else if (
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    )
                  }
                  */
                })
            },
            updateInfoPO(){
                let me=this;
                axios.put('/admin/purchase-order-detail/update-info-po',{
                    'id':this.purchase_order,
                    'folio_proveedor': me.folio_proveedor,
                    'proveedor': me.proveedor,
                    'precio_dolar': me.precio_dolar,
                    'observaciones': me.observaciones,
                    'fecha_entrega_estimada': me.fecha_entrega_estimada,
                    'fecha_entrega_real': me.fecha_entrega_real,
                }).then(function (response){
                    me.cerrarModal();
                    me.cargarInfoPO();
                }).catch(function (error){
                    console.log(error);
                });
            },
            cargarInfoPO(){
                let me=this;
                console.log('traer PO de '+me.purchase_order)
                // Make a request for a user with a given ID
                axios.get('/admin/purchase-order-detail/info/'+me.purchase_order).then(function (response) {
                    me.purchaseOrder= response.data;
                    console.log(me.purchaseOrder);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            updateQty(id){
                let me=this;
                axios.put('/admin/purchase-order-detail/update-qty',{
                    'id':id,
                    'qty':me.inputsQty[id]
                }).then(function (response){
                    //me.cerrarModal();
                    //me.listarArticulos();
                }).catch(function (error){
                    console.log(error);
                });
            },
            updateCost(id){
                let me=this;
                console.log(`Update Cost, REG ${id} Value  ${me.inputsCost[id]} `)
                if(me.inputsCost[id]<0) me.inputsCost[id]=0;
                if(me.inputsCost[id]>=0){
                    axios.put('/admin/purchase-order-detail/update-cost',{
                        'id':id,
                        'cost':me.inputsCost[id]
                    }).then(function (response){
                        //me.cerrarModal();
                        //me.listarArticulos();
                    }).catch(function (error){
                        console.log(error);
                    });
                }
            },
            deleteArticuloPO(id){
                let me=this;
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea elimnar este producto de la Orden de Compra?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.post('/admin/purchase-order-detail/delete-product-po',{
                        'id': id
                    }).then(function (response){
                        me.listarArticulos();
                        swalWithBootstrapButtons.fire(
                          'Eliminado!',
                          'El producto ha sido eliminado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                  /*else if (
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    )
                  }
                  */
                })
            },
            terminarSeleccionArticulos(){
                let me=this;
                for (var i = 0; i < me.arrayProductosSeleccionados.length; i+=1) {
                    axios.post('/admin/purchase-order-detail/store',{
                        'product_id':me.arrayProductosSeleccionados[i],
                        'purchase_order_id':this.purchase_order
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarArticulos();
                    }).catch(function (error){
                        console.log(error);
                    });
                }
                me.arrayProductosSeleccionados=[];
            },
            checkedProducto(product_id){
                var index = this.arrayProductosSeleccionados.indexOf(product_id);
                //si se dio Check al CheckBox
                if(this.arrayProdChk[product_id]){
                    if(index === -1)
                        this.arrayProductosSeleccionados.push(product_id)
                }else{
                    if(index !== -1)
                        this.arrayProductosSeleccionados.splice(index,1)
                }
                console.log(this.arrayProductosSeleccionados)
            },
            selectCategoria(){
                let me=this;
                axios.get('/admin/purchase-order-detail/get-products/'+me.select_categoria).then(function (response) {
                    me.arrayProductos = response.data;
                    me.mostrarProductos=1;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            selectTienda(){
                let me=this;
                console.log(me.select_tienda)
                axios.get('/admin/purchase-order-detail/get-categories/'+me.select_tienda).then(function (response) {
                    me.arrayCategorias = response.data;
                    me.mostrarSelectCategoria=1;
                    me.mostrarProductos=0;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            getTiendas(){
                let me=this;
                axios.get('/admin/purchase-order-detail/get-shops').then(function (response) {
                    me.arrayTiendas = response.data;
                    console.log(me.arrayTiendas)
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            listarArticulos(){
                let me=this;
                // Make a request for a user with a given ID
                axios.get('/admin/purchase-order-detail/'+this.purchase_order).then(function (response) {
                    me.arrayArticulo = response.data;
                    me.inputsQty=[];
                    me.inputsCost=[];
                    for (var i = 0; i < me.arrayArticulo.length; i+=1) {
                        me.inputsQty[me.arrayArticulo[i].id] = me.arrayArticulo[i].qty;
                        me.inputsCost[me.arrayArticulo[i].id] = me.arrayArticulo[i].cost;
                    }
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            cerrarModal(){
                this.modal=0;
                this.nombre='';
                this.descripcion='';
                this.tituloModal='';
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "articulo":{
                        switch(accion){
                            case 'seleccionar':{
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Seleccionar Articulos';
                                this.errorArticulo=0;

                                this.mostrarSelectCategoria=0;
                                this.mostrarProductos=0;
                                this.select_tienda=0;
                                this.select_categoria=0;
                                this.getTiendas();

                                break;
                            }

                        }
                    }
                    case "purchase_order":{
                        switch(accion){
                            case 'editar_info_po':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Editar Datos de Orden de Compra';

                                this.folio_proveedor=   data['folio_proveedor'];
                                this.proveedor= data['proveedor'];
                                this.precio_dolar=  data['precio_dolar'];
                                this.observaciones= data['observaciones'];
                                this.fecha_entrega_estimada= data['fecha_entrega_estimada'];
                                this.fecha_entrega_real= data['fecha_entrega_real'];


                                break;
                            }

                        }
                    }
                }
            }
        },
        mounted() {
            this.listarArticulos();
            this.cargarInfoPO();
        }
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #3c29297a !important;
        overflow: scroll;
    }

    .div-error{
        display: flex;
        justify-content: center;
    }

    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
