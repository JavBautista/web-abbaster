<template>
  <div class="container">

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Cursos
                <button type="button" @click="abrirModal('video','registrar')" class="btn btn-primary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>No</th>
                            <th>Mover</th>
                            <th>Estatus</th>
                            <th>Video</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="video_curso, index in arrayVideos" :key="video_curso.id">
                            <td>

                                <button type="button" @click="abrirModal('video','actualizar', video_curso)" class="btn btn-info btn-block" title="Editar información">
                                  <i class="icon-pencil"></i> Editar Info
                                </button>
                                <template v-if="video_curso.active">
                                    <button type="button" class="btn btn-warning btn-block" @click="desactivarVideo(video_curso.id)" title="Desactivar">
                                      <i class="fa fa-eye-slash"></i> Descativar
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-secondary btn-block" @click="activarVideo(video_curso.id)" title="Activar">
                                      <i class="fa fa-eye"></i> Activar
                                    </button>
                                </template>
                                <button type="button" class="btn btn-danger btn-block" @click="eliminarVideo(video_curso.id)" title="Eliminar">
                                      <i class="fa fa-trash"></i> Eliminar
                                </button>


                            </td>
                            <td>{{ video_curso.order }}</td>
                            <td>
                                <button class="btn btn-sm btn-secondary btn-block"  @click="moveUp(index)"><i class="fa fa-caret-up"></i></button>
                                <button class="btn btn-sm btn-secondary btn-block"  @click="moveDown(index)"><i class="fa fa-caret-down"></i></button>
                            </td>
                            <td align="center">
                                <template v-if="video_curso.active">
                                    <div class="badge bg-success">Activo</div>
                                </template>
                                <template v-else>
                                    <div class="badge bg-danger">Inactivo</div>
                                </template>
                            </td>
                            <td align="center" v-if="video_curso.video">

                                <button class="btn  btn-info" @click="abrirModal('video','open_video', video_curso)" ><i class="fa fa-play"></i></button>
                            </td>
                            <td v-text="video_curso.name"></td>
                            <td v-text="video_curso.description"></td>
                            <td v-text="video_curso.created_at"></td>
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
                    <div v-if="tipoAccion==3">
                            <video :src="urlVideo" width="100%" controls></video>
                    </div>
                    <div v-else>


                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                        <!--begin tipoAccion==1 o 2: Agregar o ACtualizar-->
                        <div v-if="tipoAccion==1 || tipoAccion==2">
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Nombre</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="name" class="form-control" placeholder="Ingrese nombre del curso">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Descripción</label>
                              <div class="col-md-9">
                                  <textarea class="form-control" v-model="description"  rows="3"></textarea>
                              </div>
                          </div>

                          <div v-if="tipoAccion==1">
                              <div class="form-group">
                                <label>Video</label>
                                <input class="form-control"  type="file" name="video" @change="uploadVideo">
                              </div>
                          </div>
                        </div>
                        <!--end tipoAccion==1 o 2: Agregar o ACtualizar-->

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


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="createVideo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="editVideo()">Actualizar datos</button>

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
        props:['shop_id','course_id'],
        data(){
            return {
                video_id:0,
                name:'',
                description:'',
                active:0,
                video:null,
                order:0,

                urlVideo:'',

                arrayVideos:[],

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
        moveUp(index) {
          if (index === 0) return;
          const videos = [...this.arrayVideos];
          [videos[index], videos[index - 1]] = [videos[index - 1], videos[index]];
          this.arrayVideos = videos;
          this.updateOrder();
        },
        moveDown(index) {
          if (index === this.arrayVideos.length - 1) return;
          const videos = [...this.arrayVideos];
          [videos[index], videos[index + 1]] = [videos[index + 1], videos[index]];
          this.arrayVideos = videos;
          this.updateOrder();
        },
        updateOrder() {
          axios.put('/admin/course/video/update-order', {
            videos: this.arrayVideos
          })
          .then(response => {
            console.log(response.data);
          })
          .catch(error => {
            console.error(error);
          });
        },
        loadVideos(page){
          let me=this;
          var url = `/admin/shop/course/videos-get/${me.course_id}?page=${page}`;
          // Make a request for a user with a given ID
          axios.get(url).then(function (response) {
              var respuesta  = response.data;
              me.arrayVideos = respuesta.videos.data;
              me.pagination = respuesta.pagination;
              console.log(me.arrayVideos);
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
                me.loadVideos(page);
            },

        uploadVideo(event) {
            this.video = event.target.files[0];
            console.log(this.video)
        },
        createVideo(){
                if(this.validarDatosVideo()){
                    return;
                }
                let me=this;
                const formData = new FormData();
                formData.append('course_id', this.course_id);
                formData.append('name', this.name);
                formData.append('description', this.description);

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

                axios.post('/admin/course/video/store',formData)
                .then(function (response){
                    Swal.close();
                    me.cerrarModal();
                    me.loadVideos(1);
                    Swal.fire({
                        title: 'Exitoso',
                        text: 'El video ha sido guardado exitosamente',
                        icon: 'success',
                    });
                }).catch(function (error){
                    console.log(error);
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar el video',
                        icon: 'error',
                      });
                });
            },
        editVideo(){
               if(this.validarDatosVideo()){
                    return;
                }
                let me=this;
                axios.put('/admin/course/video/update-info',{
                    'video_id': this.video_id,
                    'description':this.description,
                    'name':this.name,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadVideos(1);
                }).catch(function (error){
                    console.log(error);
                });
            },
        desactivarVideo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea desactivar este video?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/course/video/deactive',{
                        'id': id
                    }).then(function (response){
                        me.loadVideos(1);
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
        activarVideo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea activar este video?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/course/video/active',{
                        'id': id
                    }).then(function (response){
                        me.loadVideos(1);
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
                    axios.put('/admin/course/video/delete',{
                        'id': id
                    }).then(function (response){
                        me.loadVideos(1);
                        swalWithBootstrapButtons.fire(
                          'Eliminado!',
                          'Eliminado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                        swalWithBootstrapButtons.fire(
                          'ERROR AL ELIMINAR',
                          'Existen clientes suscritos, elimine primero el curso de los cursos de sus clientes.',
                          'error'
                        )
                    });

                  }
                })
            },
        validarDatosVideo(){
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
                this.video_id=0;
                this.description='';
                this.name='';
                this.order=0;
                this.urlVideo='';
            },
        getUrlVideo(video_id){
          var url = `/admin/course/video/get-url/${video_id}`;
          // Make a request for a user with a given ID
          let me=this;
          axios.get(url).then(function (response) {
              //console.log(response.data.url);
              me.urlVideo = response.data.url;
              console.log(me.urlVideo);
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
                console.log('Abrir modal')
                switch(modelo){
                    case "video":{
                        switch(accion){

                            case 'registrar':{
                                this.modal=1;
                                this.tituloModal='Agregar';
                                this.tipoAccion =1;

                                this.description='';
                                this.name='';
                                this.video=null;
                                break;
                            }
                            case 'actualizar':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';

                                this.video_id=data['id'];
                                this.description=data['description'];
                                this.name=data['name'];
                                break;
                            }
                            case 'open_video':{
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Ver Video';

                                this.video_id=data['id'];

                                this.description=data['description'];
                                this.name=data['name'];
                                this.getUrlVideo(this.video_id);

                                break;
                            }

                        }
                    }
                }
            }

        },
      mounted() {
          this.loadVideos(1)
          console.log('Component Amdin/Course/Videos Mounted')
          console.log(this.shop_id)
          console.log(this.course_id)
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
