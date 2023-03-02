<template>
  <div class="container">

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Testimonios
                <button type="button" @click="abrirModal('testimonio','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <!--<div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="nombre">Nombre</option>
                              <option value="descripcion">Descripción</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="listarcategoria(1,buscar,criterio)">
                            <button type="submit" @click="listarcategoria(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>-->
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Vista similar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="testimonio in arrayTestimonios" :key="testimonio.id">
                            <td>
                                <button type="button" @click="abrirModal('testimonio','actualizar', testimonio)" class="btn btn-outline-info btn-block" title="Editar información">
                                  <i class="icon-pencil"></i> Editar Info
                                </button>
                                <a :href="'/dashboard/global-configurations/web-content/testimonios/edit-image/'+testimonio.id" class="btn btn-outline-info btn-block" title="Editar imagen">
                                  <i class="fa fa-image"></i> Editar Imagenes
                                </a>
                                <template v-if="testimonio.activo">
                                    <button type="button" class="btn btn-outline-warning btn-block" @click="desactivarTestimonio(testimonio.id)" title="Desactivar">
                                      <i class="fa fa-eye-slash"></i> Descativar
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-outline-info btn-block" @click="activarTestimonio(testimonio.id)" title="Activar">
                                      <i class="fa fa-eye"></i> Activar
                                    </button>
                                </template>
                                <button type="button" class="btn btn-outline-danger btn-block" @click="eliminarTestimonio(testimonio.id)" title="Eliminar">
                                      <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                            <td>
                              <div class="container">
                              <div class="card">
                                <template v-if="testimonio.activo">
                                    <div class="card-header bg-success">Activo</div>
                                </template>
                                <template v-else>
                                    <div class="card-header bg-danger">Inactivo</div>
                                </template>

                                <div class="row no-gutters">
                                  <div class="col-md-4">
                                      <template v-if="testimonio.image">
                                        <img class="card-img" :src="'/storage/'+testimonio.image" alt="imagen">
                                      </template>
                                      <template v-else>
                                        SIN IMAGEN
                                      </template>
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>{{testimonio.title}}</strong></h5>
                                        <p class="card-text">"{{testimonio.description}}"</p>
                                        <p class="card-text float-right">
                                          <small class="text-muted"><strong>{{testimonio.autor}} <em>{{testimonio.job}}</em></strong></small>
                                          <br v-if="testimonio.web">
                                            <small class="text-muted">{{testimonio.web}}</small>
                                          <br v-if="testimonio.contact">
                                            <small class="text-muted">{{testimonio.contact}}</small>
                                          <br v-if="testimonio.city">
                                            <small class="text-muted"> <strong>{{testimonio.city}}</strong></small>
                                          <small class="text-muted">&nbsp;{{testimonio.created_at}}</small>
                                        </p>

                                    </div>
                                  </div>
                                </div>
                              </div>
                              </div>

                            </td>
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
                              <label class="col-md-3 form-control-label">Título</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="title" class="form-control" placeholder="Ingrese título del testimonio">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Descripción</label>
                              <div class="col-md-9">
                                  <textarea class="form-control" v-model="description"  rows="3"></textarea>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Autor</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="autor" class="form-control" placeholder="Ingrese autor">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Puesto</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="job" class="form-control" placeholder="Ingrese puesto del autor">
                              </div>
                          </div>

                           <div class="form-group row">
                              <label class="col-md-3 form-control-label">Contacto</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="contact" class="form-control" placeholder="Ingrese contacto">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Web</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="web" class="form-control" placeholder="Ingrese página web del autor">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Ciudad</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="city" class="form-control" placeholder="Ingrese ciudad y/o país del autor">
                              </div>
                          </div>



                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="text-input">Activo</label>
                              <div class="col-md-9">
                                  <select class="form-control" v-model="activo">
                                      <option value="0">Inactivo</option>
                                      <option value="1">Activo</option>
                                  </select>

                              </div>
                          </div>



                        <!--SECTION SHOW ERROR-->
                        <div v-show="error" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsj" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                        <!--./SECTION SHOW ERROR-->


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTestimonio()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTestimonio()">Actualizar datos</button>

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
          testimonio_id:0,
          description:'',
          autor:'',
          job:'',
          image:'',
          activo:1,
          title:'',
          contact:'',
          web:'',
          city:'',

          arrayTestimonios:[],

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

        loadTestimonios(page){
          let me=this;
          var url = '/admin/testimonios/get?page='+page;
          // Make a request for a user with a given ID
          axios.get(url).then(function (response) {
              var respuesta  = response.data;
              me.arrayTestimonios = respuesta.testimonios.data;
              me.pagination = respuesta.pagination;
              console.log(me.arrayTestimonios);
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
                me.loadTestimonios(page);
            },
        registrarTestimonio(){

                if(this.validarTestimonio()){
                    return;
                }
                let me=this;

                axios.post('/admin/testimonios/add',{
                    'description':this.description,
                    'autor':this.autor,
                    'job':this.job,
                    'activo':this.activo,
                    'title':this.title,
                    'web':this.web,
                    'contact':this.contact,
                    'city':this.city,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadTestimonios(1);

                }).catch(function (error){
                    console.log(error);
                });
            },
        actualizarTestimonio(){
               if(this.validarTestimonio()){
                    return;
                }
                let me=this;
                axios.put('/admin/testimonios/edit',{
                    'id': this.testimonio_id,
                    'description':this.description,
                    'autor':this.autor,
                    'job':this.job,
                    'activo':this.activo,
                    'title':this.title,
                    'web':this.web,
                    'contact':this.contact,
                    'city':this.city
                }).then(function (response){
                    me.cerrarModal();
                    me.loadTestimonios(1);

                }).catch(function (error){
                    console.log(error);
                });
            },
        desactivarTestimonio(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea desactivar este testimonio?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/testimonios/desactivar',{
                        'id': id
                    }).then(function (response){
                        me.loadTestimonios(1);
                        swalWithBootstrapButtons.fire(
                          'Desactivado!',
                          'El testimonio ha sido desactivado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    )
                  }
                })
            },
        activarTestimonio(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea activar este testimonio?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/testimonios/activar',{
                        'id': id
                    }).then(function (response){
                        me.loadTestimonios(1);
                        swalWithBootstrapButtons.fire(
                          'Activado!',
                          'El testimonio ha sido activado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    )
                  }
                })
            },
        eliminarTestimonio(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Realmente desea eliminar este testimonio?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/testimonios/eliminar',{
                        'id': id
                    }).then(function (response){
                        me.loadTestimonios(1);
                        swalWithBootstrapButtons.fire(
                          'Eliminado!',
                          'El testimonio ha sido eliminado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    )
                  }
                })
            },
        validarTestimonio(){
                this.error=0;
                this.errorMostrarMsj=[];

                if(!this.description) this.errorMostrarMsj.push('La descripción no puede estar vacio');
                if(!this.autor) this.errorMostrarMsj.push('El autor no puede estar vacio');
                if(!this.title) this.errorMostrarMsj.push('El titulo del testimonio no puede estar vacio');


                if(this.errorMostrarMsj.length) this.error=1;

                return this.error;
            },
        cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.testimonio_id=0;
                this.description='';
                this.autor='';
                this.job='';
                this.image='';
                this.title='';
                this.web='';
                this.contact='';
                this.city='';
                this.activo=1;
            },
        abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "testimonio":{
                        switch(accion){

                            case 'registrar':{
                                this.modal=1;
                                this.tituloModal='Agregar';
                                this.tipoAccion =1;

                                this.description='';
                                this.autor='';
                                this.job='';
                                this.title='';
                                this.web='';
                                this.contact='';
                                this.city='';
                                this.activo=1;
                                break;
                            }
                            case 'actualizar':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';

                                this.testimonio_id=data['id'];
                                this.description=data['description'];
                                this.autor=data['autor'];
                                this.job=data['job'];
                                this.title=data['title'];
                                this.web=data['web'];
                                this.contact=data['contact'];
                                this.city=data['city'];
                                this.activo=data['activo'];
                                break;
                            }

                        }
                    }
                }
            }

    	},
      mounted() {
          this.loadTestimonios(1)
          console.log('AdminTestomonios Mounted')
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
