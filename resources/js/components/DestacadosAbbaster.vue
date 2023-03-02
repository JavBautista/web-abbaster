<template>
<div>
  <div class="container">

    <!-- Act Retail x Producto-->
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Productos
            <!-- btn new-->
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" v-model="buscar" class="form-control" placeholder="Producto a buscar" @keyup.enter="loadDatos(1,buscar)">
                        <button type="submit" @click="loadDatos(1,buscar)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>Tienda</th>
                    <th>Categoria</th>
                    <th>Key</th>
                    <th>Name</th>
                    <th>Img</th>
                    <th>Posición</th>
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
                    <td>
                      <template v-if="product.destacado_gral">
                        <button class="btn btn-outline-info btn-sm" @click="moveOrder(product.id,'up')"><i class="fa fa-caret-up"></i></button>

                        <button class="btn btn-outline-info btn-sm" @click="moveOrder(product.id,'down')"><i class="fa fa-caret-down"></i></button>
                      </template>
                    </td>
                    <td>
                      <template v-if="product.destacado_gral">
                        <button class="btn btn-info" @click="nodestacarProducto(product.id)">No destacar</button>
                      </template>
                      <template v-else>
                        <button class="btn btn-outline-info" @click="destacarProducto(product.id)">Destacar</button>
                      </template>
                    </td>
                  </tr>
                </tbody>
            </table>
            <nav>
              <ul class="pagination">
                  <li class="page-item" v-if="pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar)">Ant</a>
                  </li>

                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar)" v-text="page"></a>
                  </li>

                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar)">Sig</a>
                  </li>
              </ul>
          </nav>
        </div>
    </div>
    <!-- ./Producto-->
  </div><!--./container-->

</div>
</template>

<script>
    export default {
    	data(){
    		return {
          arrayProducts:[],
          product_id:0,

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

        loadDatos(page,buscar){
          let me = this
          var url = '/products-destacados/get?page='+page+'&buscar='+buscar
          axios.get(url).then(function (response) {
            //console.log(response)
            var res = response.data
            me.pagination     = res.pagination;
            me.arrayProducts  = res.products.data;
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
        },
        cambiarPagina(page,buscar){
            let me = this;
            me.pagination.current_page = page;
            me.loadDatos(page,buscar);
        },
        nodestacarProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                  })

                  swalWithBootstrapButtons.fire({
                    title: '¿Desea no destacar esta producto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.value) {

                      let me=this;
                      axios.put('/products-destacados/update-no-destacar',{
                          'id': id
                      }).then(function (response){
                          me.loadDatos(1,'');
                          swalWithBootstrapButtons.fire(
                            'Producto No Destacado!',
                            'El producto ha sido actualizado con exito.',
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

            destacarProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                  })

                  swalWithBootstrapButtons.fire({
                    title: '¿Desea destacar esta producto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.value) {

                      let me=this;
                      axios.put('/products-destacados/update-destacar',{
                          'id': id
                      }).then(function (response){
                          me.loadDatos(1,'');
                          swalWithBootstrapButtons.fire(
                            'Producto Destacado!',
                            'El producto ha sido actualizado con exito.',
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
            moveOrder(id,action){

              let me=this;
              axios.put('/products-destacados/update-order',{
                  'id': id,
                  'action':action
              }).then(function (response){
                  me.loadDatos(1,'');
                  //console.log('ORA ACCCION: '+action+' ID: '+id);
                  //console.log(response.data);
              }).catch(function (error){
                  console.log(error);
              })

            },
    	},
      mounted() {
          this.loadDatos(1,'')
      }
    }
</script>
