<template>
  <div class="container">

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Cursos
                <button type="button" @click="abrirModal('curso','registrar')" class="btn btn-primary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Estatus</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="curso in arrayCourses" :key="curso.id">
                            <td>
                                <a :href="'/dashboard/store/'+shop_id+'/course/'+curso.id" class="btn btn-block btn-primary"> <i class="fa fa-info-circle"></i>  Ver Curso</a>

                                <button type="button" @click="abrirModal('curso','actualizar', curso)" class="btn btn-info btn-block" title="Editar información">
                                  <i class="icon-pencil"></i> Editar Info
                                </button>
                                <template v-if="curso.active">
                                    <button type="button" class="btn btn-warning btn-block" @click="desactivarCurso(curso.id)" title="Desactivar">
                                      <i class="fa fa-eye-slash"></i> Descativar
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-secondary btn-block" @click="activarCurso(curso.id)" title="Activar">
                                      <i class="fa fa-eye"></i> Activar
                                    </button>
                                </template>
                                <button type="button" class="btn btn-danger btn-block" @click="eliminarCurso(curso.id)" title="Eliminar">
                                      <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                            <td align="center">
                                <template v-if="curso.active">
                                    <div class="badge bg-success">Activo</div>
                                </template>
                                <template v-else>
                                    <div class="badge bg-danger">Inactivo</div>
                                </template>
                            </td>
                            <td v-text="curso.name"></td>
                            <td v-text="curso.description"></td>
                            <td v-text="curso.created_at"></td>
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
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">


                        <!--tipoAccion==1 o 2: Agregar o ACtualizar-->
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
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="createCourse()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="editCourse()">Actualizar datos</button>

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
                course_id:0,
                name:'',
                description:'',
                active:'',

                arrayCourses:[],

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

        loadCourses(page){
          let me=this;
          var url = `/admin/shop/courses-get/${me.shop_id}?page=${page}`;
          // Make a request for a user with a given ID
          axios.get(url).then(function (response) {
              var respuesta  = response.data;
              me.arrayCourses = respuesta.courses.data;
              me.pagination = respuesta.pagination;
              console.log(me.arrayCourses);
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
                me.loadCourses(page);
            },
        createCourse(){
                if(this.validarCourse()){
                    return;
                }
                let me=this;

                axios.post('/admin/course/store',{
                    'description':this.description,
                    'name':this.name,
                    'shop_id':this.shop_id,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadCourses(1);

                }).catch(function (error){
                    console.log(error);
                });
            },
        editCourse(){
               if(this.validarCourse()){
                    return;
                }
                let me=this;
                axios.put('/admin/course/update',{
                    'course_id': this.course_id,
                    'description':this.description,
                    'name':this.name,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadCourses(1);

                }).catch(function (error){
                    console.log(error);
                });
            },
        desactivarCurso(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea desactivar este curso?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/course/deactive',{
                        'id': id
                    }).then(function (response){
                        me.loadCourses(1);
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
        activarCurso(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea activar este curso?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/course/active',{
                        'id': id
                    }).then(function (response){
                        me.loadCourses(1);
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
        eliminarCurso(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Realmente desea eliminar este curso?',
                  html: '*Se eliminaran los videos del curso de la base de datos<br> ' +
                        '*Solo podrá eliminar desde aqui si el curso no tiene clientes suscritos.',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/course/delete',{
                        'id': id
                    }).then(function (response){
                        me.loadCourses(1);
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
        validarCourse(){
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
                this.course_id=0;
                this.description='';
                this.name='';
            },
        abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "curso":{
                        switch(accion){

                            case 'registrar':{
                                this.modal=1;
                                this.tituloModal='Agregar';
                                this.tipoAccion =1;

                                this.description='';
                                this.name='';
                                break;
                            }
                            case 'actualizar':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';

                                this.course_id=data['id'];
                                this.description=data['description'];
                                this.name=data['name'];
                                break;
                            }

                        }
                    }
                }
            }

    	},
      mounted() {
          this.loadCourses(1)
          console.log(this.shop_id)
          console.log('Component Amdin/Courses Mounted')
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
