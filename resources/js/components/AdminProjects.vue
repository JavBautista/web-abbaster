<template>
  <div class="container">

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Proyectos
                <button type="button" @click="abrirModal('proyecto','registrar')" class="btn btn-primary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Estados</th>
                            <th>Titulo</th>
                            <th>Imagenes</th>
                            <th>Video</th>
                            <th>Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="proyecto in arrayProject" :key="proyecto.id">
                            <td>
                                <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                   
                                    <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('proyecto','actualizar', proyecto)">
                                        <i class="fa fa-edit"></i> Actualizar Datos
                                    </a>
                                    
                                    <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('proyecto','images', proyecto)">
                                        <i class="fa fa-images"></i> Actualizar Imagenes
                                    </a>

                                    <template v-if="proyecto.url_video!== null">
                                        <a class="dropdown-item" href="javascript:void(0)" @click="eliminarVideo(proyecto.id)">
                                            <i class="fa fa-video"></i> Eliminar Video
                                        </a>
                                    </template>
                                    <template v-else>
                                        <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('proyecto','store-video', proyecto)">
                                            <i class="fa fa-video"></i> Subir Video
                                        </a>
                                    </template>
                                    
                                    <template v-if="proyecto.active">
                                        <a  class="dropdown-item" @click="desactivarProjecto(proyecto.id)">
                                        <i class="fa fa-thumbs-down"></i> Descativar
                                        </a>
                                    </template>
                                    <template v-else>
                                        <a class="dropdown-item" @click="activarProjecto(proyecto.id)">
                                        <i class="fa fa-thumbs-up"></i> Activar
                                        </a>
                                    </template>
                                    
                                    <template v-if="proyecto.show_home">
                                        <a  class="dropdown-item" @click="ocultarProjectoHome(proyecto.id)">
                                        <i class="fa fa-eye-slash"></i> Ocultar del Inicio
                                        </a>
                                    </template>
                                    <template v-else>
                                        <a class="dropdown-item" @click="mostrarProjectoHome(proyecto.id)">
                                        <i class="fa fa-eye"></i> Mostrar en el Inicio
                                        </a>
                                    </template>

                                    <a class="dropdown-item" href="javascript:void(0)" @click="eliminarProjecto(proyecto.id)">
                                        <i class="fa fa-trash"></i>&nbsp;Eliminar
                                    </a>
                                </div>
                            </div>
                                                                
                            </td>
                            
                            <td align="center">
                                <template v-if="proyecto.active">
                                    <div class="badge bg-success">Activo</div>
                                </template>
                                <template v-else>
                                    <div class="badge bg-danger">Inactivo</div>
                                </template>
                                <br>
                                <template v-if="proyecto.show_home">
                                    <div class="badge bg-success">Mostrar en Home</div>
                                </template>
                                <template v-else>
                                    <div class="badge bg-warning">No mostrado en Home</div>
                                </template>
                            </td>
                            <td v-text="proyecto.title"></td>
                            <td align="center">
                                <template v-if="proyecto.image !== null">
                                    SI
                                </template>
                                <template v-else>
                                    NO
                                </template>
                            </td>
                            <td align="center">
                                <template v-if="proyecto.url_video!== null">
                                    <button class="btn  btn-info" @click="abrirModal('proyecto','open-video', proyecto)" ><i class="fa fa-play"></i></button>
                                </template>
                                <template v-else>
                                    <span class="text-muted">

                                        <i class="fa fa-play"></i>
                                    </span>
                                </template>

                            </td>
                            <td v-text="proyecto.created_at"></td>
                        </tr>

                    </tbody>
                </table>
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
                                        <div class="col-6" v-for="img_alt in imagesProject" :key="img_alt.id">
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
                        </div>
                        <!--./tipoAcion==4: Upload Video-->
                        <div v-else-if="tipoAccion==4">
                            <div class="form-group">
                                <label>Video</label>
                                <input class="form-control"  type="file" name="video" @change="uploadVideo">
                            </div>
                        </div>
                        <!--./tipoAcion==5: View Video-->
                        <div v-else-if="tipoAccion==5">
                            <video :src="url_video" width="100%" controls></video>
                        </div>

                        <!--tipoAccion==1 o 2: Agregar o ACtualizar-->
                        <div v-else>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Titulo</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="title" class="form-control" placeholder="Ingrese nombre del proyecto">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Descripción</label>
                              <div class="col-md-9">
                                  <textarea class="form-control" v-model="description"  rows="3"></textarea>
                              </div>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="show_home" id="chk-show">
                            <label class="form-check-label" for="chk-show">Mostrar en Web</label>
                          </div>
                          
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="active" id="chk-active">
                            <label class="form-check-label" for="chk-active">Activo</label>
                          </div>

                        </div>
                        <!--./End v-else: tipoAccion==1 o 2: -->
                        

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
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="createProject()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="editProject()">Actualizar datos</button>
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
    	data(){
            return {
                project_id:0,
                active:1,
                show_home:1,
                title:'',
                description:'',
                content:'',
                image:'',
                url_video:'',
                slug:'',

                imagesProject:[],

                arrayProject:[],

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

        uploadOtherImage(event) {
            this.other_image = event.target.files[0];
            console.log(this.other_image)
        },

        loadProjects(page){

            let me=this;
          var url = `/dashboard/projects/get?page=${page}`;

          // Make a request for a user with a given ID
          axios.get(url).then(function (response) {

            var respuesta  = response.data;
              me.arrayProject = respuesta.projects.data;
              me.pagination = respuesta.pagination;

            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
            .finally(function () {
              // always executed
            });

        },
        cambiarPagina(page){
                let me = this;
                me.pagination.current_page = page;
                me.loadProjects(page);
            },
        createProject(){
                if(this.validarProject()){
                    return;
                }
                let me=this;

                axios.post('/admin/projects/store',{
                    'description':this.description,
                    'title':this.title,
                    'show_home':this.show_home,
                    'active':this.active,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadProjects(1);

                }).catch(function (error){
                    console.log(error);
                });
            },
        editProject(){
                if(this.validarProject()){
                    return;
                }
                let me=this;
                axios.put('/admin/projects/update',{
                    'project_id': this.project_id,
                    'description':this.description,
                    'title':this.title,
                    'show_home':this.show_home,
                    'active':this.active,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadProjects(1);

                }).catch(function (error){
                    console.log(error);
                });
            },
        desactivarProjecto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea desactivar este proyecto?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/projects/deactive',{
                        'id': id
                    }).then(function (response){
                        me.loadProjects(1);
                        swalWithBootstrapButtons.fire(
                            'Exito',
                          '¡Actualización correcta!',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
        activarProjecto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea activar este proyecto?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/projects/active',{
                        'id': id
                    }).then(function (response){
                        me.loadProjects(1);
                        swalWithBootstrapButtons.fire(
                            'Exito',
                          '¡Actualización correcta!',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
        ocultarProjectoHome(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea ocultar este proyecto del Inicio de Pagina Web?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/projects/hide-home',{
                        'id': id
                    }).then(function (response){
                        me.loadProjects(1);
                        swalWithBootstrapButtons.fire(
                          'Exito',
                          '¡Actualización correcta!',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
        mostrarProjectoHome(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea mostrar este proyecto del Inicio de Pagina Web?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/projects/show-home',{
                        'id': id
                    }).then(function (response){
                        me.loadProjects(1);
                        swalWithBootstrapButtons.fire(
                            'Exito',
                          '¡Actualización correcta!',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
        eliminarProjecto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Realmente desea eliminar este proyecto?',
                  html: '*Se eliminaran las imagenes y videos del proyecto de la base de datos<br> ',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/projects/delete',{
                        'id': id
                    }).then(function (response){
                        me.loadProjects(1);
                        swalWithBootstrapButtons.fire(
                          'Eliminado!',
                          'Eliminado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                        swalWithBootstrapButtons.fire(
                          'ERROR AL ELIMINAR',
                          'Existen clientes suscritos, elimine primero el proyecto de los proyectos de sus clientes.',
                          'error'
                        )
                    });

                  }
                })
            },
        validarProject(){
                this.error=0;
                this.errorMostrarMsj=[];
                if(!this.title) this.errorMostrarMsj.push('El campo titulo no puede estar vacio');
                if(!this.description) this.errorMostrarMsj.push('El campo descripción no puede estar vacio');
                if(this.errorMostrarMsj.length) this.error=1;
                return this.error;
            },
        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.project_id=0;
                this.description='';
                this.title='';
            },
        actualizarMainImage(){
                let me=this;
                const formData = new FormData();
                formData.append('project_id', this.project_id);

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

                axios.post('/admin/projects/update-main-image',formData)
                .then(function (response){
                    console.log(response);
                    Swal.close();
                    me.cerrarModal();
                    me.loadProjects(me.pagination.current_page);
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
                formData.append('project_id', this.project_id);

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

                axios.post('/admin/projects/upload-other-image',formData)
                .then(function (response){
                    console.log(response);
                    Swal.close();
                    me.cerrarModal();
                    me.loadProjects(me.pagination.current_page);
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
        uploadVideo(event) {
            this.video = event.target.files[0];
            console.log(this.video)
            // Restablecer el valor del campo de archivo
            //event.target.value = '';
        },
        createVideo(){
            let me=this;
            const formData = new FormData();
            formData.append('project_id', this.project_id);

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

            axios.post('/admin/projects/store-video',formData,{
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
                me.loadProjects(me.pagination.current_page);
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
                    axios.put('/admin/projects/delete-video',{
                        'id': id
                    }).then(function (response){
                        me.loadProjects(me.pagination.current_page);
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
        getUrlVideo(project_id){
          var url = `/admin/projects/video/get-url/${project_id}`;
          // Make a request for a user with a given ID
          let me=this;
          axios.get(url).then(function (response) {
              console.log('URL de GetURLVideo: ');
              console.log(response.data.url);
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
        eliminarOtherImage(id){
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
                    axios.put('/admin/projects/delete-other-image',{
                        'id': id
                    }).then(function (response){
                        me.cerrarModal();
                        me.loadProjects(me.pagination.current_page);
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
        abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "proyecto":{
                        switch(accion){

                            case 'registrar':{
                                this.modal=1;
                                this.tituloModal='Agregar';
                                this.tipoAccion =1;

                                this.description='';
                                this.title='';
                                this.show_home=1;
                                this.active=1;
                                break;
                            }
                            case 'actualizar':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';

                                this.project_id  = data['id'];
                                this.description = data['description'];
                                this.active      = data['active'];
                                this.show_home   = data['show_home'];
                                this.title       = data['title'];
                                break;
                            }
                            case 'images':{
                                this.modal=1;
                                this.tipoAccion=3;
                                this.tituloModal='Editar Imagenes';
                                this.project_id  = data['id'];
                                this.image=data['image'];
                                this.imagesProject=[];
                                this.imagesProject = data['images'];
                                console.log('Img: '+this.image)
                                break;
                            }
                            
                            case 'store-video':{
                                this.modal=1;
                                this.tipoAccion=4;
                                this.tituloModal='Subir Video';
                                this.project_id  = data['id'];
                                this.url_video='';
                                this.video = null;
                                console.log('Video: '+this.video)
                                break;
                            }
                            case 'open-video':{
                                this.modal=1;
                                this.tipoAccion=5;
                                this.tituloModal='Ver Video';
                                this.project_id  = data['id'];
                                this.url_video='';
                                this.getUrlVideo(this.project_id);
                                break;
                            }

                        }
                    }
                }
            }

    	},
      mounted() {
          this.loadProjects(1)
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
