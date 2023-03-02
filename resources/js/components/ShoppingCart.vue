<template>
<main class="main">
  <div class="container-fluid">
    <h2>Carro de Compras</h2>
    <!--./Section Costo de Envio-->
    <div class="alert alert-info text-center">
      <span class="fa fa-exclamation-circle"></span>&nbsp;Envíos gratis en compras mayores a $ <span v-text="config_shipping.shipping_from"></span> MXN.
    </div>
    <!--./Section Codigo de Descuento-->
    <template v-if="existe_codigo">
      <p>
      <span v-if="session_type_discount=='monto'">
        <strong>Código: </strong> <span v-text="session_discount_code"></span><strong> Descuento:</strong> $ <span v-text="session_discount"></span>
      </span>
      <span v-else>
        <strong>Código: </strong> <span v-text="session_discount_code"></span><strong> Descuento:</strong> % <span v-text="session_discount"></span>
      </span>
      &nbsp;
      <a href="#" class="card-link text-muted small mt-2" @click="quitarCodigo()"> <i class="fa fa-times"></i> Quitar código</a>
      </p>

    </template>
    <template v-else>
      <!-- ACTION FORM: -->
      <div class="form-inline">
        <div class="form-group mb-3">
          <label for="staticCode" class="sr-only">¿Tienes código de descuento?</label>
          <input type="text" readonly class="form-control-plaintext" id="staticCode" value="¿Código de descuento?">
        </div>

        <div class="form-group mx-sm-3 mb-2">
          <label for="discount_code" class="sr-only">Código de descuento</label>
          <input type="text" class="form-control" v-model="discount_code" value="" required>
        </div>
        <button type="button" class="btn btn-primary mb-2" @click="buscarCodigoDescuento()" >Aplicar!</button>
      </div>

    </template>

    <!--./Tabla de Shoppin Cart-->

    <div class="card mb-1" v-for="row in cart" :key="row.rowId">
      <div class="row no-gutters">
        <div class="col-md-2">
          <template v-if="row.options.product_slug">
            <a :href="'/'+row.options.shop_slug+'/producto/'+row.options.product_slug">
              <img class="card-img" :src="row.options.image" :alt="row.options.key">
            </a>
          </template>
          <template v-else>
            <a :href="'/'+row.options.shop_slug+'/category/'+row.options.category_id+'/product/'+row.id">
              <img class="card-img" :src="row.options.image" :alt="row.options.key">
            </a>
          </template>
        </div>
        <div class="col-md-6">
          <div class="card-body">
            <template v-if="row.options.product_slug">
              <a  class="card-link" :href="'/'+row.options.shop_slug+'/producto/'+row.options.product_slug">
                <h4 class="card-title" v-text="row.name"></h4>
              </a>
            </template>
            <template v-else>
              <a class="card-link" :href="'/'+row.options.shop_slug+'/category/'+row.options.category_id+'/product/'+row.id">
                <h4 class="card-title" v-text="row.name"></h4>
              </a>
            </template>

            <p><em>$ <span v-text="row.price"></span></em></p>



            <a class="card-link mb-2" :href="'/'+row.options.shop_slug+'/store'">
              <span v-text="row.options.shop_name"></span>
            </a>
            <span class="text-muted">&#124;</span>
            <template v-if="row.options.category_slug">
              <a class="card-link" :href="'/'+row.options.shop_slug+'/categoria/'+row.options.category_slug ">Ver mas de <span v-text="row.options.category_name"></span></a>
            </template>
            <template v-else>
              <a class="card-link" :href="'/'+row.options.shop_slug+'/category/'+row.options.category_id ">Ver mas de <span v-text="row.options.category_name"></span></a>
            </template>
            <span class="text-muted">&#124;</span>
            <a href="#" class="card-link text-danger" @click="deleteProduct(row.rowId)">Eliminar</a>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card-body">
            <div class="input-group">
                <div class="input-group-prepend">
                  <button class="btn btn-outline-primary" type="button" @click="actualizarQty(row.rowId,row.qty, row.options.stock_exhibition, 'menos')">-</button>
                </div>
                <input type="text" class="form-control" v-model="arrayQtys[row.id]" readonly>
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button" @click="actualizarQty(row.rowId,row.qty, row.options.stock_exhibition, 'mas')">+</button>
                </div>
              </div>
              <p class="text-muted small"><em><span v-text="row.options.stock_exhibition"></span> disponibles</em></p>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card-body">
            <p class="card-text"><h3>$ <span v-text="row.subtotal"></span></h3></p>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-1">
      <div class="card-body">

          <div class="row justify-content-end text-right">
            <div class="col-4"><strong>Subtotal</strong></div>
            <div class="col-4">
              <h4><strong><em>$ <span v-text="subtotal"></span></em></strong></h4>
            </div>
          </div>

          <div class="row justify-content-end text-right">
            <div class="col-4"><strong>Envio</strong></div>
            <div class="col-4">
              <h4><strong><em>$  <span v-text="shipping"></span> </em></strong></h4>
            </div>
          </div>

          <template v-if="existe_codigo">
            <div class="row justify-content-end text-right">
              <div class="col-4"><strong>Descuento</strong></div>
              <div class="col-4">
                <span v-if="session_type_discount=='monto'">
                  <h4><strong><em> - $ <span v-text="session_discount"></span></em></strong></h4>
                </span>
                <span v-else>
                  <h4><strong><em> - % <span v-text="session_discount"></span></em></strong></h4>
                </span>
              </div>
            </div>
          </template>

          <div class="row justify-content-end text-right">
            <div class="col-4"><h5><strong>TOTAL </strong></h5></div>
            <div class="col-4">
              <h3><strong>$ <span v-text="total"></span> MXN</strong></h3>
            </div>
          </div>

          <a :href="'/confirm-payment'" class="btn btn-primary btn-lg float-right my-4">Continuar compra</a>
          <a href="#" class="card-link text-muted small mt-2" @click="limpiarCarro()"> <i class="fa fa-times"></i> Limpiar Carro de compras</a>
      </div>
    </div>



  </div><!--./container-->
