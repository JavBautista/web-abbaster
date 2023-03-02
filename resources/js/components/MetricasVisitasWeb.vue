<template>
  <div class="container-fluid">
    <!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Registros: <span v-text="views_count"></span>
            <!-- btn new-->
        </div>
        <div class="card-body">
            <div class="form-inline">
              <div class="form-group mx-sm-3 mb-2">
                <label class="sr-only">Fecha</label>
                <date-picker v-model="fecha" :config="options"></date-picker>
              </div>
              <button type="submit" class="btn btn-primary mb-2" @click="loadVisitas()"><i class="fa fa-search"></i> Buscar</button>
            </div>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>IP</th>
                    <th>Visita</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="view in arrayViews" :key="view.id">

                    <td v-text="view.ip"></td>
                    <td v-text="view.created_at"></td>
                  </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Fin ejemplo de tabla Listado -->
    </div>
</template>

<script>
  import datePicker from 'vue-bootstrap-datetimepicker';
  import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    export default {
    	data(){
    		return {
          primera_busqueda:0,
          fecha:new Date(),
          options: {
            format: 'YYYY-MM-DD',
            useCurrent: false,
          },
    			arrayViews:[],
          views_count:0
    		}
    	},
      components: {
        datePicker
      },
    	methods:{
    		loadVisitas(){
    			let me=this;
          var url = '/get/visitas-web';
          if(me.primera_busqueda==0){
            me.fecha = moment(me.fecha).format('YYYY-MM-DD');
            me.primera_busqueda=1;
          }
          url = '/get/visitas-web/?fecha='+me.fecha;
          console.log(url)
          axios.get(url).then(function (response) {
						console.log(response)
            me.arrayViews = response.data
            me.views_count = me.arrayViews.length
					})
					.catch(function (error) {
						// handle error
						console.log(error);
					})
					.finally(function () {
						// always executed
					});

    		},
        buscarFecha(){
          console.log('Click Btn Fecha ')
        }
    	},
      mounted() {
          console.log('Component Visitas Web.')
          this.loadVisitas()
      }
    }
</script>
