<template>
  <main class="main">
    <div class="row">
      <!-- CONTENIDO SHOPPING CART-->
      <div class="col-md-8">
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
            <!-- FORM CODIGO DESCUENTO -->
            <div class="form-inline">
              <div class="form-group mb-3">
                <label for="staticCode" class="sr-only">¿Tienes código de descuento?</label>
                <input type="text" readonly class="form-control-plaintext" id="staticCode" value="¿Código de descuento?">
              </div>

              <div class="form-group mx-sm-3 mb-2">
                <label for="discount_code" class="sr-only">Codigo de descuento</label>
                <input type="text" class="form-control" v-model="discount_code" value="" required>
              </div>
              <button type="button" class="btn btn-primary mb-2" @click="buscarCodigoDescuento()" >Aplicar!</button>
            </div>
            <!-- ./FORM CODIGO DESCUENTO -->
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
                </div>
              </div>
              <div class="col-md-2">
                <div class="card-body">
                    <h3 class="card-text" v-text="row.qty"></h3>
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
            </div>
          </div>
        </div><!--./container-->
      </div><!--./class="col-md-8"-->
      <!--./CONTENIDO SHOPPING CART-->
      <!--CONTENIDO DATOS DE ENVIO-->
      <div class="col-md-4">
        <h5>¿A donde enviamos tu compra?</h5>
          <!-- EXISTE USUARIO LOGUEADO-->
          <div class="card" v-if="user_logged_in">
            <div class="card-body">
              <!--USUARIO ES CUSTOMER-->
              <template v-if="user_is_customer">
                <h3>Hola <span v-text="user_customer.name"></span> </h3>
                  <template v-if="count_direcciones==0">
                    <div class="alert alert-info">
                      Aun no tiene direcciones de envio registradas.
                      <a  href="#" class="btn btn-primary" @click="abrirModal('direcciones','registrar')"> Capture sus datos de envio</a>
                    </div>
                  </template>
                  <template v-else>
                    <h4>En viar a:</h4>
                    <dl class="row">
                      <dt class="col-sm-4">Recibe</dt>
                      <dd class="col-sm-8" v-text="direccion.name"></dd>
                      <dt class="col-sm-4">Teléfono</dt>
                      <dd class="col-sm-8" v-text="direccion.phone"></dd>
                      <dt class="col-sm-4">Móvil</dt>
                      <dd class="col-sm-8" v-text="direccion.movil"></dd>
                      <dt class="col-sm-4">Dirección</dt>
                      <dd class="col-sm-8">{{direccion.address}} No. {{direccion.number_out}} Int. {{direccion.number_int}}</dd>
                      <dt class="col-sm-4">Colonia</dt>
                      <dd class="col-sm-8" v-text="direccion.district"></dd>
                      <dt class="col-sm-4">CP</dt>
                      <dd class="col-sm-8" v-text="direccion.zip_code"></dd>
                      <dt class="col-sm-4">&nbsp;</dt>
                      <dd class="col-sm-8">{{direccion.city}}, {{direccion.state}}</dd>
                      <dt class="col-sm-4">Ref.</dt>
                      <dd class="col-sm-8">{{direccion.reference}}</dd>
                      <dt class="col-sm-4">Detalle.</dt>
                      <dd class="col-sm-8">{{direccion.detail}}</dd>
                    </dl>
                    <a href="#" class="btn btn-sm btn-outline-secondary" @click="abrirModal('direcciones','seleccionar')"> <i class=" fa fa-check-square"></i> Selecciona un destino ya guardado</a>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-2" @click="abrirModal('direcciones','registrar')"> <i class=" fa fa-plus"></i> Agregar un nuevo destino</a>
                    <hr>
                    <button type="button" class="btn btn-primary" @click="guardarCompra()">Continuar</button>
                    <!--<button type="submit" class="btn btn-primary btn-block mb-2 mx-2">COMPRAR CON MERCADO PAGO</button>
                    <br>
                    <button type="submit" class="btn btn-success btn-block mb-4 mx-2">COMPRAR CON PAYPAL</button>
                    -->
                  </template>

              </template>
              <!--./USUARIO ES CUSTOMER-->
              <!--USUARIO INCORRECTO-->
              <template v-else>
                <div class="alert alert-info">
                  <p><i class="fa fa-exclamation"></i> El usuario logueado no es de tipo cliente. Salga de la sesión e ingrese un usuario correcto.</p>
                </div>
              </template>
              <!--./USUARIO INCORRECTO-->
            </div><!--./card-body-->
          </div><!--./card-->
          <!--./EXISTE USUARIO LOGUEADO-->
          <!-- USUARIO NO LOGUEADO-->
          <div class="card" v-else>
            <div class="card-body">

              <div class="alert alert-success text-center" v-if="register_success">
                <i class="fa fa-exclamation-circle"></i> Registro exitoso, inicie sesión</div>
              </div>
              <div v-if="register==1">
                          <div v-show="register_error" class="alert alert-danger text-center">
                            <li class="fa fa-exclamation-triangle"></li>
                            <p v-for="msg in register_errorMostrarMsj" :key="msg" v-text="msg"></p>
                          </div>
                          <h4 class="card-title">Registrarse</h4>

                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input v-model="register_name" type="text" class="form-control" placeholder="Nombre">
                          </div>

                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input v-model="register_email" type="email" class="form-control" placeholder="E-Mail">
                          </div>

                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input v-model="register_password" type="password" class="form-control" placeholder="Password">
                          </div>

                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input v-model="register_password_confirmation" type="password" class="form-control" placeholder="Confirmar password">
                          </div>

                          <button type="button" class="btn btn-primary mb-2" @click="customerRegister()">Registrar</button>

                          <button type="button" class="btn btn-outline-secondary mb-2" @click="showRegister(0)">Iniciar session</button>
              </div>
              <div v-else>
                          <h4 class="card-title">Accede a tu cuenta</h4>
                          <div class="alert alert-danger text-center" v-if="login_error">
                            <i class="fa fa-exclamation-circle"></i> <div v-for="error in login_error_msg" :key="error" v-text="error"></div>
                          </div>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input v-model="login_email" type="email" class="form-control" placeholder="E-Mail">
                          </div>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input v-model="login_password" type="password" class="form-control" name="password"  placeholder="Password">
                          </div>

                          <button type="button" class="btn btn-success mb-2" @click="customerLogin()">Iniciar session</button>

                          <button type="button" class="btn btn-outline-secondary mb-2" @click="showRegister(1)">Registrarse</button>
              </div>
            </div>
          </div><!--./card-->
          <!--./ USER LOGIN/LOGOUT-->
      </div><!--./class="col-md-4"-->
      <!--./CONTENIDO DATOS DE ENVIO-->
    </div><!--./class="row"-->

    <!--MODAL-->
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
                    <div v-show="error" class="form-group row div-error">
                      <div class="container-fluid">
                        <div class="alert alert-danger text-center">
                            <div v-for="error in errorMostrarMsj" :key="error" v-text="error">
                            </div>
                        </div>
                      </div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <template v-if="tipoAccion==1">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Quien recibe<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Teléfono<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="phone" placeholder="7775985421" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="movil" class="col-sm-2 col-form-label">Móvil<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="movil" placeholder="7775986543" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zip_code" class="col-sm-2 col-form-label">CP<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="zip_code" placeholder="55083" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Calle<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="address" placeholder="Andador Robles" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="number_out" class="col-sm-2 col-form-label">No. Ext.<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="number_out" placeholder="77" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="number_int" class="col-sm-2 col-form-label">No. Int.</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="number_int" placeholder="Depto A">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="district" class="col-sm-2 col-form-label">Colonia<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="district" placeholder="El mirador" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-sm-2 col-form-label">Estado<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <select class="form-control" v-model="state" @change="selectCity()">
                                <option v-for="std in states" v-bind:value="std.nombre">
                                  {{ std.nombre }}
                                </option>
                              </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-sm-2 col-form-label">Ciudad<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <select class="form-control" v-model="city">
                                <option v-for="cd in cities" v-bind:value="cd.nombre">
                                  {{ cd.nombre }}
                                </option>
                              </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="reference" class="col-sm-2 col-form-label">Referencia<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="reference" placeholder="Entre Calle Fresno y Girasoles" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="detail" class="col-sm-2 col-form-label">Detalles<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="detail" placeholder="Casa Azul Porton Cafe" required>
                            </div>
                        </div>
                      </template>

                      <template v-if="tipoAccion==2">
                        <div class="container">
                          <div class="card" v-for="destino in user_customer_shipping_addresses" :key="destino.id">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-4">
                                  <dl class="row">
                                    <dt class="col-sm-4">Recibe</dt>
                                    <dd class="col-sm-8" v-text="destino.name"></dd>
                                    <dt class="col-sm-4">Teléfono</dt>
                                    <dd class="col-sm-8" v-text="destino.phone"></dd>
                                    <dt class="col-sm-4">Móvil</dt>
                                    <dd class="col-sm-8" v-text="destino.movil"></dd>
                                  </dl>
                                </div><!--./col-4-->
                                <div class="col-sm-4">
                                  <dl class="row">
                                    <dt class="col-sm-4">Dirección</dt>
                                    <dd class="col-sm-8">{{destino.address}} No. {{destino.number_out}} Int. {{destino.number_int}}</dd>
                                    <dt class="col-sm-4">Colonia</dt>
                                    <dd class="col-sm-8" v-text="destino.district"></dd>
                                    <dt class="col-sm-4">CP</dt>
                                    <dd class="col-sm-8" v-text="destino.zip_code"></dd>
                                    <dt class="col-sm-4">&nbsp;</dt>
                                    <dd class="col-sm-8">{{destino.city}}, {{destino.state}}</dd>
                                  </dl>
                                </div><!--./col-4-->
                                <div class="col-sm-4">
                                  <dl class="row">
                                    <dt class="col-sm-4">Ref.</dt>
                                    <dd class="col-sm-8">{{destino.reference}}</dd>
                                    <dt class="col-sm-4">Detalle.</dt>
                                    <dd class="col-sm-8">{{destino.detail}}</dd>
                                  </dl>
                                  <button type="button" class="btn btn-primary" @click="seleccionarDireecionEnvio( destino.id )">Seleccionar</button>
                                </div><!--./col-4-->
                              </div><!--./row-->
                            </div><!--./card-body-->
                          </div><!--./card v-for-->
                        </div><!--./container-->
                      </template>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>

                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarDireecionEnvio()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--./MODAL-->

  </main>
