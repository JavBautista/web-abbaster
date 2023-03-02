<template>
  <div class="card">
    <div class="card-body">
      <div class="row">

        <div class="col-4">

          <span v-if="image">
            <img :src="'/storage/'+image" :alt="name" width="100px">
          </span>
          <span v-else><p>SIn Imagen</p></span>
        </div>

        <div class="col-4">
          <h4 v-text="name"></h4>
          <template v-if="activo">
            <span class="badge badge-success">Estatus Activo</span>&nbsp;

          </template>
          <template v-else>
            <span class="badge badge-danger">Estatus inactivo</span>&nbsp;
          </template>
          <em><p v-text="created_at"></p></em>
        </div>

        <div class="col-4">
          <template v-if="activo">
            <button type="button" class="btn btn-block btn-warning btn-sm" @click="desactivar()">
              Desactivar&nbsp;<i class="fa fa-trash"></i>
            </button>
          </template>
          <template v-else>
            <button type="button" class="btn btn-block btn-outline-primary btn-sm" @click="activar()">
              Activar&nbsp;<i class="fa fa-check"></i>
            </button>
          </template>

          <hr>
          <a :href="'/admin/cedis/warehouse/image/'+warehouse_id" class="mt-2 btn btn-block btn-primary">Imagen</a>
          <br>
          <a href="#" class="mt-2 btn btn-block btn-info">Editar</a>

        </div>

      </div><!--./row-->
    </div><!--./card-body-->
  </div><!--./card-->
</template>

<script>
    export default {
    	props:['warehouse_id'],
    	data(){
    		return {
    			activo:1,
    			name:'',
          image:'',
          created_at:'',
    		}
    	},
    	methods:{
    		getWareHouse(){
    			let me=this;
					axios.get('/warehouse/get/'+me.warehouse_id).then(function (response) {
						console.log(response.data)
						me.activo = response.data.active
						me.name = response.data.name
            me.image = response.data.image
            me.created_at = response.data.created_at

					})
					.catch(function (error) {
						// handle error
						console.log(error);
					})
					.finally(function () {
						// always executed
					});

    		},
    		activar(){
    			const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea volver a activar este almacen?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/warehouse/activar',{
                        'id': me.warehouse_id
                    }).then(function (response){
                        me.getWareHouse();
                        swalWithBootstrapButtons.fire(
                          'Desactivado!',
                          'El almacen ha sido activado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                  /*else if (
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
    		desactivar(){
    			const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea descativar este almacen?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/warehouse/desactivar',{
                        'id': me.warehouse_id
                    }).then(function (response){
                        me.getWareHouse();
                        swalWithBootstrapButtons.fire(
                          'Desactivado!',
                          'El almacen ha sido desactivado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                  /*else if (
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

    	},
      mounted() {
          console.log('Component Warehouse mounted.')
          this.getWareHouse()
      }
    }
</script>
