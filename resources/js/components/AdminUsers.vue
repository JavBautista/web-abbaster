<template>
  <div>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Usuarios
                <button type="button" @click="abrirModal('user','registrar')" class="btn btn-primary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text">Tipo</label>
                          </div>
                          <select class="custom-select" v-model="filtro_tipo">
                            <option v-for="role in arrayRoles" :value="role.id" v-text="role.description"></option>
                            <option value="0">Todos</option>
                          </select>
                        </div>
                    </div><!--./col-md-6-->
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text">Estatus</label>
                          </div>
                          <select class="form-control col-md-3" v-model="filtro_estatus">
                              <option value="active">Activos</option>
                              <option value="bajas">Bajas</option>
                              <option value="todos">Todos</option>
                          </select>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="name">Nombre</option>
                              <option value="email">E-Mail</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadUsers(1,buscar,criterio,filtro_tipo, filtro_estatus)">
                            <div class="input-group-append">
                                <button type="submit" @click="loadUsers(1,buscar,criterio,filtro_tipo, filtro_estatus)" class="btn btn-primary">Aplicar<i class="fa fa-arrow-alt-circle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estatus</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>E-Mail</th>
                            <th>Creación</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in arrayUsers" :key="user.id">

                            <td v-text="user.id"></td>
                            <td>
                                <span v-if="user.active" class="badge badge-success">Activo</span>
                                <span v-else class="badge badge-danger">Inactivo</span>
                            </td>
                            <td v-text="user.name_role"></td>
                            <td v-text="user.name"></td>
                            <td v-text="user.email"></td>
                            <td v-text="user.created_at"></td>
                            <td>
                                <button type="button" @click="abrirModal('user','actualizar-info', user)" class="btn btn-info btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button" @click="abrirModal('user','actualizar-password', user)" class="btn btn-info btn-sm">
                                  <i class="icon-key"></i>
                                </button> &nbsp;

                                <template v-if="user.active">
                                    <button type="button" class="btn btn-warning btn-sm" @click="desactivarUsuario(user.id)" title="Desactivar">
                                      <i class="fa fa-thumbs-down"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(user.id)" title="Activar">
                                      <i class="fa fa-thumbs-up"></i>
                                    </button>
                                </template>
                                &nbsp;
                                <button type="button" class="btn btn-danger btn-sm" @click="eliminarUsuario(user.id)" title="Eliminar">
                                      <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio,filtro_tipo,filtro_estatus)">Ant</a>
                        </li>

                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,filtro_tipo,filtro_estatus)" v-text="page"></a>
                        </li>

                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio,filtro_tipo,filtro_estatus)">Sig</a>
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
                            <div v-for="error in errorMostrarMsj" :key="error" v-text="error">
                            </div>
                        </div>
                      </div>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <template v-if="tipoAccion==1">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Tipo de Usuario</label>
                            <div class="col-md-9">
                                <select class="custom-select" v-model="rol">
                                    <option v-for="role in arrayRoles" :value="role.name" v-text="role.description"></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="name" class="form-control" placeholder="Nombre del usuario">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">E-Mail</label>
                            <div class="col-md-9">
                                <input type="email" v-model="email" class="form-control" placeholder="Ingrese e-mail">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">Password</label>
                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control" placeholder="******" v-model="password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label">Confirmar Password</label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control" placeholder="******" v-model="password_confirmation" required>
                            </div>
                        </div>
                      </template>
                      <template v-if="tipoAccion==2">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="name" class="form-control" placeholder="Nombre del usuario">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">E-Mail</label>
                            <div class="col-md-9">
                                <input type="email" v-model="email" class="form-control" placeholder="Ingrese e-mail">
                            </div>
                        </div>
                      </template>
                      <template v-if="tipoAccion==3">
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">Password</label>
                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control" placeholder="******" v-model="password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label">Confirmar Password</label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control" placeholder="******" v-model="password_confirmation" required>
                            </div>
                        </div>
                      </template>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUser()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUserInfo()">Actualizar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="actualizarUserPassword()">Actualizar</button>
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
                name:'',
                email:'',
                password:'',
                password_confirmation:'',
                rol:'admin',

                arrayRoles:[],
                arrayUsers:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                error:0,
                errorMostrarMsj:[],
                user_id:0,
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
                filtro_tipo:1,
                filtro_estatus:'active',

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
        methods : {
            loadUsers(page,buscar,criterio, filtro_tipo, filtro_estatus){
                let me=this;
                var url = '/admin/users/get?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&filtro_tipo='+filtro_tipo+'&filtro_estatus='+filtro_estatus;;
                axios.get(url).then(function (response) {
                    var respuesta  = response.data;

                    me.arrayUsers = respuesta.users.data;
                    me.arrayRoles = respuesta.roles;
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
            cambiarPagina(page,buscar,criterio,filtro_tipo, filtro_estatus){
                let me = this;
                me.pagination.current_page = page;
                me.loadUsers(page,buscar,criterio,filtro_tipo, filtro_estatus);
            },
            registrarUser(){
                if(this.validarUser('store')){
                    return;
                }
                let me=this;
                axios.post('/admin/users/store',{
                    'name': this.name,
                    'email': this.email,
                    'password': this.password,
                    'password_confirmation': this.password_confirmation,
                    'rol': this.rol,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadUsers(1,me.buscar,me.criterio,me.filtro_tipo, me.filtro_estatus);
                }).catch(function (error){
                    me.error=1;
                    me.errorMostrarMsj=[];
                    me.errorMostrarMsj=error.response.data.errors;
                });
            },
            actualizarUserInfo(){
               if(this.validarUser('update_info')){
                    return;
                }
                let me=this;
                axios.put('/admin/users/update-info',{
                    'id': this.user_id,
                    'name': this.name,
                    'email': this.email
                }).then(function (response){
                    me.cerrarModal();
                    me.loadUsers(me.pagination.current_page,me.buscar,me.criterio,me.filtro_tipo, me.filtro_estatus);
                }).catch(function (error){
                    me.error=1;
                    me.errorMostrarMsj=[];
                    me.errorMostrarMsj=error.response.data.errors;
                });
            },
            actualizarUserPassword(){
                if(this.validarUser('update_password')){
                    return;
                }
                let me=this;
                axios.put('/admin/users/update-password',{
                    'id': this.user_id,
                    'password': this.password,
                    'password_confirmation': this.password_confirmation,
                }).then(function (response){
                    me.cerrarModal();
                    me.loadUsers(me.pagination.current_page,me.buscar,me.criterio,me.filtro_tipo, me.filtro_estatus);
                }).catch(function (error){
                    me.error=1;
                    me.errorMostrarMsj=[];
                    me.errorMostrarMsj=error.response.data.errors;
                });
            },
            validarUser(accion){
                this.error=0;
                this.errorMostrarMsj=[];
                if(accion=='store'){
                    if(!this.name) this.errorMostrarMsj.push('El nombre no puede estar vacio');
                    if(!this.email) this.errorMostrarMsj.push('El email no puede estar vacio');
                    if(!this.password) this.errorMostrarMsj.push('El password no puede estar vacio');
                    if(!this.password_confirmation) this.errorMostrarMsj.push('La confimación del password no puede estar vacio');
                }
                if(accion=='update_info'){
                    if(!this.name) this.errorMostrarMsj.push('El nombre no puede estar vacio');
                    if(!this.email) this.errorMostrarMsj.push('El email no puede estar vacio');
                }
                if(accion=='update_password'){
                    if(!this.password) this.errorMostrarMsj.push('El password no puede estar vacio');
                    if(!this.password_confirmation) this.errorMostrarMsj.push('La confimación del password no puede estar vacio');
                }
                if(this.errorMostrarMsj.length) this.error=1;
                return this.error;
            },
            activarUsuario(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                  })

                  swalWithBootstrapButtons.fire({
                    title: '¿Desea volver a activar esta usuario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.value) {

                      let me=this;
                      axios.put('/admin/users/activar',{
                          'id': id
                      }).then(function (response){
                          me.loadUsers(me.pagination.current_page,me.buscar,me.criterio,me.filtro_tipo, me.filtro_estatus);
                          swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El usuario ha sido activado con exito.',
                            'success'
                          )
                      }).catch(function (error){
                          console.log(error);
                      });

                    }
                  })
            },
            desactivarUsuario(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea desactivar este usuario?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/admin/users/desactivar',{
                        'id': id
                    }).then(function (response){
                        me.loadUsers(me.pagination.current_page,me.buscar,me.criterio,me.filtro_tipo, me.filtro_estatus);
                        swalWithBootstrapButtons.fire(
                          'Desactivado!',
                          'El usuario ha sido descativado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
            eliminarUsuario(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea eliminar este usuario?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    let me=this;
                    axios.put('/admin/users/eliminar',{
                        'id': id
                    }).then(function (response){
                        me.loadUsers(1,me.buscar,me.criterio,me.filtro_tipo, me.filtro_estatus);
                        swalWithBootstrapButtons.fire(
                          '¡Eliminado!',
                          'El usuario ha sido eliminado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
            cerrarModal(){
                this.user_id=0;
                this.name='';
                this.email='';
                this.password='';
                this.password_confirmation='';
                this.rol='admin';

                this.error=0;
                this.errorMostrarMsj=[];

                this.modal=0;
                this.tituloModal='';
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "user":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.name='';
                                this.email='';
                                this.password='';
                                this.password_confirmation='';
                                this.rol='admin';
                                this.tituloModal='Registrar';
                                this.tipoAccion =1;
                                break;
                            }
                            case 'actualizar-info':{
                                //console.log(data);
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar Información';
                                this.name=data['name'];
                                this.email=data['email'];
                                this.user_id=data['id'];
                                break;
                            }
                            case 'actualizar-password':{
                                //console.log(data);
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Actualizar Password';
                                this.user_id=data['id'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.loadUsers(1,'','name',1,'active');
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
