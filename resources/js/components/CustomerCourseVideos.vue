<template>
  <div class="container">

    <div class="container-fluid mt-4">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Curso

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>

                            <th>Video</th>
                            <th>Nombre</th>
                            <th>Descripción</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="video_curso in arrayVideos" :key="video_curso.id">

                            <td align="center" v-if="video_curso.video">

                                <button class="btn  btn-info" @click="abrirModal('video','open_video', video_curso)" ><i class="fa fa-play"></i></button>
                            </td>
                            <td v-text="video_curso.name"></td>
                            <td v-text="video_curso.description"></td>

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
                    <div v-if="tipoAccion==1">
                            <video :src="urlVideo" :controlsList="'nodownload'" width="100%" controls></video>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>

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
        props:['course_id'],
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
                            case 'open_video':{
                                this.modal=1;
                                this.tipoAccion =1;
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
