<template>
<main class="main">
    <div class="card text-white bg-info ">
        <div class="card-body">
            <p class="card-text">Una vez terminado el surido cambie el estatus de la orden de compra</p>
            <button class="btn btn-primary" @click="updateToStatusFinalizar()"><i class="fa fa-refresh"></i> Finalizar Orden de Compra</button>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Detalle
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Reg</th>
                            <th>PID</th>
                            <th>Producto</th>
                            <th>Qty</th>
                            <th>Cost</th>
                            <th v-for="bodega in arrayBodegas">
                                <span v-text="bodega.name"></span>
                            </th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="articulo in arrayArticulos " :key="articulo.id">
                            <td v-text="articulo.id"></td>
                            <td v-text="articulo.product_id"></td>
                            <td v-text="articulo.product"></td>
                            <td v-text="articulo.qty"></td>
                            <td v-text="articulo.cost"></td>
                            <td v-for="bodega in arrayBodegas" :key="bodega.id">
                                <span v-text="arrayInventories[articulo.id][bodega.id]"></span>
                            </td>
                            <td>
                                <button type="button" @click="abrirModal('articulo','actualizar-surtido', articulo)" class="btn btn-info">
                                  <i class="icon-pencil"></i> Editar Surtido
                                </button> &nbsp;
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
                    <div v-show="errorQtyArtBodegas" class="form-group row div-error">
                      <div class="alert alert-danger text-center">
                        <i class="fa fa-warning"></i> <hr>
                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error"></div>
                      </div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                        <div v-if="tipoAccion==1"> <!--Surtir Piezas-->

                            <div class="alert alert-info">
                                <p> <i class="fa fa-info-circle"></i> <span v-text="articulo"></span> Qty <span v-text="qty"></span>: Reparta las piezas a la bodega desee.</p>
                            </div>

                            <div class="form-group row" v-for="bodega in arrayBodegas " :key="bodega.id">
                                <label class="col-sm-2 col-form-label" v-text="bodega.name"></label>
                                <div class="col-sm-10">
                                    <input type="number" v-model="arraySurtido[bodega.id]" class="form-control" value="0" min="0" step="1" pattern="^[0-9]+" required>
                                </div>
                            </div>

                        </div><!--./Surtir Piezas-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="updateQtyProductoBodegas()">Guardar</button>
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
    export default {
        props:['purchase_order'],
        data(){
            return {
                arrayArticulos:[],
                articulo_id:0,
                articulo:'',
                qty:'',
                costo:'',
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorQtyArtBodegas:0,
                errorMostrarMsjArticulo:[],
                arrayBodegas:[],
                arraySurtido:[],
                arrayInventories:[],
            }
        },
        methods:{
            updateToStatusFinalizar(){
                let me=this;
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea pasar al Estatus de Finalizado de la Orden de Compra?',
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
                        'estatus': 'finalizado',
                    }).then(function (response){
                        //me.cargarInfoPO();
                        swalWithBootstrapButtons.fire(
                          'Actualizacion Correcta!',
                          'El estatus de la Orden de Compra ha cambiado a "Finalizado" con exito.',
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
            listarArticulos(){
                let me=this;
                // Make a request for a user with a given ID
                axios.get('/admin/purchase-order-detail/inventories/'+this.purchase_order).then(function (response){
                    //El response nos trae dos obejtos: Articulos e Inventarios
                    var respuesta  = response.data;
                    me.arrayArticulos = respuesta.articulos;
                    me.arrayInventories = respuesta.inventories;

                    //usaremos temp para guardar el item de los inventarios de cada art
                    var temp = new Array();
                    //recorremos los articulos
                    for (var i = 0; i < me.arrayArticulos.length; i+=1){
                        temp[me.arrayArticulos[i].id]=new Array();
                        var reg = me.arrayInventories[me.arrayArticulos[i].id];
                        for (var j = 0; j < me.arrayBodegas.length; j+=1){
                            temp[me.arrayArticulos[i].id][me.arrayBodegas[j].id]=0;
                            //recorremos el array de inventarios solo si tiene valores
                            if(reg.length){
                               for (var x = 0; x < reg.length; x+=1){
                                if(reg[x].warehouse_id == me.arrayBodegas[j].id)
                                    temp[me.arrayArticulos[i].id][me.arrayBodegas[j].id]=reg[x].stock;
                               }
                            }
                        }
                    }
                    me.arrayInventories = temp;
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            obtenerBodegas(){
                //console.log('get bodegas')
                 let me=this;
                 axios.get('/admin/purchase-order-detail/warehouses/get').then(function (response) {
                        me.arrayBodegas = response.data;
                        var arrayTemp=new Array();
                        for (var i = 0; i < me.arrayBodegas.length; i+=1) {
                            arrayTemp[me.arrayBodegas[i].id]=0;
                        }
                        me.arraySurtido=arrayTemp;
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            updateQtyProductoBodegas(){
                if(this.validarQtyProductoBodegas()){
                    return;
                }
                let me=this;
                for (var i = 0; i < me.arrayBodegas.length; i+=1) {
                    axios.post('/admin/purchase-order-detail/store/inventory',{
                        'product_id':me.articulo_id,
                        'stock':me.arraySurtido[me.arrayBodegas[i].id],
                        'warehouse_id': me.arrayBodegas[i].id,
                        'purchase_order_id': me.purchase_order,
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarArticulos();

                    }).catch(function (error){
                        console.log(error);
                    });



                }
            },
            validarQtyProductoBodegas(){
                this.errorQtyArtBodegas=0;
                this.errorMostrarMsjArticulo=[];

                var pzsInputs=0
                var regExp = /^[0-9]+$/

                //recorremos todos los inputs
                for (var i = 0; i < this.arrayBodegas.length; i+=1) {
                    var valInput = this.arraySurtido[this.arrayBodegas[i].id]
                    //Solo si algun input no cumple la expresion regular salimos
                    if(!regExp.test(valInput)){
                        this.errorMostrarMsjArticulo.push('Ingrese Numero Correctos.');
                        this.errorQtyArtBodegas=1;
                        return this.errorQtyArtBodegas;
                    }
                    pzsInputs += parseInt(valInput)
                }
                //si llega hasta aqui es porque cumplio la exp regular y solo validamos que las piezas coincidan con el numero de piezas
                if(pzsInputs != this.qty ){
                    this.errorQtyArtBodegas=1;
                    this.errorMostrarMsjArticulo.push('Las '+pzsInputs+' piezas ingresadas no coinciden con las '+this.qty+' piezas del articulo');
                }

                return this.errorQtyArtBodegas;
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
                            case 'actualizar-surtido':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Surtir Piezas';
                                this.articulo=data['product'];
                                this.qty=data['qty'];
                                this.articulo_id=data['product_id'];
                                this.errorQtyArtBodegas=0;
                                this.errorMostrarMsjArticulo=[];
                                for (var i = 0; i < this.arrayBodegas.length; i+=1) {
                                    this.arraySurtido[this.arrayBodegas[i].id]= this.arrayInventories[data['id']][this.arrayBodegas[i].id];
                                }
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.obtenerBodegas();
            this.listarArticulos();
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
        position: absolute !important;
        background-color: #3c29297a !important;
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