</main>
</template>

<script>
  export default {
    	data(){
    		return {
          cart:[],
          arrayQtys:[],
          config_shipping:[],
          subtotal:0,
          tax:0,
          total:0,
          shipping:0,
          discount_code:'',
          existe_codigo:0,
          session_type_discount:'',
          session_discount:0,
          session_discount_code:'',
        }
    	},
    	methods:{
    		loadShoppinCart(){
    			let me=this;
          axios.get('/shopping-cart/get').then(function (response) {

          var contenido=response.data.contenido;

          if(contenido){
            var res=response.data;
            var temp=[];
            me.cart = res.cart;
            for (const item in me.cart){

              temp[ me.cart[item].id ] = me.cart[item].qty;
            }

            me.arrayQtys=temp;
            //console.log(me.arrayQtys)
            me.config_shipping = res.config_shipping;
            me.subtotal = res.subtotal;
            me.tax = res.tax;
            me.total = res.total;
            me.shipping = res.shipping;
            me.existe_codigo = res.existe_codigo;
            me.session_type_discount = res.session_type_discount;
            me.session_discount = res.session_discount;
            me.session_discount_code = res.session_discount_code;
            }else{
              window.location.href = '/';
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
        actualizarQty(rowId,qty,maximo,accion){
          let me=this;
          if(accion=='mas'){
            if(qty< maximo)
              qty++
            else
              return false;
          }
          else {
            if(qty>1 )
              qty--
            else return false;
          }
          axios.put('/shopping-cart/updateQty',{
            'rowId':rowId,
            'qty': qty
          }).then(function (response){
            me.loadShoppinCart();
          }).catch(function (error){
              console.log(error)
              /*if (error.response.status == 422){
                me.errors=error.response.data.errors;
              }*/
          });
        },
        buscarCodigoDescuento(){
          console.log('Buscar Cod Descuento')
          let me=this;
          axios.get('/shopping-cart/discount-code/search/'+me.discount_code).then(function (response) {
            console.log(response)
            var exito=response.data.exito;
            var msg=response.data.error_msg;
            if(exito){
              me.loadShoppinCart();
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: msg
              })
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
        quitarCodigo(){
          let me=this;
          axios.get('/shopping-cart/discount-code/clear/').then(function (response) {
            me.loadShoppinCart();
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
        },
        deleteProduct(rowId){
          console.log('delete Product')
          let me=this;
          axios.put('/shopping-cart/delete-item',{
            'rowId':rowId,
          }).then(function (response){
            console.log(response)
            me.loadShoppinCart();
          }).catch(function (error){
              console.log(error)
              /*if (error.response.status == 422){
                me.errors=error.response.data.errors;
              }*/
          });
        },
        limpiarCarro(){
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })

          swalWithBootstrapButtons.fire({
            title: '¿Realmente desea limpiar su carro de compras?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {

              let me=this;
              axios.get('/shopping-cart/clear').then(function (response){
                  me.loadShoppinCart();
                  swalWithBootstrapButtons.fire(
                    'Carro de compras limpio!',
                    'success'
                  )
              }).catch(function (error){
                  console.log(error);
              });

            }
          })
        },
    	},
      mounted() {
        //route /eagletekmexico/deleteToCart
          this.loadShoppinCart()
      }
    }
</script>
