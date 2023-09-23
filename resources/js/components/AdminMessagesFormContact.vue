<template>
  <div class="container">

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Mensajes de Formulario de Contacto
            </div>
            <div class="card-body">
                <div class="container"> <!-- Opcional: agrega una clase container para centrar el contenido si lo deseas -->
                  <div class="card mb-4" v-for="msg in arrayMessages" :key="msg.id">
                    <div class="card-body">
                      <p class="card-text">
                        <template v-if="msg.shop_id == 0">
                          <strong>Tienda:&nbsp;</strong><span class="badge bg-info">Abbaster</span>
                        </template>
                        <template v-else>
                          <strong>Tienda:&nbsp;</strong><span class="badge bg-info">{{msg.shop.name}}</span>
                        </template>
                      </p>

                      <p class="card-text">
                        <template v-if="msg.read">
                          <strong>Estatus:&nbsp;</strong><span class="badge bg-success">Leído</span>
                        </template>
                        <template v-else>
                          <strong>Estatus:&nbsp;</strong><span class="badge bg-danger">Sin Leer</span>
                        </template>
                      </p>
                      <h5 class="card-title">{{ msg.name }}</h5>
                      <p class="card-text preview-message">{{ truncateMessage(msg.message, 100) }}</p>
                      <p class="card-text text-muted float-right">{{ msg.created_at }}</p>

                      <button class="btn btn-danger" @click="eliminaMessage(msg.id)">
                        <i class="fa fa-trash"></i>&nbsp;Eliminar
                      </button>

                      <button class="btn btn-primary" @click="abrirModal('message','ver', msg)">
                        <i class="fa fa-envelope-o"></i>&nbsp;Ver
                      </button>
                    </div>
                  </div>
                </div>

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
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Nombre</label>
                              <div class="col-md-9">
                                    <p v-text="name"></p>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Mensaje</label>
                              <div class="col-md-9">
                                <pre><p>{{message}}</p></pre>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Email</label>
                              <div class="col-md-9">
                                <pre><p>{{email}}</p></pre>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label">Teléfono</label>
                              <div class="col-md-9">
                                <pre><p>{{phone}}</p></pre>
                              </div>
                          </div>
                          <p class="float-right text-muted"><em><span v-text="created_at"></span></em></p>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button v-if="read==0" type="button" class="btn btn-primary" @click="marcarLeido(message_id)">Marcar Leido</button>
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
                message_id:0,
                read:1,
                name:'',
                message:'',
                email:'',
                phone:'',
                created_at:'',

                arrayMessages:[],

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
        loadMessages(page){

          let me=this;
          var url = `/messages-form-contact/get?page=${page}`;

          // Make a request for a user with a given ID
          axios.get(url).then(function (response) {

            var respuesta  = response.data;
              me.arrayMessages = respuesta.messages.data;
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
                me.loadMessages(page);
            },
        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
        },

        marcarLeido(id){
            console.log('marcar leido');
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
              title: '¿Desea marcar como leido este mensaje?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Aceptar',
              cancelButtonText: 'Cancelar',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {

                let me=this;
                axios.put('/messages-form-contact/update-read',{
                    'id': id
                }).then(function (response){
                    me.cerrarModal();
                    me.loadMessages(me.pagination.current_page);
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
        truncateMessage(message, maxLength) {
            if (!message) {
              return ''; // Si el mensaje es nulo, retornamos una cadena vacía
            }
            if (message.length > maxLength) {
              return message.substring(0, maxLength) + '...'; // Truncamos el mensaje
            } else {
              return message;
            }

        },
        eliminaMessage(id){
            console.log('eliminar msg');
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
              title: '¿Desea eliminar este mensaje?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Aceptar',
              cancelButtonText: 'Cancelar',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {

                let me=this;
                axios.put('/messages-form-contact/delete',{
                    'id': id
                }).then(function (response){
                    me.cerrarModal();
                    me.loadMessages(me.pagination.current_page);
                    swalWithBootstrapButtons.fire(
                        'Exito',
                        '¡Eliminación correcta!',
                        'success'
                    )
                }).catch(function (error){
                    console.log(error);
                });

              }
            })
        },
        abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "message":{
                        switch(accion){
                            case 'ver':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Ver';
                                this.message_id  = data['id'];
                                this.name  = data['name'];
                                this.read  = data['read'];
                                this.email = data['email'];
                                this.phone     = data['phone'];
                                this.message   = data['message'];
                                this.created_at= data['created_at'];
                                break;
                            }
                        }
                    }
                }
            }

    	},
        mounted() {
          this.loadMessages(1)
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
