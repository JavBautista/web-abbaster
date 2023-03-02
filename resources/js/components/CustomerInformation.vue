<template>
  <div>
  <div class="container">
    <div class="row justify-content-center">
            <div class="col-md-10">
               <a class="btn btn-outline-primary" href="/eagletekmexico/shopping-cart">Regresar a Shopping Cart</a>
               <button type="button" @click="abrirModal('customer','actualizar-datos',customer)" class="btn btn-primary">
                    <i class="fa fa-user-edit"></i>&nbsp;Actualizar Datos
                </button>
                <button type="button" @click="abrirModal('customer','actualizar-password',customer)" class="btn btn-primary">
                    <i class="fa fa-user-edit"></i>&nbsp;Actualizar Password
                </button>
                <div class="card mt-2">
                    <div class="card-body">
                        <h5 class="card-title">Mis Datos de Contato</h5>
                        <dl class="row">
                            <dt class="col-sm-3">Mail</dt>
                            <dd class="col-sm-9" v-text="customer.mail"></dd>
                            <dt class="col-sm-3">Nombre</dt>
                            <dd class="col-sm-9" v-text="customer.name"></dd>
                            <dt class="col-sm-3">Telefono</dt>
                            <dd class="col-sm-9" v-text="customer.phone"></dd>
                            <dt class="col-sm-3">Movil</dt>
                            <dd class="col-sm-9" v-text="customer.movil"></dd>
                            <dt class="col-sm-3">CP</dt>
                            <dd class="col-sm-9" v-text="customer.zip_code"></dd>
                            <dt class="col-sm-3">Calle</dt>
                            <dd class="col-sm-9" v-text="customer.address"></dd>
                            <dt class="col-sm-3">Num. Ext.</dt>
                            <dd class="col-sm-9" v-text="customer.number_out"></dd>
                            <dt class="col-sm-3">Num. Int</dt>
                            <dd class="col-sm-9" v-text="customer.number_int"></dd>
                            <dt class="col-sm-3">Colonia</dt>
                            <dd class="col-sm-9" v-text="customer.district"></dd>
                            <dt class="col-sm-3">Ciudad</dt>
                            <dd class="col-sm-9" v-text="customer.city"></dd>
                            <dt class="col-sm-3">Estado</dt>
                            <dd class="col-sm-9" v-text="customer.state"></dd>
                            <dt class="col-sm-3">Referencias</dt>
                            <dd class="col-sm-9" v-text="customer.reference"></dd>
                            <dt class="col-sm-3">Detalle</dt>
                            <dd class="col-sm-9" v-text="customer.detail"></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
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
                            <label for="mail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="mail" readonly>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="name" readonly>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Telefono<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="phone" placeholder="7775985421" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="movil" class="col-sm-2 col-form-label">Movil<span class="text-danger">*</span></label>
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
                            <label for="number_out" class="col-sm-2 col-form-label">Number Ext<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="number_out" placeholder="77" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="number_int" class="col-sm-2 col-form-label">Number Int</label>
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
                            <label for="city" class="col-sm-2 col-form-label">Ciudad<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="city" placeholder="Puebla" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-sm-2 col-form-label">Estado<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" v-model="state" placeholder="Puebla" required>
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
                      <template v-if="tipoAccion==3">
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">Password</label>
                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control" placeholder="******" v-model="password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label">Confirmar Password</label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control" placeholder="******" v-model="password_confirmation" required>
                            </div>
                        </div>
                      </template>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="actualizarDatosCustomer()">Actualizar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="actualizarCustomerPassword()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

  </div>
</template>

