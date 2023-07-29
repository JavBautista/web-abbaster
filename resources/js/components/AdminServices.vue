<template>
  <div class="container">

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Servicios
                <button type="button" @click="abrirModal('service','registrar')" class="btn btn-primary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Estatus</th>
                                <th>Imagenes</th>
                                <th>Video</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Sulg</th>
                                <th>Costo</th>
                                <th>Creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="service in arrayServices" :key="service.id">
                                <td>
                                    <button type="button" @click="abrirModal('service','actualizar', service)" class="btn btn-info btn-block" title="Editar información">
                                      <i class="icon-pencil"></i> Editar Info
                                    </button>

                                    <button type="button" @click="abrirModal('service','images', service)" class="btn btn-info btn-block" title="Editar información">
                                      <i class="fa fa-image"></i> Actualizar Imagenes
                                    </button>

                                    <template v-if="service.url_video!== null">
                                        <button type="button"   @click="eliminarVideo(service.id)" class="btn btn-danger btn-block">
                                            <i class="fa fa-video"></i> Eliminar Video
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button"   @click="abrirModal('service','store-video', service)" class="btn btn-info btn-block">
                                            <i class="fa fa-video"></i> Subir Video
                                        </button>
                                    </template>

                                    <template v-if="service.active">
                                        <button type="button" class="btn btn-warning btn-block" @click="desactivarservice(service.id)" title="Desactivar">
                                          <i class="fa fa-eye-slash"></i> Descativar
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-secondary btn-block" @click="activarservice(service.id)" title="Activar">
                                          <i class="fa fa-eye"></i> Activar
                                        </button>
                                    </template>
                                    <button type="button" class="btn btn-danger btn-block" @click="eliminarservice(service.id)" title="Eliminar">
                                          <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </td>
                                <td align="center">
                                    <template v-if="service.active">
                                        <div class="badge bg-success">Activo</div>
                                    </template>
                                    <template v-else>
                                        <div class="badge bg-danger">Inactivo</div>
                                    </template>
                                </td>
                                <td align="center">
                                    <template v-if="service.image !== null">
                                        SI
                                    </template>
                                    <template v-else>
                                        NO
                                    </template>
                                </td>
                                <td align="center">
                                    <template v-if="service.url_video!== null">
                                        <button class="btn  btn-info" @click="abrirModal('service','open-video', service)" ><i class="fa fa-play"></i></button>
                                    </template>
                                    <template v-else>
                                        <span class="text-muted">

                                            <i class="fa fa-play"></i>
                                        </span>
                                    </template>
                                </td>
                                <td v-text="service.name"></td>
                                <td v-text="service.description.length > 50 ? service.description.slice(0, 50) + '...' : service.description"></td>

                                <td v-text="service.slug"></td>
                                <td>$<span v-text="service.cost"></span></td>
                                <td v-text="service.created_at"></td>
                            </tr>

                        </tbody>
                    </table>
                </div><!--./ class="table-responsive" -->
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1)">Ant</a>
                        </li>

                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                        </li>

                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1)">Sig</a>
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
                    <form v-on:submit.prevent action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <!--./tipoAcion==3: Update Imagenes-->
                        <div v-if="tipoAccion==3">
                            <div class="row">
                                <div class="col-4">

                                <h3>Imagen Principal</h3>
                                <img :src="image" alt="" class="img img-thumbnail">
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="main_image" id="main_image"  @change="uploadMainImage"  aria-describedby="main_image_addon">
                                        <label class="custom-file-label" for="main_image">Choose file</label>
                                      </div>
                                      <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="main_image_addon" @click="actualizarMainImage()">Subir</button>
                                      </div>
                                    </div>

                                </div>
                                <div class="col-8">
                                    <p>Other images</p>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="other_image" namew="other_image" @change="uploadOtherImage" aria-describedby="otehr_image_addon">
                                            <label class="custom-file-label" for="other_image">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="otehr_image_addon" @click="actualizarOtherImage()">Subir</button>
                                        </div>
                                    </div>

                                    <h3>Images secundarias</h3>
                                    <div class="row">
                                        <div class="col-6" v-for="img_alt in imagesService" :key="img_alt.id">
                                            <div class="card" style="width: 10rem;">
                                                <img class="card-img-top" :src="'/storage/'+img_alt.image" alt="Card image cap">
                                            </div>
                                            <div class="card-body">
                                                <button class="btn btn-outline-danger" @click="eliminarOtherImage(img_alt.id)"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!--./row-->
                        </div><!--.end tipoAcion==3 -->
                        <!--./tipoAcion==4: Upload Video-->
                        <div v-else-if="tipoAccion==4">
                            <div class="form-group">
                                <label>Video</label>
                                <input class="form-control"  type="file" name="video" @change="uploadVideo">
                            </div>
                        </div><!--.end tipoAcion==4 -->
                        <!--./tipoAcion==5: View Video-->
                        <div v-else-if="tipoAccion==5">
                            <video :src="url_video" width="100%" controls></video>
                        </div><!--.end tipoAcion==5 -->

                        <!--tipoAccion==1 o 2: Agregar o ACtualizar-->
                        <div v-else>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Nombre</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="name" class="form-control" placeholder="Ingrese nombre del service">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Descripción</label>
                              <div class="col-md-9">
                                  <textarea class="form-control" v-model="description"  rows="3"></textarea>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Costo del Servicio</label>
                              <div class="col-md-9">
                                  <input type="number" min="0" step="1" class="form-control" placeholder="Ingrese un costo" v-model="cost">
                              </div>
                          </div>
                        </div><!--.end v-else -->
                        <!--SECTION SHOW ERROR-->
                        <div v-show="error" class="alert alert-warning text-center">
                            <div class="form-group row div-error">

                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsj" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--./SECTION SHOW ERROR-->


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="createService()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="editService()">Actualizar datos</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="createVideo()">Guardar</button>

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
            return {
                service_id:0,
                name:'',
                description:'',
                active:0,
                cost: 0,

                arrayServices:[],
                imagesService:[],

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
                main_image:null,
                other_image:null,
                video:null,
    		}
    	},//.data()
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

            loadServices(page){
              let me=this;
              var url = `/admin/shop/services-get/${me.shop_id}?page=${page}`;
              // Make a request for a user with a given ID
              axios.get(url).then(function (response) {
                  var respuesta  = response.data;
                  me.arrayServices = respuesta.services.data;
                  me.pagination = respuesta.pagination;
                  console.log(me.arrayServices);
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                })
                .finally(function () {
                  // always executed
                });

            },
            uploadMainImage(event) {
                this.main_image = event.target.files[0];
                console.log(this.main_image)
            },
            uploadOtherImage(event) {
                this.other_image = event.target.files[0];
                console.log(this.other_image)
            },
            actualizarMainImage(){
                    let me=this;
                    const formData = new FormData();
                    formData.append('service_id', this.service_id);

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

                    axios.post('/admin/service/update-main-image',formData)
                    .then(function (response){
                        console.log(response);
                        Swal.close();
                        me.cerrarModal();
                        me.loadServices(me.pagination.current_page);
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
            actualizarOtherImage(){
                    console.log('subir other image');
                    let me=this;
                    const formData = new FormData();
                    formData.append('service_id', this.service_id);

                    if(!this.other_image){
                        Swal.fire({
                          title: 'Error',
                          text: 'Por favor seleccionar una imagen.',
                          icon: 'error',
                        });
                        return;
                    }

                    let other_image = this.other_image;
                    console.log(other_image);
                    let imageType = other_image.type;
                    if(imageType.indexOf('image/') === -1){
                        Swal.fire({
                          title: 'Error',
                          text: 'El archivo seleccionado no es una imagen',
                          icon: 'error',
                        });
                        return;
                    }
                    formData.append('other_image', this.other_image);

                    Swal.fire({
                        title: 'Cargando...',
                        onBeforeOpen: () => {
                          Swal.showLoading()
                        },
                        allowOutsideClick: false,
                    });

                    axios.post('/admin/service/upload-other-image',formData)
                    .then(function (response){
                        console.log(response);
                        Swal.close();
                        me.cerrarModal();
                        me.loadServices(me.pagination.current_page);
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
            eliminarOtherImage(id){
                console.log('Eliminar ID '+id);
                console.log('Eliminar ID '+id);
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Realmente desea eliminar este imagen?',
                  text:'Esta acción borrara de la Base de datos la imagen.',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/service/delete-other-image',{
                        'id': id
                    }).then(function (response){
                        console.log('return '+ response);
                        me.cerrarModal();
                        me.loadServices(me.pagination.current_page);
                        swalWithBootstrapButtons.fire(
                          'Eliminado!',
                          'Eliminado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                        swalWithBootstrapButtons.fire(
                          'ERROR AL ELIMINAR',
                          'Intente de nuevo o consulte al admimnistardor del sistema.',
                          'error'
                        )
                    });

                  }
                })

            },
            cambiarPagina(page){
                    let me = this;
                    me.pagination.current_page = page;
                    me.loadServices(page);
                },
            createService(){
                    if(this.validarService()){
                        return;
                    }
                    let me=this;

                    axios.post('/admin/service/store',{
                        'description':this.description,
                        'name':this.name,
                        'cost':this.cost,
                        'shop_id':this.shop_id,
                    }).then(function (response){
                        me.cerrarModal();
                        me.loadServices(1);

                    }).catch(function (error){
                        console.log(error);
                    });
                },
            editService(){
                   if(this.validarService()){
                        return;
                    }
                    let me=this;
                    axios.put('/admin/service/update',{
                        'service_id': this.service_id,
                        'description':this.description,
                        'name':this.name,
                        'cost':this.cost,
                    }).then(function (response){
                        me.cerrarModal();
                        me.loadServices(1);

                    }).catch(function (error){
                        console.log(error);
                    });
                },
            desactivarservice(id){
                    const swalWithBootstrapButtons = Swal.mixin({
                      customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                      },
                      buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                      title: '¿Desea desactivar este servicio?',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Aceptar',
                      cancelButtonText: 'Cancelar',
                      reverseButtons: true
                    }).then((result) => {
                      if (result.value) {

                        let me=this;
                        axios.put('/admin/service/deactive',{
                            'id': id
                        }).then(function (response){
                            me.loadServices(1);
                            swalWithBootstrapButtons.fire(
                              'Desactivado!',
                              'Desactivado con exito.',
                              'success'
                            )
                        }).catch(function (error){
                            console.log(error);
                        });

                      }
                    })
                },
            activarservice(id){
                    const swalWithBootstrapButtons = Swal.mixin({
                      customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                      },
                      buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                      title: '¿Desea activar este servicio?',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Aceptar',
                      cancelButtonText: 'Cancelar',
                      reverseButtons: true
                    }).then((result) => {
                      if (result.value) {

                        let me=this;
                        axios.put('/admin/service/active',{
                            'id': id
                        }).then(function (response){
                            me.loadServices(1);
                            swalWithBootstrapButtons.fire(
                              'Activado!',
                              'Activado con exito.',
                              'success'
                            )
                        }).catch(function (error){
                            console.log(error);
                        });

                      }
                    })
                },
            eliminarservice(id){
                    const swalWithBootstrapButtons = Swal.mixin({
                      customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                      },
                      buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                      title: '¿Realmente desea eliminar este servicio?',
                      html: 'Se eliminara el servicio de la base de datos<br> ',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Aceptar',
                      cancelButtonText: 'Cancelar',
                      reverseButtons: true
                    }).then((result) => {
                      if (result.value) {

                        let me=this;
                        axios.put('/admin/service/delete',{
                            'id': id
                        }).then(function (response){
                            me.loadServices(1);
                            swalWithBootstrapButtons.fire(
                              'Eliminado!',
                              'Eliminado con exito.',
                              'success'
                            )
                        }).catch(function (error){
                            console.log(error);
                            swalWithBootstrapButtons.fire(
                              'ERROR AL ELIMINAR',
                              'Intente nuevamente o consulte al administrador del sistema.',
                              'error'
                            )
                        });

                      }
                    })
                },
            validarService(){
                    this.error=0;
                    this.errorMostrarMsj=[];
                    if(!this.name) this.errorMostrarMsj.push('El campo nombre no puede estar vacio');
                    if(!this.description) this.errorMostrarMsj.push('El campo descripción no puede estar vacio');
                    if(this.errorMostrarMsj.length) this.error=1;
                    return this.error;
                },
            cerrarModal(){
                    this.modal=0;
                    this.tituloModal='';
                    this.service_id=0;
                    this.description='';
                    this.name='';
                },
            uploadVideo(event) {
                this.video = event.target.files[0];
                console.log(this.video)
            },
            createVideo(){
                let me=this;
                const formData = new FormData();
                formData.append('service_id', this.service_id);

                if(!this.video){
                    Swal.fire({
                      title: 'Error',
                      text: 'Por favor selecciona un archivo de video',
                      icon: 'error',
                    });
                    return;
                }

                let video = this.video;
                let videoType = video.type;
                if(videoType.indexOf('video/') === -1){
                    Swal.fire({
                      title: 'Error',
                      text: 'El archivo seleccionado no es un archivo de video',
                      icon: 'error',
                    });
                    return;
                }
                if(videoType.indexOf('video/') === -1){
                    Swal.fire({
                      title: 'Error',
                      text: 'El archivo seleccionado no es un archivo de video',
                      icon: 'error',
                    });
                    return;
                }
                formData.append('video', this.video);

                Swal.fire({
                    title: 'Cargando...',
                    onBeforeOpen: () => {
                      Swal.showLoading()
                    },
                    allowOutsideClick: false,
                });

                console.log('Subir video');

                axios.post('/admin/service/store-video',formData,{
                      headers: {
                        'Content-Type': 'multipart/form-data'
                      }
                    })
                .then(function (response){
                    console.log('response: ');
                    console.log(response);
                    me.video = null;
                    Swal.close();
                    me.cerrarModal();
                    me.loadServices(me.pagination.current_page);
                    Swal.fire({
                        title: 'Exitoso',
                        text: 'El video ha sido guardado exitosamente',
                        icon: 'success',
                    });
                }).catch(function (error){
                    console.log('Mi Error: ');
                    console.log(error);
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar el video',
                        icon: 'error',
                      });
                });
            },
            eliminarVideo(id){
                    const swalWithBootstrapButtons = Swal.mixin({
                      customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                      },
                      buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                      title: '¿Realmente desea eliminar este video?',
                      text:'Esta acción borrara de la Base de datos el video.',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Aceptar',
                      cancelButtonText: 'Cancelar',
                      reverseButtons: true
                    }).then((result) => {
                      if (result.value) {

                        let me=this;
                        axios.put('/admin/service/delete-video',{
                            'id': id
                        }).then(function (response){
                            me.loadServices(me.pagination.current_page);
                            swalWithBootstrapButtons.fire(
                              'Eliminado!',
                              'Eliminado con exito.',
                              'success'
                            )
                        }).catch(function (error){
                            console.log(error);
                            swalWithBootstrapButtons.fire(
                              'ERROR AL ELIMINAR',
                              'Intente de nuevo o consulte al admimnistardor del sistema.',
                              'error'
                            )
                        });

                      }
                    })
                },
            getUrlVideo(service_id){
              var url = `/admin/service/video/get-url/${service_id}`;
              // Make a request for a user with a given ID
              let me=this;
              axios.get(url).then(function (response) {
                  console.log('URL de GetURLVideo: ');
                  me.url_video = response.data.url;
                  console.log(me.url_video);
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                })
                .finally(function () {
                  // always executed
                });
            },
            abrirModal(modelo, accion, data=[]){
                    switch(modelo){
                        case "service":{
                            switch(accion){

                                case 'registrar':{
                                    this.modal=1;
                                    this.tituloModal='Agregar';
                                    this.tipoAccion =1;

                                    this.description='';
                                    this.name='';
                                    this.cost=0;
                                    break;
                                }
                                case 'actualizar':{
                                    this.modal=1;
                                    this.tipoAccion =2;
                                    this.tituloModal='Actualizar';

                                    this.service_id=data['id'];
                                    this.description=data['description'];
                                    this.name=data['name'];
                                    this.cost=data['cost'];
                                    break;
                                }
                                case 'images':{
                                    this.modal=1;
                                    this.tipoAccion=3;
                                    this.tituloModal='Editar Imagenes';
                                    this.service_id  = data['id'];
                                    this.image=data['image'];
                                    this.imagesService=[];
                                    this.imagesService = data['images'];
                                    console.log('Img: '+this.image)
                                    break;
                                }

                                case 'store-video':{
                                    this.modal=1;
                                    this.tipoAccion=4;
                                    this.tituloModal='Subir Video';
                                    this.service_id  = data['id'];
                                    this.url_video='';
                                    this.video = null;
                                    console.log('Video: '+this.video)
                                    break;
                                }
                                case 'open-video':{
                                    this.modal=1;
                                    this.tipoAccion=5;
                                    this.tituloModal='Ver Video';
                                    this.service_id  = data['id'];
                                    this.url_video='';
                                    this.getUrlVideo(this.service_id);
                                    break;
                                }

                            }
                        }
                    }
                }

        },//.methods
        mounted() {
          this.loadServices(1)
          console.log(this.shop_id)
          console.log('Component Amdin/Services Mounted')
        }//.mounted
    }//.export default
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
