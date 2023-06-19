<template>
  <div>
  <div class="container">
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Productos
          <button type="button" @click="abrirModal('product','registrar')" class="btn btn-ouline-primary">
              <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
      </div>
      <div class="card-body">
        <div class="text-danger float-right">
          Costo Actual del dolar <strong>$<span v-text="dollar_price" ></span> USD</strong>
        </div>
        <div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" v-model="busqueda_gral" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Buscar en toda la tienda
            </label>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text">Estatus</label>
              </div>
              <select class="custom-select" v-model="filtro_status">
                <option value="activos">Activos</option>
                <option value="bajas">Bajas</option>
                <option value="todos">Todos</option>
              </select>
            </div>
          </div><!--./col-md-6-->
          <div class="col-md-6">
            <div class="input-group">
                <select class="form-control" v-model="criterio">
                  <option value="name">Nombre</option>
                  <option value="key">Key</option>
                </select>
                <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="listarProductos(1,buscar,criterio,filtro_status)">
                <div class="input-group-append">
                  <button type="button" @click="listarProductos(1,buscar,criterio,filtro_status)" class="btn btn-primary"> Filtrar <i class="fa fa-search"></i></button>
                </div>
            </div>
          </div><!--./col-md-6-->
        </div><!--./form-group row"-->

        <div class="card mb-0" v-for="product in arrayProducts" :key="product.id">
          <div class="card-header">
            <span v-text="product.name"></span>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="container mb-2" style="width: 12rem;">
                        <img class="card-img-top" :src="product.image" :alt="product.name">
                    </div>
                    <a :href="'/dashboard/store/'+shop_id+'/products/images/'+product.id" class="btn btn-block btn-info">Editar Image</a>
                    <!--
                    <a class="btn btn-block btn-outline-info" @click="abrirModal('product','update_images', product)">New Modal Editar Image</a>
                    -->
                    <a class="btn btn-block btn-outline-info" @click="abrirModal('product','update_image', product)">New Modal Editar Image</a>
                    <span v-if="product.barcode!='0'">
                       <barcode class="barcode-container" :value="product.barcode" :options="{format:'EAN-13'}">Generando código de barras</barcode>
                    </span>
                    <span v-else>
                      <p> <i class="fa fa-barcode"></i> Sin Código</p>
                    </span>
                </div>
                <div class="col-lg-6">

                    <p>
                        <span v-if="product.status">
                            <span class="badge badge-danger">Inactivo</span>
                        </span>
                        <span v-else>
                            <span class="badge badge-success">Activo</span>
                        </span>

                        <span v-if="product.slug">
                            <span class="badge badge-success">Slug OK</span>
                        </span>
                        <span v-else>
                            <span class="badge badge-danger">Sin Slug</span>
                        </span>

                        <template v-if="product.slug">
                          <a :href="'/'+shop.slug+'/producto/'+product.slug">Ver en Web</a>
                        </template>
                        <template v-else>
                          <a :href="'/'+shop.slug+'/category/'+product.category.id+'/product/'+product.id">Ver en Web</a>
                        </template>
                    </p>
                    <p class="small text-muted"> <strong>Categoria</strong> <span v-text="product.category.name"></span></p>
                    <div v-if="product.type_course">
                      <span class="badge badge-info">Producto de Tipo Curso: {{product.course_id?'Curso asignado':'Sin Curso Asignado'}} </span>
                      <button type="button" class="btn btn-info btn-sm" @click="abrirModal('product','actualizar_curso', product)" >
                            <i class="fa fa-play"></i>
                      </button>
                    </div>
                    <p> <strong>Key</strong> <span v-text="product.key"></span></p>
                    <p><strong>Precio USD:&nbsp;</strong>$<span v-text="product.cost_dollar"></span> USD</p>
                    <p><strong>Precio MXN:&nbsp;</strong>$<span v-text="product.retail"></span></p>
                    <hr>
                    <p><strong>Código fact.:&nbsp;</strong><span v-text="product.code_fact"></span></p>

                    <div class="row">
                        <div class="col-4">
                            <p><strong>Stock</strong>&nbsp;<a href="#" class="text text-success"><span v-text="arrayStock[product.id]"></span></a></p>
                        </div>
                        <div class="col-4">
                            <p><strong>Exhibition</strong>&nbsp;<a href="#" class="text text-success"><span v-text="arrayExhibition[product.id]"></span></a></p>
                        </div>
                        <div class="col-4">
                            <p><strong>Limit WEB</strong>&nbsp;<a href="#" v-text="product.sales_limit_web"></a></p>
                        </div>



                    </div>
                    <div class="row" v-for="bodega in warehouses" :key="bodega.id">
                      <div class="col-sm-2">
                        <span v-if="bodega.image">
                          <img :src="'/storage/'+bodega.image" :alt="bodega.name" width="32px">
                        </span>
                      </div>
                      <div class="col-sm-10">
                        <strong> <span v-text="bodega.name"></span> Piezas en inventario:</strong> SN
                      </div>
                    </div>



                </div>
                <div class="col-lg-3">
                  <p><strong>Pzs. Vendidas:</strong> {{product.qty_sold}}</p>
                  <div class="row mt-2">
                    <div class="col-7">
                      <div class="text-warning">
                        <!--<span class="fas fa-star-half-alt"></span>-->
                        <template v-for="star in arrayStars[product.id]">
                          <span v-if="star==1" class="fa fa-star"></span>
                          <span v-if="star==5" class="fa fa-star-half-o"></span>
                          <span v-if="star==0" class="fa fa-star-o"></span>
                        </template>
                      </div>
                    </div>
                    <div class="col-5">
                        <form action="" method="post">
                            <select class="form-control" v-model="selectsStars[product.id]" @change="updateStars(product.id)">
                              <option value="0.0">0</option>
                              <option value="0.5">0.5</option>
                              <option value="1.0">1</option>
                              <option value="1.5">1.5</option>
                              <option value="2.0">2</option>
                              <option value="2.5">2.5</option>
                              <option value="3.0">3</option>
                              <option value="3.5">3.5</option>
                              <option value="4.0">4</option>
                              <option value="4.5">4.5</option>
                              <option value="5.0">5</option>
                            </select>
                        </form>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-6">
                        <template v-if="product.featured">
                          <button type="button" class="btn btn-info btn-sm" @click="nodestacarProducto(product.id)">
                            <i class="fa fa-heart"></i> No Destacar
                          </button>
                        </template>
                        <template v-else>
                          <button type="button" class="btn btn-outline-info btn-sm" @click="destacarProducto(product.id)">
                            <i class="fa fa-heart"></i> Destacar
                          </button>
                        </template>
                    </div>
                    <div class="col-6">
                          <template v-if="product.status">
                            <button type="button" class="btn btn-warning btn-sm" @click="activarProducto(product.id)">
                              <i class="fa fa-thumbs-up"></i>&nbsp;Activar
                            </button>
                          </template>
                          <template v-else>
                            <button type="button" class="btn btn-outline-warning btn-sm" @click="desactivarProducto(product.id)">
                              <i class="fa fa-thumbs-down"></i>&nbsp;Desactivar
                            </button>
                          </template>
                    </div>
                  </div><!--./row-->
                  <br>
                  <div class="dropdown">
                    <button class="btn btn-secondary btn-block dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                      Acciones
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_code_fact', product)">Actualizar código facturación</a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_categoria', product)">Actualizar Categoría</a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_qty_sold', product)">
                          <i class="fa fa-sort-numeric-up"></i> Actualizar Piezas vendidas
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_datos', product)">
                          <i class="fa fa-edit"></i> Actualizar Datos
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','agregar_stock', product)">
                          <i class="fa fa-cubes"></i> Agregar Stock
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_stock', product)">
                          <i class="fa fa-cubes-alt"></i> Actualizar Stock
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_costos', product)">
                          <i class="fa fa-money"></i> Actualizar Costos
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_barcode', product)">
                          <i class="fa fa-barcode"></i> Actualizar Codigo de Barras
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('product','actualizar_slug', product)">
                          <i class="fa fa-link"></i> Actualizar Slug
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" @click="eliminarProducto(product.id)">
                          <i class="fa fa-trash"></i>&nbsp;Eliminar
                        </a>
                    </div>
                  </div>

                </div>

            </div><!--./ row-datos-product-->
          </div><!--.card-body-product-->
        </div><!--.card-product-->

        <nav>
              <ul class="pagination">
                  <li class="page-item" v-if="pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio,filtro_status)">Ant</a>
                  </li>

                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,filtro_status)" v-text="page"></a>
                  </li>

                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio,filtro_status)">Sig</a>
                  </li>
              </ul>
          </nav>

      </div><!--./card-body-gral-->
    </div><!--./card-gral-->
  </div><!--./container-->

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
                    <form v-on:submit.prevent action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                        <div v-show="errorProducto" class="form-group row div-error">
                          <div class="container-fluid">
                            <div class="alert alert-danger text-center">
                                <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">
                                </div>
                            </div>
                          </div>
                        </div>

                        <p><em><strong class="text text-danger">* Campos obligatorios</strong></em></p>

                        <!--tipoAccion==3: Act Costos-->
                        <div v-if="tipoAccion==3">

                          <div class="alert alert-info text-center">
                            <p><strong> <i class="fa fa-warning"></i> El costo actual de dolar es ${{dollar_price}}</strong></p>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label"> <strong class="text text-danger">*</strong> Precio USD</label>
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

                        </div>
                        <!--./tipoAccion==3: Act Costos-->
                        <!--tipoAccion==4: Act Slug-->
                        <div v-else-if="tipoAccion==4">

                          <div class="form-group">
                            <label for="barcode">Slug</label>
                            <input type="text" class="form-control" v-model="slug"  placeholder="Enter Slug" required>
                          </div>
                          <div v-if="errors.slug" class="text-danger">{{errors.slug[0]}}</div>
                        </div>
                        <!--./tipoAccion==4: Act Costos-->

                        <div v-else-if="tipoAccion==5">

                          <div class="row">
                            <div class="col-6">

                            <h3>Imagen Principal</h3>
                             <img :src="image" alt="" class="img img-thumbnail">

                              <div class="custom-file">
                                <input type="file" class="custom-file-input" name="main_image" @change="uploadMainImage" required>
                                <label class="custom-file-label" for="main_image">Choose file</label>
                              </div>

                            </div>
                            <div class="col-6">
                              <p>Other images</p>
                              <!--
                              <h3>Images del Producto</h3>
                              <div class="row" v-for="img in imagesProduct" :key="img.id">
                                <div class="col-6">
                                  <div class="card" style="width: 10rem;">
                                    <img class="card-img-top" :src="'/storage/'+img.image" alt="Card image cap">
                                  </div>
                                </div>
                              </div>
                              -->
                            </div>
                          </div><!--./row-->

                        </div>
                        <!--./tipoAccion==5: Update Imagenes-->

                        <!--tipoAccion==6: Act Barcode-->
                        <div v-else-if="tipoAccion==6">

                          <div class="container-fluid">
                            <div class="alert alert-danger text-center">
                                <p><i class="fa fa-warning"></i> IMPORTANTE: Al actualizar el código de barras de un producto debe actualizar los códigos impresos. El código modificado dejara de existir en la BD.</p>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="barcode">Codigo de barras</label>
                            <input type="text" class="form-control" v-model="barcode"  placeholder="Enter codigo de barras" required>
                             <barcode :value="barcode" :options="{format:'EAN-13'}">Generando código de barras</barcode>
                          </div>
                          <div v-if="errors.barcode" class="text-danger">{{errors.barcode[0]}}</div>
                        </div>
                        <!--./tipoAccion==6: Act Barcode-->

                        <!--tipoAccion==7: Add Stock-->
                        <div v-else-if="tipoAccion==7">
                          <h2>Agregar Piezas</h2>
                          <div class="form-group">
                            <label>Piezas</label>
                            <input type="number" min="0" step="1" class="form-control" placeholder="Ingrese Piezas" v-model="exhibition">
                          </div>
                        </div>
                        <!--./tipoAccion==7: Add Stock-->

                        <!--tipoAccion==8: Edit Piezas vendidad Qty Sold-->
                        <div v-else-if="tipoAccion==8">
                          <h2>Actualizar Piezas Vendidas</h2>
                           <strong class="text text-danger">*</strong>
                           <div class="form-group">
                            <label>Pz.</label>
                            <input type="number" min="0" step="1" class="form-control" placeholder="Piezas " v-model="qty_sold">
                          </div>
                        </div>
                        <!--./tipoAccion==8: Edit Piezas vendidad Qty Sold-->

                        <!--tipoAccion==9: Edit Categoria Producto-->
                        <div v-else-if="tipoAccion==9">
                          <h2>Actualizar Categoría</h2>
                          <div class="form-group">
                            <label>Seleccione categoria</label>
                            <select class="form-control" v-model="new_category">
                              <option v-for="cat in arrayCategories" :key="cat.id" :value="cat.id" v-text="cat.name"></option>
                            </select>
                          </div>

                        </div>
                        <!--./tipoAccion==9: Edit Categoria Producto-->

                        <!--tipoAccion==10: Edit Stock-->
                        <div v-else-if="tipoAccion==10">
                          <h2>Actualizar Stock</h2>
                          <div v-for="inv in arrayInventarios" :key="inv.id">
                            <div class="form-group">
                              <label>Reg: {{inv.description}}, Pzs. {{ inv.exhibition}} <span class="small text-muted">{{ inv.created_at}}</span> </label>
                              <input type="number" min="0" step="1" class="form-control" placeholder="Ingrese Piezas" v-model="arrayInputsEx[inv.id]">
                              <button type="button" class="btn btn-primary" @click="actualizarStockInventario(inv.id)">Actualizar</button>
                            </div>
                          </div>
                        </div>
                        <!--./tipoAccion==10: Edit Stock-->

                        <!--tipoAccion==11: Edit Code Fact-->
                        <div v-else-if="tipoAccion==11">
                          <h2>Actualizar código de facturación</h2>
                          <div class="form-group">
                            <label for="code_fact">Código</label>
                            <input type="text" class="form-control" v-model="code_fact"  placeholder="Ingrese código" required>

                          </div>

                        </div>
                        <!--./tipoAccion==10: Edit Stock-->

                        <!--tipoAccion==12: Edit Categoria Producto-->
                        <div v-else-if="tipoAccion==12">
                          <h2>Actualizar Curso</h2>
                          <div class="form-group">
                            <label>Seleccione curso</label>
                            <select class="form-control" v-model="new_course">
                              <option v-for="curso in arrayCourses" :key="curso.id" :value="curso.id" v-text="curso.name"></option>
                            </select>
                          </div>

                        </div>
                        <!--./tipoAccion==12: Edit Curso Producto-->


                        <!--tipoAccion==1 o 2: Agregar o ACtualizar-->
                        <div v-else>
                          <div class="form-group">
                            <strong class="text text-danger">*</strong><label for="key">Key</label>
                            <input type="text" class="form-control" v-model="key"  placeholder="Enter Key" required>
                          </div>

                          <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input type="text" class="form-control" v-model="barcode"  placeholder="Enter Barcode" required>
                            <barcode :value="barcode" :options="{format:'EAN-13'}">Generando código de barras</barcode>
                          </div>

                          <div class="form-group">
                            <strong class="text text-danger">*</strong><label for="name">Name</label>
                            <input type="text" class="form-control" v-model="name"  placeholder="Enter Name" required>
                          </div>

                          <div class="form-group">
                            <strong class="text text-danger">*</strong><label for="description">Description</label>
                            <textarea class="form-control" v-model="description"  rows="3"></textarea>
                          </div>

                          <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" v-model="status">
                              <option value='0'>Active</option>
                              <option value='1'>Inactive</option>
                            </select>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="type_course" id="chk-curso">
                            <label class="form-check-label" for="chk-curso">Tipo curso</label>
                          </div>

                          <div class="form-group">
                            <label for="url_video">URL Video</label>
                            <input type="text" class="form-control" v-model="url_video" placeholder="Enter URL Video">
                          </div>

                        </div>
                        <!--./tipoAccion==1 o 2: Agregar o ACtualizar-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProductos()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarDatosProducto()">Actualizar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="actualizarCostos()">Actualizar Costos</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="actualizarSlug()">Actualizar Slug</button>
                    <button type="button" v-if="tipoAccion==5" class="btn btn-primary" @click="actualizarMainImage()">Actualizar Imagen Principal</button>
                    <button type="button" v-if="tipoAccion==6" class="btn btn-primary" @click="actualizarBarcode()">Actualizar Codigo</button>
                    <button type="button" v-if="tipoAccion==7" class="btn btn-primary" @click="agregarStock()">Agregar Stock</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="actualizarQtySold()">Actualizar piezas vendidas.</button>
                    <button type="button" v-if="tipoAccion==9" class="btn btn-primary" @click="actualizarCategoria()">Actualizar categoria.</button>
                    <button type="button" v-if="tipoAccion==11" class="btn btn-primary" @click="actualizarCodeFact()">Actualizar código.</button>
                    <button type="button" v-if="tipoAccion==12" class="btn btn-primary" @click="actualizarCurso()">Actualizar curso.</button>
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
    import VueBarcode from 'vue-barcode';

    export default {
        props:['category_id','shop_id'],
        data(){
            return {
                arrayCategories:[],
                arrayCourses:[],
                arrayProducts:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorProducto:0,
                errorMostrarMsjProducto:[],

                product_id:0,
                nameProduct:'',
                //add & edit
                key:'',
                barcode:'',
                name:'',
                description :'',
                url_video:'',
                type_course:0,
                status:0,
                //act costos
                cost:0,
                retail:0,
                cost_dollar:0,
                wholesale:0,
                slug:'',
                image:'',
                qty_sold:0,
                new_category:0,
                new_course:0,

                product_new_retail:0,
                product_new_cost_usd :0,
                product_retail:0,
                product_cost_usd :0,

                code_fact:'',


                exhibition:0,
                arrayInventarios:[],


                selectsStars:[],
                arrayStars:[],

                errors:[],

                arrayInputsEx:[],

                arrayExhibition:[],
                arrayStock:[],

                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0
                },
                busqueda_gral:false,
                offset:3,
                criterio:'name',
                buscar:'',
                filtro_status:'activos',
                warehouses:[],

                imagesProduct:[],

                dollar_price:0,
                main_image:null,
                shop:{}

            }
        },
        components: {
          'barcode': VueBarcode
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
            uploadMainImage(event) {
                this.main_image = event.target.files[0];
                console.log(this.main_image)
            },

            loadDatosShop(){
              let me=this;
              axios.get('/products/get-datos-shop/'+me.shop_id).then(function (response) {
                  //console.log(response);
                  me.shop = response.data;
                  console.log(me.shop);
                })
                .catch(function (error) {
                // handle error
                console.log(error);
                })
                .finally(function () {
                // always executed
                });
            },
            listarProductos(page,buscar,criterio,filtro_status){
                //console.log('listando Products')
                let me=this;
                var gral = 0;
                if(me.busqueda_gral) gral=1;
                var url = '/products/get-products/'+me.category_id+'/?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&busqueda_gral='+gral+'&filtro_status='+filtro_status;
                axios.get(url).then(function (response) {
                  console.log(response);
                    //console.log(response);
                    me.dollar_price = response.data.dollar_price;

                    me.warehouses = response.data.warehouses;
                    //console.log(me.warehouses);
                    me.arrayProducts = response.data.products.data;
                    me.pagination = response.data.pagination;
                    var arrayTemp=new Array();
                    var arrayTempStars=new Array();

                    var arrayTempEx=new Array();
                    var arrayTempSt=new Array();

                    for (var i = 0; i < me.arrayProducts.length; i+=1) {
                      var ex=0;
                      var st=0;
                      arrayTemp[me.arrayProducts[i].id]=me.arrayProducts[i].stars;
                      arrayTempStars[me.arrayProducts[i].id] = me.procesarStars(me.arrayProducts[i].stars);

                      for (var j = 0; j < me.arrayProducts[i].inventory_product.length; j+=1) {
                          ex += me.arrayProducts[i].inventory_product[j].exhibition;
                          st += me.arrayProducts[i].inventory_product[j].stock;
                      }

                      arrayTempEx[me.arrayProducts[i].id]=ex;
                      arrayTempSt[me.arrayProducts[i].id]=st;

                    }

                    me.selectsStars=arrayTemp;
                    me.arrayStars=arrayTempStars;

                    me.arrayExhibition=arrayTempEx;
                    me.arrayStock     =arrayTempSt;
                    //console.log(me.arrayStars)
                })
                .catch(function (error) {
                // handle error
                console.log(error);
                })
                .finally(function () {
                // always executed
                });
            },
            getCategories(){
              let me=this;
              var url = '/products/get-categories-shop/'+me.shop_id;
              axios.get(url).then(function (response) {
                console.log(response);
                me.arrayCategories = response.data;
                console.log( me.arrayCategories );
              })
              .catch(function (error) {
              // handle error
              console.log(error);
              })
              .finally(function () {
              // always executed
              });

            },
            getCursos(){
              let me=this;
              var url = '/products/get-courses-shop/'+me.shop_id;
              axios.get(url).then(function (response) {
                console.log(response);
                me.arrayCourses = response.data;
                console.log( me.arrayCourses );
              })
              .catch(function (error) {
              // handle error
              console.log(error);
              })
              .finally(function () {
              // always executed
              });

            },
            generarSlug(id){
              let me=this;
              axios.post('/admin/products/get/slug-to-product',{
                'id':id
              }).then(function (response) {
                    me.slug=response.data;
              }).catch(function (error) {
                // handle error
              console.log(error);
              })
              .finally(function () {
              // always executed
              });
            },
            procesarStars(num_stars){
              var aStars = new Array();
              let entero = Math.floor(num_stars);
              let fraccion = num_stars - entero;
              let resto = 5 - Math.ceil(num_stars);
              let ind_act=0;
              aStars[1]=0;
              aStars[2]=0;
              aStars[3]=0;
              aStars[4]=0;
              aStars[5]=0;
              for (var i = 1; i <= entero; i++) {
                aStars[i]=1;
                ind_act=i;
              }
              if(ind_act<5 && fraccion){
                aStars[ind_act+1]=5;
              }
              return aStars;
            },
            updateStars(id){
                let me=this;
                axios.put('/admin/products/update-stars',{
                    'id': id,
                    'stars': me.selectsStars[id]
                }).then(function (response){
                    //me.listarProductos(1,'','name','activos');
                    me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarCostos(){
                if(this.validarCostos()){
                    return;
                }
                let me=this;
                axios.put('/admin/products/update-costos/',{
                    'id': me.product_id,
                    'new_retail': me.product_new_retail,
                    'new_cost_usd': me.product_new_cost_usd
                }).then(function (response){
                  me.cerrarModal();
                  //me.listarProductos(1,'','name','activos');
                  me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                }).catch(function (error){
                    console.log(error);
                });
            },
            calcular:function (event){
              console.log(this.product_new_cost_usd)
              this.product_new_retail = this.dollar_price * this.product_new_cost_usd
            },
            actualizarSlug(){
                let me=this;
                me.errors=[];
                axios.put('/admin/products/update-slug/',{
                  'slug':me.slug,
                  'id': me.product_id
                }).then(function (response){
                  console.log(response)
                  me.cerrarModal();
                  //me.listarProductos(1,'','name','activos');
                  me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                }).catch(function (error){
                    if (error.response.status == 422){
                      me.errors=error.response.data.errors;
                    }
                });
            },
            actualizarBarcode(){
                let me=this;
                me.errors=[];
                axios.put('/admin/products/update-barcode/',{
                  'barcode':me.barcode,
                  'id': me.product_id
                }).then(function (response){
                  console.log(response)
                  me.cerrarModal();
                  //me.listarProductos(1,'','name','activos');
                  me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                }).catch(function (error){
                    if (error.response.status == 422){
                      me.errors=error.response.data.errors;
                    }
                });
            },
            registrarProductos(){
                if(this.validarDatosProduct()){
                    return;
                }
                let me=this;
                axios.post('/products/create',{
                  'proveedor':1,
                  'category':me.category_id,
                  'key':me.key,
                  'barcode':me.barcode,
                  'name':me.name,
                  'description':me.description,
                  'status':me.status,
                  'url_video':me.url_video,
                  'type_course':me.type_course
                }).then(function (response){
                  //console.log(response)
                  me.cerrarModal();
                  me.listarProductos(1,me.buscar,me.criterio,me.filtro_status);
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarDatosProducto(){
                if(this.validarDatosProduct()){
                    return;
                }
                let me=this;
                axios.put('/admin/products/update-datos',{
                  'id':me.product_id,
                  'key':me.key,
                  'barcode':me.barcode,
                  'name':me.name,
                  'description':me.description,
                  'status':me.status,
                  'url_video':me.url_video,
                  'type_course':me.type_course,
                }).then(function (response){
                  //console.log(response)
                  me.cerrarModal();
                  //me.listarProductos(1,'','name','activos');
                  me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarMainImage(){
                let me=this;
                const formData = new FormData();
                formData.append('product_id', this.product_id);

                if(!this.main_image){
                    Swal.fire({
                      title: 'Error',
                      text: 'Por favor seleccionar una imagen.',
                      icon: 'error',
                    });
                    return;
                }

                let main_image = this.main_image;
                console.log(main_image);
                let imageType = main_image.type;
                if(imageType.indexOf('image/') === -1){
                    Swal.fire({
                      title: 'Error',
                      text: 'El archivo seleccionado no es una imagen',
                      icon: 'error',
                    });
                    return;
                }
                formData.append('main_image', this.main_image);

                Swal.fire({
                    title: 'Cargando...',
                    onBeforeOpen: () => {
                      Swal.showLoading()
                    },
                    allowOutsideClick: false,
                });

                axios.post('/admin/products/update-main-images',formData)
                .then(function (response){
                    console.log(response);
                    Swal.close();
                    me.cerrarModal();
                    me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                    Swal.fire({
                        title: 'Exitoso',
                        text: 'La imagen ha sido guardada exitosamente',
                        icon: 'success',
                    });
                }).catch(function (error){
                    console.log(error);
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar la imagen',
                        icon: 'error',
                      });
                });
            },
            validarCostos(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto=[];
                if(!this.product_new_retail) this.errorMostrarMsjProducto.push('El nuevo precio público no puede estar vacio');
                if(!this.product_new_cost_usd) this.errorMostrarMsjProducto.push('El nuevo costo USD no puede estar vacio');
                if(this.errorMostrarMsjProducto.length) this.errorProducto=1;

                return this.errorProducto;
            },
            validarQtySold(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto=[];
                if(!this.qty_sold) this.errorMostrarMsjProducto.push('Las piezas no pueden estar vacias');
                if(this.errorMostrarMsjProducto.length) this.errorProducto=1;
                return this.errorProducto;
            },
            validarDatosProduct(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto=[];
                if(!this.key) this.errorMostrarMsjProducto.push('El valor key no puede estar vacio.');
                if(!this.name) this.errorMostrarMsjProducto.push('El valor name no puede estar vacio.');
                if(!this.description) this.errorMostrarMsjProducto.push('El valor description no puede estar vacio.');
                if(this.errorMostrarMsjProducto.length) this.errorProducto=1;
                return this.errorProducto;
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
                      axios.put('/admin/products/nodestacar',{
                          'id': id
                      }).then(function (response){
                          //me.listarProductos(1,'','name','activos');
                          me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                          swalWithBootstrapButtons.fire(
                            'Producto No Destacado!',
                            'El producto ha sido actualizado con exito.',
                            'success'
                          )
                      }).catch(function (error){
                          console.log(error);
                      });

                    }
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
                      axios.put('/admin/products/destacar',{
                          'id': id
                      }).then(function (response){
                          //me.listarProductos(1,'','name','activos');
                          me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                          swalWithBootstrapButtons.fire(
                            'Producto Destacado!',
                            'El producto ha sido actualizado con exito.',
                            'success'
                          )
                      }).catch(function (error){
                          console.log(error);
                      });

                    }
                  })
            },
            activarProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                  })

                  swalWithBootstrapButtons.fire({
                    title: '¿Desea volver a activar esta producto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.value) {

                      let me=this;
                      axios.put('/admin/products/activar',{
                          'id': id
                      }).then(function (response){
                          //me.listarProductos(1,'','name','activos');
                          me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                          swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El producto ha sido activado con exito.',
                            'success'
                          )
                      }).catch(function (error){
                          console.log(error);
                      });

                    }
                  })
            },
            desactivarProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea desactivar este producto?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/products/desactivar',{
                        'id': id
                    }).then(function (response){
                        //me.listarProductos(1,'','name','activos');
                        me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
                        swalWithBootstrapButtons.fire(
                          'Desactivado!',
                          'El producto ha sido desactivado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
            eliminarProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Realmente desea eliminar este producto?',
                  text: "Esta acción borrará al producto definitivamente de la base de datos.",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/products/eliminar',{
                        'id': id
                    }).then(function (response){
                        //console.log(response);
                        //me.listarProductos(1,'','name','activos');
                        me.listarProductos(1,me.buscar,me.criterio,me.filtro_status);
                        swalWithBootstrapButtons.fire(
                          'Eliminado!',
                          'El producto ha sido eliminado exitosamente.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
            getInventariosProduct(product_id){
              let me=this;
                var url = '/inventories/get/'+product_id
                axios.get(url).then(function (response) {

                  //console.log(response);
                  me.arrayInventarios=[];
                  me.arrayInventarios=response.data
                  console.log(me.arrayInventarios)

                  var temp=[]
                  me.arrayInventarios.map(function(x){
                    temp[x.id]=x.exhibition;
                  });
                  me.arrayInputsEx=[];
                  me.arrayInputsEx=temp;
                })
                .catch(function (error) {
                // handle error
                console.log(error);
                })
                .finally(function () {
                // always executed
                });
            },
            agregarStock(){
              let me=this;
              axios.post('/inventories/store-exhibition',{
                'product_id':me.product_id,
                'exhibition':me.exhibition,
              }).then(function (response) {
                 console.log(response)
                  me.product_id=0;
                  me.exhibition=0;
                  me.arrayInventarios=[];
                  me.cerrarModal();
                  //me.listarProductos(1,'','name','activos');
                  me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
              }).catch(function (error) {
                // handle error
              console.log(error);
              })
              .finally(function () {
              // always executed
              });
            },
            actualizarQtySold (){
              if(this.validarQtySold()){
                    return;
              }
              let me=this;
              axios.put('/admin/products/update-qty-sold',{
                'qty_sold':me.qty_sold,
                'id': me.product_id
              }).then(function (response){
                console.log(response)
                me.cerrarModal();
                //me.listarProductos(1,'','name','activos');
                me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
              }).catch(function (error){
                  if (error.response.status == 422){
                   //this.validationErrors = error.response.data.errors;
                    me.errors=error.response.data.errors;
                  }
              });
            },
            actualizarCategoria (){
              let me=this;
              axios.put('/admin/products/update-category',{
                'category_id':me.new_category,
                'id': me.product_id
              }).then(function (response){
                console.log(response)
                me.cerrarModal();
                //me.listarProductos(1,'','name','activos');
                me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
              }).catch(function (error){
                  if (error.response.status == 422){
                   //this.validationErrors = error.response.data.errors;
                    me.errors=error.response.data.errors;
                  }
              });
            },
            actualizarCurso (){
              let me=this;
              axios.put('/admin/products/update-course',{
                'course_id':me.new_course,
                'id': me.product_id
              }).then(function (response){
                console.log(response)
                me.cerrarModal();
                //me.listarProductos(1,'','name','activos');
                me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
              }).catch(function (error){
                  if (error.response.status == 422){
                   //this.validationErrors = error.response.data.errors;
                    me.errors=error.response.data.errors;
                  }
              });
            },
            actualizarStockInventario(inv_id){
              let me=this;
              console.log('put '+me.arrayInputsEx[inv_id]+'/'+inv_id);
             axios.put('/inventories/update-exhibition',{
                'inv_id': inv_id,
                'ex': me.arrayInputsEx[inv_id]
              }).then(function (response){
                console.log(response)
                me.cerrarModal();
                //me.listarProductos(1,'','name','activos');
                me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
              }).catch(function (error){
                  if (error.response.status == 422){
                   //this.validationErrors = error.response.data.errors;
                    me.errors=error.response.data.errors;
                  }
              });
            },
            actualizarCodeFact(){

              let me=this;
              axios.put('/admin/products/update-code-fact',{
                'code_fact':me.code_fact,
                'id': me.product_id
              }).then(function (response){
                console.log(response)
                me.cerrarModal();
                me.listarProductos(me.pagination.current_page,me.buscar,me.criterio,me.filtro_status);
              }).catch(function (error){
                  if (error.response.status == 422){
                   //this.validationErrors = error.response.data.errors;
                    me.errors=error.response.data.errors;
                  }
              });

            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "product":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Agregar Producto';
                                this.key='';
                                this.barcode='';
                                this.name='';
                                this.description ='';
                                this.url_video='';
                                this.type_course=0;
                                break;
                            }
                            case 'actualizar_datos':{
                                //console.log(data);
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar Producto';
                                this.product_id=data['id'];
                                this.key=data['key'];
                                this.barcode=data['barcode'];
                                this.name=data['name'];
                                this.description =data['description'];
                                this.url_video=data['url_video'];
                                this.type_course=data['type_course'];
                                this.status=data['status'];
                                break;

                            }
                            case 'actualizar_costos':{
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Actualizar Costos';

                                this.product_id=data['id'];
                                this.nameProduct=data['name'];

                                this.product_new_retail= data['retail'];
                                this.product_retail=data['retail'];
                                this.product_cost_dollar=data['cost_dollar'];
                                this.product_new_cost_usd =data['cost_dollar'];

                                break;

                            }
                            case 'actualizar_slug':{
                                this.modal=1;
                                this.tipoAccion=4;
                                this.tituloModal='Actualizar Slug';
                                this.product_id=data['id'];
                                this.slug=data['slug'];
                                if(!this.slug){
                                  this.generarSlug(this.product_id);
                                }
                                break;
                            }
                            case 'update_image':{
                                this.modal=1;
                                this.tipoAccion=5;
                                this.tituloModal='Editar Imagenes';
                                this.product_id=data['id'];
                                this.image=data['image'];
                                this.imagesProduct=[];
                                this.imagesProduct = data['images'];
                                console.log(this.imagesProduct)
                                break;
                            }
                            case 'actualizar_barcode':{
                                this.modal=1;
                                this.tipoAccion=6;
                                this.tituloModal='Actualizar Código de barras';
                                this.product_id=data['id'];
                                this.barcode=data['barcode'];
                                break;
                            }

                            case 'agregar_stock':{
                                this.getInventariosProduct(data['id'])
                                this.modal=1;
                                this.tipoAccion=7;
                                this.tituloModal='Agrerar Stock';
                                this.product_id=data['id'];
                                this.exhibition=0;
                                break;
                            }

                            case 'actualizar_qty_sold':{
                                this.modal=1;
                                this.tipoAccion=8;
                                this.tituloModal='Actualizar Piezas Vendidas';
                                this.product_id=data['id'];
                                this.qty_sold=data['qty_sold'];
                                break;
                            }
                            case 'actualizar_categoria':{
                                this.getCategories()
                                this.modal=1;
                                this.tipoAccion=9;
                                this.tituloModal='Actualizar Categoria';
                                this.product_id=data['id'];
                                this.new_category=data['category_id'];
                                break;
                            }
                            case 'actualizar_stock':{
                                this.getInventariosProduct(data['id'])
                                this.modal=1;
                                this.tipoAccion=10;
                                this.tituloModal='Actualizar Stock';
                                this.product_id=data['id'];
                                this.exhibition=0;
                                break;
                            }

                            case 'actualizar_code_fact':{
                                this.modal=1;
                                this.tipoAccion=11;
                                this.tituloModal='Actualizar código facturación';
                                this.product_id=data['id'];
                                this.code_fact=data['code_fact'];
                                break;
                            }
                          case 'actualizar_curso':{
                                this.getCursos()
                                this.modal=1;
                                this.tipoAccion=12;
                                this.tituloModal='Curso';
                                this.product_id=data['id'];
                                this.new_course=data['course_id'];
                                break;
                            }
                        }
                    }
                }
            },
            cambiarPagina(page,buscar,criterio,filtro_status){
              let me = this;
              me.pagination.current_page = page;
              me.listarProductos(page,buscar,criterio,filtro_status);
            },
        },
        mounted() {
            this.loadDatosShop()
            this.listarProductos(1,'','name','activos')

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

    .barcode-container {
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
    }
</style>
