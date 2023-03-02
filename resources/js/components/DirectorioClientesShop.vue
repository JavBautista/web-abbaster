<template>
  <div>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Directorio de clientes
                <!--<button type="button" @click="abrirModal('categoria','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>-->
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <!-- <select class="form-control col-md-3" v-model="criterio">
                              <option value="nombre">Nombre</option>
                              <option value="descripcion">Descripción</option>
                              </select>
                            -->
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="getClientes(1,buscar,criterio)">
                            <button type="submit" @click="getClientes(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>

            <div class="card" v-for="customer in  customers" :key="customer.id">
              <div class="card-body">
                <div class="row">
                    <div class="col">
                        <dl class="row">
                            <dt class="col-sm-4">Mail</dt>
                            <dd class="col-sm-8" v-text="customer.mail"></dd>
                            <dt class="col-sm-4">RFC</dt>
                            <dd class="col-sm-8" v-text="customer.rfe"></dd>

                            <dt class="col-sm-4">Nombre</dt>
                            <dd class="col-sm-8" v-text="customer.name"></dd>

                            <dt class="col-sm-4">Tel.</dt>
                            <dd class="col-sm-8" v-text="customer.phone"></dd>

                            <dt class="col-sm-4">Móvil</dt>
                            <dd class="col-sm-8" v-text="customer.movil"></dd>
                        </dl>

                    </div>
                    <div class="col">
                        <dl class="row">
                            <dt class="col-sm-4">Dirección</dt>
                            <dd class="col-sm-8"> {{ customer.address }}&nbsp;{{ customer.number_out }}&nbsp;{{ customer.number_int }}&nbsp;{{ customer.district }}
                            </dd>

                            <dt class="col-sm-4">CP</dt>
                            <dd class="col-sm-8" v-text="customer.zip_code"></dd>

                            <dt class="col-sm-4">Ciudad</dt>
                            <dd class="col-sm-8" v-text="customer.city"></dd>

                            <dt class="col-sm-4">Estado</dt>
                            <dd class="col-sm-8" v-text="customer.state"></dd>

                            <dt class="col-sm-4">Registro</dt>
                            <dd class="col-sm-8" v-text="customer.created_at"></dd>
                        </dl>
                    </div>

                    <div class="col">
                        <button type="button" class="btn btn-info" @click="abrirModal('customer','actualizar', customer)"><i class="fa fa-trash"></i> Editar</button>
                        <button type="button" class="btn btn-danger" @click="eliminar(customer.id)"><i class="fa fa-trash"></i> Eliminar</button>

                        <!--
                        @if($purchases_customer[$customer->id])
                            <a href="{{ route('dashboard.store.customers.purchases',['shop_id'=>$shop->id, 'customer_id'=>$customer->id])}}" class="btn btn-block btn-outline-primary">[Ver {{ $purchases_customer[$customer->id] }} Compras]</a>
                        @else
                            <p class="mt-2"><em>Sin Compras</em></p>
                        @endif
                      -->

                    </div>

                </div>
              </div>
            </div>

            <hr>

                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                        </li>

                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>

                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
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

                    <div v-show="error" class="form-group row div-error">
                      <div class="container-fluid">
                        <div class="alert alert-danger text-center">
                            <div v-for="msg in errorMostrarMsj" :key="msg" v-text="msg">
                            </div>
                        </div>
                      </div>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                      <div class="form-group row">
                          <label for="mail" class="col-sm-3 col-form-label">Email<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="mail" required>
                          </div>
                      </div>
                      <!-- ------------------------------------------------------------------------>

                      <div class="form-group row">
                          <label for="name" class="col-sm-3 col-form-label">Nombre<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="name" required>
                          </div>
                      </div>


                      <div class="form-group row">
                          <label for="phone" class="col-sm-3 col-form-label">Telefono<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="phone" placeholder="7775985421" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="movil" class="col-sm-3 col-form-label">Movil<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="movil" placeholder="7775986543" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="zip_code" class="col-sm-3 col-form-label">CP<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="zip_code" placeholder="55083" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="address" class="col-sm-3 col-form-label">Calle<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="address" placeholder="Andador Robles" required>

                          </div>
                      </div>


                      <div class="form-group row">
                          <label for="number_out" class="col-sm-3 col-form-label">Number Ext<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="number_out" placeholder="77" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="number_int" class="col-sm-3 col-form-label">Number Int</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="number_int" placeholder="Depto A">

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="district" class="col-sm-3 col-form-label">Colonia<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="district" placeholder="El mirador" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="city" class="col-sm-3 col-form-label">Ciudad<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="city" placeholder="Puebla" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="state" class="col-sm-3 col-form-label">Estado<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="state" placeholder="Puebla" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="reference" class="col-sm-3 col-form-label">Referencia<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="reference" placeholder="Entre Calle Fresno y Girasoles" required>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="detail" class="col-sm-3 col-form-label">Detalles<span class="text-danger small">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="detail" placeholder="Casa Azul Porton Cafe" required>

                          </div>
                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarDatos()">Actualizar</button>
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
      props:['shop_id'],
    	data(){
    		return{
          customers:[],
          news:[],
          purchases_customer:[],

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

          modal:0,
          tituloModal:'',
          tipoAccion:0,
          error:0,
          errorMostrarMsj:[],
          pagination:{
                'total':0,
                'current_page':0,
                'per_page':0,
                'last_page':0,
                'from':0,
                'to':0
            },
            offset:3,
            criterio:'nombre',
            buscar:''
    		}
    	},
      computed:{
           isActived: function(){
            return this.pagination.current_page;
           },
           //Calcula los elementos de la paginacion
           pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from <1){
                    from=1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to ){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
           }
        },
    	methods:{
    		getClientes(page,buscar,criterio){
          let me=this;
          var url = '/get/shop-customers/'+me.shop_id+'?page='+page+'&buscar='+buscar+'&criterio='+criterio;
          axios.get(url).then(function (response) {
             console.log(response.data);
             var respuesta  = response.data;
              me.customers   = respuesta.customers.data;
              me.purchases_customer = respuesta.purchases_customer;
              me.pagination = respuesta.pagination;
              me.news = respuesta.news;
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
    		},
        cambiarPagina(page,buscar,criterio){
              let me = this;
              me.pagination.current_page = page;
              me.getClientes(page,buscar,criterio);
        },
        eliminar(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Realmente desea eliminar este cliente?',
                  text: "Esta acción borrará la información definitamente de la base de datos.",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/customers/delete',{
                        'customer_id': id
                    }).then(function (response){
                        //console.log(response);
                        me.getClientes(1,'','nombre');
                        swalWithBootstrapButtons.fire(
                          'Eliminado!',
                          'El cliente ha sido eliminado exitosamente.',
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
            actualizarDatos(){
              if(this.validarDatosCustomer()){
                    return;
                }
                let me=this;
                axios.put('/admin/customers/update',{
                    'customer_id':this.customer_id,
                    'mail':this.mail,
                    'name':this.name,
                    'phone':this.phone,
                    'movil':this.movil,
                    'zip_code':this.zip_code,
                    'address':this.address,
                    'number_out':this.number_out,
                    'number_int':this.number_int,
                    'district':this.district,
                    'city':this.city,
                    'state':this.state,
                    'reference':this.reference,
                    'detail':this.detail
                }).then(function (response){
                    me.cerrarModal();
                    me.getClientes(1,'','nombre');

                }).catch(function (error){
                    console.log(error);
                });
            },
            validarDatosCustomer(){
              this.error=0;
              this.errorMostrarMsj=[];
              if(!this.mail) this.errorMostrarMsj.push('El campo mail no puede estar vacio');
              if(!this.name) this.errorMostrarMsj.push('El campo nombre no puede estar vacio');
              if(!this.phone) this.errorMostrarMsj.push('El campo teléfono no puede estar vacio');
              if(!this.movil) this.errorMostrarMsj.push('El campo movil no puede estar vacio');
              if(!this.zip_code) this.errorMostrarMsj.push('El campo código postal no puede estar vacio');
              if(!this.address) this.errorMostrarMsj.push('El campo dirección no puede estar vacio');
              if(!this.number_out) this.errorMostrarMsj.push('El campo numero exterior no puede estar vacio');
              if(!this.district) this.errorMostrarMsj.push('El campo colonia no puede estar vacio');
              if(!this.city) this.errorMostrarMsj.push('El campo ciudad no puede estar vacio');
              if(!this.state) this.errorMostrarMsj.push('El campo estado no puede estar vacio');
              if(!this.reference) this.errorMostrarMsj.push('El campo referencia no puede estar vacio');
              if(!this.detail) this.errorMostrarMsj.push('El campo detalle no puede estar vacio');
              if(this.errorMostrarMsj.length) this.error=1;
              return this.error;
            },
    	cerrarModal(){
                this.modal=0;
                this.nombre='';
                this.descripcion='';
                this.tituloModal='';
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "customer":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.nombre='';
                                this.descripcion='';
                                this.tituloModal='Agregar';
                                this.tipoAccion =1;
                                break;
                            }
                            case 'actualizar':{
                                //console.log(data);
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';

                                this.customer_id=data['id'];
                                this.mail=data['mail'];
                                this.name=data['name'];
                                this.phone=data['phone'];
                                this.movil=data['movil'];
                                this.zip_code=data['zip_code'];
                                this.address=data['address'];
                                this.number_out=data['number_out'];
                                this.number_int=data['number_int'];
                                this.district=data['district'];
                                this.city=data['city'];
                                this.state=data['state'];
                                this.reference=data['reference'];
                                this.detail=data['detail'];
                                this.break=data['break'];
                            }
                        }
                    }
                }
            }
        },
      mounted() {
          this.getClientes(1,'','nombre')
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