<script>
    export default {
    	data(){
    		return {
          error:0,
          errorMostrarMsj:[],
          modal:0,
          tituloModal:'',
          tipoAccion:0,

          customer:{},
          customer_id:0,
          mail:'',
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

          password:'',
          password_confirmation:''
    		}
    	},
    	methods:{
        loadCustomer(){
          let me=this;
          axios.get('/customer/my-contact-information/get').then(function (response) {
            me.customer = response.data
            console.log(me.customer)
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });

        },

        actualizarDatosCustomer(){
          if(this.validarDatos('actualizar_data')){
            return;
          }
          let me=this;
          axios.put('/customer/my-contact-information/update',{
            'customer_id':this.customer_id,
            'mail': this.mail,
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
            'detail': this.detail
          }).then(function (response){
            console.log(response)
            me.cerrarModal();
            me.loadCustomer();
          }).catch(function (error){
              me.error=1;
              me.errorMostrarMsj=[];
              me.errorMostrarMsj=error.response.data.errors;
          });
        },
        actualizarCustomerPassword(){
            if(this.validarDatos('update_password')){
                return;
            }
            let me=this;
            axios.put('/customer/my-contact-information/update-password',{
                'id': this.customer_id,
                'password': this.password,
                'password_confirmation': this.password_confirmation,
            }).then(function (response){
                me.cerrarModal();
                me.loadCustomer();
            }).catch(function (error){
                me.error=1;
                me.errorMostrarMsj=[];
                me.errorMostrarMsj=error.response.data.errors;
            });
        },
        validarDatos(accion){
              this.error=0;
              this.errorMostrarMsj=[];
              if(accion=='actualizar_data'){
                  if(!this.phone) this.errorMostrarMsj.push('El teléfono no puede estar vacio.');
                  if(!this.movil) this.errorMostrarMsj.push('El numero de móvil no puede estar vacio.');
                  if(!this.zip_code) this.errorMostrarMsj.push('El codigo postal no puede estar vacio.');
                  if(!this.address) this.errorMostrarMsj.push('La calle no puede estar vacio.');
                  if(!this.number_out) this.errorMostrarMsj.push('El número exterior no puede estar vacio.');
                  if(!this.district) this.errorMostrarMsj.push('La colonia no puede estar vacio.');
                  if(!this.city) this.errorMostrarMsj.push('El ciudad no puede estar vacio.');
                  if(!this.state) this.errorMostrarMsj.push('El estado no puede estar vacio.');
                  if(!this.reference) this.errorMostrarMsj.push('El referencia no puede estar vacio.');
                  if(!this.detail) this.errorMostrarMsj.push('El detalle no puede estar vacio.');
              }
              /*if(accion=='update_info'){
                  if(!this.name) this.errorMostrarMsj.push('El nombre no puede estar vacio');
                  if(!this.email) this.errorMostrarMsj.push('El email no puede estar vacio');
              }*/
              if(accion=='update_password'){
                  if(!this.password) this.errorMostrarMsj.push('El password no puede estar vacio');
                  if(!this.password_confirmation) this.errorMostrarMsj.push('La confimación del password no puede estar vacio');
              }
              if(this.errorMostrarMsj.length) this.error=1;
              return this.error;
          },
          cerrarModal(){
                this.error=0;
                this.errorMostrarMsj=[];
                this.modal=0;
                this.tituloModal='';

                this.password='';
                this.password_confirmation='';
          },
          abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "customer":{
                        switch(accion){
                            case 'actualizar-datos':{
                                this.modal=1;
                                this.tituloModal='Actualizar datos';
                                this.tipoAccion =1;

                                this.customer_id= data['id']
                                this.mail= data['mail']
                                this.name= data['name']
                                this.phone= data['phone']
                                this.movil= data['movil']
                                this.zip_code= data['zip_code']
                                this.address= data['address']
                                this.number_out= data['number_out']
                                this.number_int= data['number_int']
                                this.district= data['district']
                                this.city= data['city']
                                this.state= data['state']
                                this.reference= data['reference']
                                this.detail= data['detail']
                                break;
                            }

                            case 'actualizar-password':{
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Actualizar Password';
                                this.user_id=data['id'];
                                break;
                            }

                        }
                    }
                }
            }

    	},
      mounted() {
        console.log('Customer Information Mounted '+this.user_id)
        this.loadCustomer()
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