</template>

<script>
  export default {
    	data(){
    		return {
          cart:[],
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

          user_logged_in:0,
          user_is_customer:0,
          user_customer:[],
          user_customer_shipping_addresses:[],
          count_direcciones:0,
          register:0,

          login_email:'',
          login_password:'',
          login_error:0,
          login_error_msg:[],

          register_name : '',
          register_email : '',
          register_password:'',
          register_password_confirmation:'',
          register_error:0,
          register_errorMostrarMsj:[],
          register_success:0,

          modal:0,
          tituloModal:'',
          tipoAccion:0,

          error:0,
          errorMostrarMsj:'',

          name:'',
          phone:'',
          movil:'',
          zip_code:'',
          address:'',
          number_out:'',
          number_int:'',
          district:'',
          city:'',
          state:'',
          reference:'',
          detail:'',

          direccion_id:0,
          direccion:[],

          states:[],
          cities:[],

          purchase_id:0,
        }
    	},
    	methods:{
        guardarCompra(){
          let me=this;
          axios.post('/shopping-cart/save-purchase',{
            'address_id':me.direccion_id,
            'customer_id':me.user_customer.id,
          }).then(function (response) {
             console.log(response)
             me.purchase_id = response.data;
             if(me.purchase_id){
              window.location.href = '/payment/';
             }
          }).catch(function (error) {
            // handle error
          console.log(error);
          })
          .finally(function () {
          // always executed
          });

        },
        selectCity(){
          let me = this
          var state_id = 0
          me.states.map( function (x){
            if( x.nombre == me.state) state_id=x.id
          })
          if(state_id){
            axios.get('/shopping-cart/get-cities/'+state_id).then(function (response) {
              me.cities = response.data;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
            .finally(function () {
              // always executed
            });
          }
        },
        showRegister(val){
          this.register = val;
          console.log(val)

        },
        validarDatosRegister(){
          this.register_error=0;
          this.register_errorMostrarMsj=[];
          if(!this.register_name) this.register_errorMostrarMsj.push('El nombre no puede estar vacio');
          if(!this.register_email) this.register_errorMostrarMsj.push('El email no puede estar vacio');
          if(!this.register_password) this.register_errorMostrarMsj.push('El password no puede estar vacio');
          if(!this.register_password_confirmation) this.register_errorMostrarMsj.push('La confirmación del password no puede estar vacio');
          if(this.register_password!=this.register_password_confirmation)this.register_errorMostrarMsj.push('El password no coincide.');
          if(this.register_errorMostrarMsj.length) this.register_error=1;
          return this.register_error;

        },
        customerRegister(){
          if(this.validarDatosRegister()){
              return;
          }
          let me=this;
          axios.post('/customer/register',{
              'name': this.register_name,
              'email': this.register_email,
              'password': this.register_password,
          }).then(function (response){
            //consol.log(response)
            //window.location.href = '/login';
            me.register=0;
            me.login_email = me.register_email;
            me.login_password = me.register_password;
            me.register_success=1;
            me.register_error=0;
          }).catch(function (error){
              if (error.response.status == 422){
               //this.validationErrors = error.response.data.errors;
                me.register_success=0;
                me.register_error=1;
                me.register_errorMostrarMsj=[];
                me.register_errorMostrarMsj=error.response.data.errors;
              }
          });

        },
        getInfoCustomer(){
          let me=this;
          axios.get('/payment/check-loggedin-customer').then(function (response) {
            console.log(response)
            me.user_logged_in=response.data.check;
            me.user_is_customer=response.data.is_customer;
            me.user_customer=response.data.customer;
            me.user_customer_shipping_addresses=response.data.customer_shipping_addresses;
            me.count_direcciones=response.data.count_direcciones;

            me.direccion=[];
            me.direccion_id=0;
            if(me.count_direcciones){
              me.direccion = me.user_customer_shipping_addresses[ me.user_customer_shipping_addresses.length-1 ];
              me.direccion_id = me.direccion.id;
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
        loadShoppinCart(){
          let me=this;
          axios.get('/shopping-cart/get').then(function (response) {
          var contenido=response.data.contenido;
          if(contenido){
            var res=response.data;
            me.cart = res.cart;
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
        loadStates(){
          let me=this;
          axios.get('/shopping-cart/get-states').then(function (response) {
            me.states = response.data;
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
        },
        customerLogin(){
          if(this.validarLogin()){
              return;
          }
          let me=this;
          axios.post('/login-customer',{
              'email': this.login_email,
              'password': this.login_password,
          }).then(function (response){
              console.log(response)
              me.login_error=1;
              me.login_error_msg=[];
              if(typeof response.data.error !== 'undefined'){
                if(response.data.error){
                  me.login_error_msg.push(response.data.error_msg);
                }else{
                  me.login_error=0;
                  me.getInfoCustomer()
                }
              }else{
                me.login_error_msg.push('No se pudo obtener la información de los datos proporcionados. Intente nuevamente.');
              }
          }).catch(function (error){
            console.log(error.response)
               if (error.response.status == 422){
                me.login_error=1;
                me.login_error_msg=[];
                me.login_error_msg=error.response.data.errors;
              }
          });
        },
        validarLogin(){
          this.login_error=0;
          this.login_error_msg=[];
          if(!this.login_email) this.login_error_msg.push('El email no puede estar vacio');
          if(!this.login_password) this.login_error_msg.push('El password no puede estar vacio');
          if(this.login_error_msg.length) this.login_error=1;
          return this.login_error;
        },
        seleccionarDireecionEnvio(id){
          let me=this
          me.user_customer_shipping_addresses.map( function(x){
              if(id==x.id){
                me.direccion_id = x.id
                me.direccion=x
              }
          });
          me.cerrarModal();
        },
        registrarDireecionEnvio(){
           if(this.validarDireccionEnvio()){
                return;
            }
            let me=this;
            axios.post('/confirm-payment/store-address',{
                'customer_id': this.user_customer.id,
                'name': this.name,
                'phone': this.phone,
                'movil': this.movil,
                'zip_code': this.zip_code,
                'address': this.address,
                'number_out': this.number_out,
                'number_int': this.number_int,
                'district': this.district,
                'city': this.city,
                'state': this.state,
                'reference': this.reference,
                'detail': this.detail,
            }).then(function (response){
                me.cerrarModal();
                me.getInfoCustomer();

            }).catch(function (error){
                console.log(error);
            });
        },
        validarDireccionEnvio(){
          this.error=0;
          this.errorMostrarMsj=[];
          if(!this.name) this.errorMostrarMsj.push('El nombre no puede estar vacio');
          if(!this.phone) this.errorMostrarMsj.push('El teléfono no puede estar vacio');
          if(!this.movil) this.errorMostrarMsj.push('El móvil no puede estar vacio');
          if(!this.zip_code) this.errorMostrarMsj.push('El código postal no puede estar vacio');
          if(!this.address) this.errorMostrarMsj.push('El calle no puede estar vacio');
          if(!this.number_out) this.errorMostrarMsj.push('El número exterior no puede estar vacio');
          if(!this.district) this.errorMostrarMsj.push('La colonia no puede estar vacio');
          if(!this.city) this.errorMostrarMsj.push('La ciudad no puede estar vacio');
          if(!this.state) this.errorMostrarMsj.push('El estado no puede estar vacio');
          if(!this.reference) this.errorMostrarMsj.push('La referencia no puede estar vacio');
          if(!this.detail) this.errorMostrarMsj.push('El detalle no puede estar vacio');
          if(this.errorMostrarMsj.length) this.error=1;
          return this.error;
        },
        cerrarModal(){
          this.error=0
          this.errorMostrarMsj=[]
          this.modal=0;
          this.tituloModal=''
          this.name=''
          this.phone=''
          this.movil=''
          this.zip_code=''
          this.address=''
          this.number_out=''
          this.number_int=''
          this.district=''
          this.city=''
          this.state=''
          this.reference=''
          this.detail=''
        },
        abrirModal(modelo, accion, data=[]){
          switch(modelo){
            case "direcciones":{
                switch(accion){
                    case 'registrar':{
                        this.modal=1;
                        this.nombre='';
                        this.descripcion='';
                        this.tituloModal='Registrar dirección de envio';
                        this.tipoAccion =1;
                        break;
                    }
                    case 'seleccionar':{
                        //console.log(data);
                        this.modal=1;
                        this.tipoAccion =2;
                        this.tituloModal='Seleccionar direeción de envio.';
                        break;

                    }
                }
            }
          }
        }
    	},
      mounted() {
        this.loadShoppinCart()
        this.getInfoCustomer()
        this.loadStates()
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
