<template>
<div>
  <div class="container">
    <!-- Act Precio Dolar -->
    <div class="card">
      <div class="card-header">Precio Dollar Actual <span v-text="price_actual"></span></div>
      <div class="card-body">
        <div class="form-inline">
          <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
              <div class="input-group-text">US $</div>
            </div>
            <input type="number" min="0" step="1" class="form-control" v-model="price" placeholder="0.0." required>
          </div>
          <button type="button" class="btn btn-primary mb-2" @click="updateDollarPrice()">Actualizar</button>
        </div>
      </div>
    </div>
    <!-- ./ Act Precio Dolar -->

    <!-- Act Retail x Producto-->
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Actualizacion de retail de productos
            <!-- btn new-->
        </div>
        <div class="card-body">
            <div class="form-inline mb-2">
                <label class="my-1 mr-2" for="sel">Tienda</label>
                <select class="custom-select my-1 mr-sm-2" id="sel" v-model="tienda">
                  <option value="">Todos</option>
                  <option value="eagletek">Eagletek México</option>
                  <option value="ziot">Ziot Robotik</option>
                  <option value="solartek">Solartek</option>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <select class="form-control col-md-3" v-model="criterio">
                          <option value="name">Nombre</option>
                          <option value="key">Key</option>
                        </select>

                        <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadDatos(1,buscar,criterio,tienda)">
                        <button type="submit" @click="loadDatos(1,buscar,criterio,tienda)" class="btn btn-primary">Aplicar <i class="fa fa-hand-point-right"></i></button>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>Tienda</th>
                    <th>Categoría</th>
                    <th>Key</th>
                    <th>Name</th>
                    <th>Img</th>
                    <th>Precio USD</th>
                    <th>Precio MXN</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="product in arrayProducts" :key="product.id">

                    <td v-text="product.nombre_shop"></td>
                    <td v-text="product.nombre_categoria"></td>
                    <td v-text="product.key"></td>
                    <td v-text="product.name"></td>
                    <td><img class="img-thumbnail" width="50px" :src="product.image" alt="Img 404"></td>
                    <td v-text="product.cost_dollar"></td>
                    <td v-text="product.retail"></td>
                    <td>
                      <button class="btn btn-primary" @click="abrirModal('product','act_retail', product)"> Actualizar <i class="fa fa-edit"></i></button>
                    </td>
                  </tr>
                </tbody>
            </table>
            <nav>
              <ul class="pagination">
                  <li class="page-item" v-if="pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio,tienda)">Ant</a>
                  </li>

                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,tienda)" v-text="page"></a>
                  </li>

                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio,tienda)">Sig</a>
                  </li>
              </ul>
          </nav>
        </div>
    </div>
    <!-- ./Act Retail x Producto-->
  </div><!--./container-->

  <!--Inicio del modal-->
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
              <div class="alert alert-info text-center">
                <p><strong> <i class="fa fa-warning"></i> El costo actual de dolar es ${{price_actual}}</strong></p>
              </div>

                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Precio USD</label>
                    <div class="col-md-9">
                        <input type="number" min="0" step="1" v-model="product_new_cost_usd" class="form-control" placeholder="Ingrese nuevo costo USD" v-on:keyup="calcular">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Precio MXN</label>
                    <div class="col-md-9">
                        <input type="number" min="0" step="1" class="form-control" placeholder="Ingrese nuevo precio publico" readonly :value="product_new_retail">
                    </div>
                </div>

                <!--SECTION SHOW ERROR-->
                <div v-show="error" class="form-group row div-error">
                  <div class="alert alert-danger text-center">
                    <div v-for="error in errorMostrarMsj" :key="error" v-text="error"></div>
                  </div>
                </div>
                <!--./SECTION SHOW ERROR-->
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="updateProductRetail()">Guardar</button>
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
          price_actual:0.0,
          price:0.0,
          arrayProducts:[],

          product_id:0,
          product_retail:0,
          product_cost_dollar:0,

          product_new_retail:0,
          product_new_cost_usd :0,

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
          criterio:'name',
          tienda:'',
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

        calcular:function (event){
          console.log(this.product_new_cost_usd)
          this.product_new_retail = this.price_actual * this.product_new_cost_usd
        },
        loadDatos(page,buscar,criterio,tienda){
          let me = this
          var url = '/dollar-price/get-data?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&tienda='+tienda;
          axios.get(url).then(function (response) {
            console.log(response)
            var res = response.data
            me.pagination     = res.pagination;
            me.arrayProducts  = res.products.data;
            me.price_actual   = res.price[0].price;
            me.price          = res.price[0].price;
            me.id             = res.price[0].id;

            console.log(me.pagination)
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
        },
        cambiarPagina(page,buscar,criterio,tienda){
            let me = this;
            me.pagination.current_page = page;
            me.loadDatos(page,buscar,criterio,tienda);
        },

        updateDollarPrice(){
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
              title: '¿Realmente desea actualizar el precio del dollar?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Aceptar',
              cancelButtonText: 'Cancelar',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                let me=this;
                axios.put('/dollar-price/update-dollar-price',{
                    'price': me.price,
                }).then(function (response){
                  console.log(response)
                    me.loadDatos(1,'','name','');
                    swalWithBootstrapButtons.fire(
                      'Actualizado!',
                      'El precio ha sido actualizado con exito.',
                      'success'
                    )
                }).catch(function (error){
                    console.log(error);
                });

              } /*else if (
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
        updateProductCostUSD(){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
              })

              swalWithBootstrapButtons.fire({
                title: '¿Desa realizar la actualización del Cost USD de los productos?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                reverseButtons: true
              }).then((result) => {
                if (result.value) {
                  axios.put('/products-cost-usd/update').then(function (response){
                      console.log(response)
                      swalWithBootstrapButtons.fire(
                        '¡Actualizacion finalizada!',
                        'El producto ha sido activado con exito.',
                        'success'
                      )
                  }).catch(function (error){
                      console.log(error);
                  });

                } /* else if (
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
        updateProductRetail(){
          if(this.validarRetailProduct()){
              return;
          }
          let me=this;
          axios.put('/dollar-price/update-product-retail',{
            'id': me.product_id,
            'new_retail': me.product_new_retail,
            'new_cost_usd': me.product_new_cost_usd
          }).then(function (response){
            //console.log(response)
            me.cerrarModal();
            me.loadDatos(me.pagination.current_page,me.buscar,me.criterio,me.tienda);
          }).catch(function (error){
              if (error.response.status == 422){
               //this.validationErrors = error.response.data.errors;
                me.errors=error.response.data.errors;
              }
          });

        },
        validarPrice(){
          return true;
        },
        validarRetailProduct(){
          this.error=0;
          this.errorMostrarMsj=[];

          if(!this.product_new_retail) this.errorMostrarMsj.push('El nuevo precio público no puede estar vacio');
          if(!this.product_new_cost_usd) this.errorMostrarMsj.push('El nuevo costo USD no puede estar vacio');


          if(this.errorMostrarMsj.length) this.error=1;

          return this.error;
        },
        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.product_id=0;
                this.product_retail=0;
                this.product_new_retail=0;
                this.product_new_cost_usd=0;
                this.product_cost_dollar=0;

            },
        abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "product":{
                        switch(accion){
                            case 'act_retail':{
                                this.modal=1;
                                this.tituloModal='Actualizar costo de producto';
                                this.tipoAccion =1;
                                this.product_id=data['id'];
                                this.product_retail=data['retail'];
                                this.product_new_retail= data['retail'];
                                this.product_cost_dollar=data['cost_dollar'];
                                this.product_new_cost_usd =data['cost_dollar'];
                                break;
                            }
                        }//./swtch 2
                    }//./case "product"
                }//./swtch 1
            }//.abrirModal

    	},
      mounted() {
          this.loadDatos(1,'','name','')
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
