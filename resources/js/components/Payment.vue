<template>
  <main class="main">
    <div class="container">
      <h2>Finalizar Compra</h2>
      <div class="row">
        <!-- CONTENIDO SHOPPING CART-->
        <div class="col-md-6">
          <div class="container-fluid">
            <template v-if="purchase.discount_code">

              <strong>Código: </strong> <span v-text="purchase.discount_code"></span><strong> Descuento:</strong> $ <span v-text="purchase.discount"></span>
            </template>

            <!--./Tabla de Shoppin Cart-->
            <div class="card mb-1" v-for="row in purchase.purchase_detail" :key="row.id">
              <div class="row no-gutters">
                <div class="col-md-6">
                  <div class="card-body">
                    <h4 class="card-title" v-text="row.name"></h4>
                    <p><em>$ <span v-text="row.price"></span></em></p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card-body">
                      <h4 class="card-text"> Qty <span v-text="row.qty"></span> </h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card-body">
                    <p class="card-text"><h4>$ {{ row.price * row.qty }}</h4></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mb-1">
              <div class="card-body">

                  <div class="row justify-content-end text-right">
                    <div class="col-4"><strong>Subtotal</strong></div>
                    <div class="col-4">
                      <h4><strong><em>$ <span v-text="purchase.subtotal"></span></em></strong></h4>
                    </div>
                  </div>

                  <div class="row justify-content-end text-right">
                    <div class="col-4"><strong>Envio</strong></div>
                    <div class="col-4">
                      <h4><strong><em>$  <span v-text="purchase.shipping"></span> </em></strong></h4>
                    </div>
                  </div>

                  <template v-if="purchase.discount_code">
                    <div class="row justify-content-end text-right">
                      <div class="col-4"><strong>Descuento</strong></div>
                      <div class="col-4">
                        <h4><strong><em> - $ <span v-text="purchase.discount"></span></em></strong></h4>
                      </div>
                    </div>
                  </template>

                  <div class="row justify-content-end text-right">
                    <div class="col-4"><h5><strong>TOTAL </strong></h5></div>
                    <div class="col-4">
                      <h3><strong>MXN $ <span v-text="purchase.total"></span></strong></h3>
                    </div>
                  </div>
              </div>
            </div>
          </div><!--./container-->
        </div><!--./class="col-md-8"-->
        <!--./CONTENIDO SHOPPING CART-->
        <!--CONTENIDO DATOS DE ENVIO-->
        <div class="col-md-6">
            <!-- EXISTE USUARIO LOGUEADO-->
            <div class="card">
              <div class="card-body">
                      <h4>Destino:</h4>
                      <dl class="row">
                        <dt class="col-sm-4">Recibe</dt>
                        <dd class="col-sm-8" v-text="purchase.name"></dd>
                        <dt class="col-sm-4">Teléfono</dt>
                        <dd class="col-sm-8" v-text="purchase.phone"></dd>
                        <dt class="col-sm-4">Móvil</dt>
                        <dd class="col-sm-8" v-text="purchase.movil"></dd>
                        <dt class="col-sm-4">Dirección</dt>
                        <dd class="col-sm-8">{{purchase.address}} No. {{purchase.number_out}} Int. {{purchase.number_int}}</dd>
                        <dt class="col-sm-4">Colonia</dt>
                        <dd class="col-sm-8" v-text="purchase.district"></dd>
                        <dt class="col-sm-4">CP</dt>
                        <dd class="col-sm-8" v-text="purchase.zip_code"></dd>
                        <dt class="col-sm-4">&nbsp;</dt>
                        <dd class="col-sm-8">{{purchase.city}}, {{purchase.state}}</dd>
                        <dt class="col-sm-4">Ref.</dt>
                        <dd class="col-sm-8">{{purchase.reference}}</dd>
                        <dt class="col-sm-4">Detalle.</dt>
                        <dd class="col-sm-8">{{purchase.detail}}</dd>
                      </dl>

              </div><!--./card-body-->
            </div><!--./card-->
        </div><!--./class="col-md-4"-->
        <!--./CONTENIDO DATOS DE ENVIO-->
      </div><!--./class="row"-->
    </div><!--./container-->
    <hr>
    <button type="button" class="btn btn-primary btn-block mb-2 mx-2" @click="paymentMercadoPago()">COMPRAR CON MERCADO PAGO</button>
  </main>
</template>

<script>
  export default {
    	data(){
    		return {
          purchase_id:0,
          purchase:[]
        }
    	},
    	methods:{
        loadPurchase(){
          let me=this;
          axios.get('/payment/get-purchase').then(function (response) {
            console.log(response)
            me.purchase=response.data.purchase
            me.purchase_id=response.data.purchase_id
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
        },
        paymentMercadoPago(){
          let me=this
          axios.get('/payment/get-prefrence-mercado-pago').then(function (response) {
            console.log(response)
            var url_redirect = response.data
            if(response.status == 200){
                window.location  = url_redirect;
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

    	},
      mounted() {
        this.loadPurchase()
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
