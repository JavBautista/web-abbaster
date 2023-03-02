<template>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
            <div class="form-inline">
              <div class="form-group mx-sm-3 mb-2">
                <label class="sr-only">Fecha Inicial</label>
                <date-picker v-model="fecha_ini" :config="options"></date-picker>
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <label class="sr-only">Fecha Fin</label>
                <date-picker v-model="fecha_fin" :config="options"></date-picker>
              </div>
              <button type="submit" class="btn btn-primary mb-2" @click="loadVisitas()"><i class="fa fa-search"></i> Buscar</button>
            </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Resultados del <span v-text="fecha_ini"></span> al <span v-text="fecha_fin"></span>. Registros: <span v-text="products_count"></span>
          <!-- btn new-->
      </div>
      <div class="car-body">
            <div class="card card-chart">
              <div class="card-content">
                <div class="ct-chart">
                  <canvas id="chart-categorias"></canvas>
                </div>
              </div>
            </div>
      </div>
    </div>
    <!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Resultados del <span v-text="fecha_ini"></span> al <span v-text="fecha_fin"></span>.
            <!-- btn new-->
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <select class="form-control col-md-3" v-model="criterio">
                          <option value="nombre">Categoria</option>
                        </select>
                        <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadVisitas(1,buscar,criterio)">
                        <button type="submit" @click="loadVisitas(1,buscar,criterio)" class="btn btn-outline-primary"><i class="fa fa-search"></i> Buscar</button>

                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Categoria</th>
                    <th>Visitas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="product in arrayProducts" :key="product.id">
                    <td><img class="img-thumbnail" width="50px" :src="'/storage/'+product.image" alt="Img 404"></td>
                    <td v-text="product.name"></td>
                    <td v-text="product.visitas"></td>
                  </tr>
                </tbody>
                <!--<tfoot>
                  <tr>
                    <td>Totales</td>
                    <td><strong v-text="views_total"></strong></td>
                  </tr>
                </tfoot>
              -->
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item" v-if="pagination.current_page > 1">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                    </li>
                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Fin ejemplo de tabla Listado -->
    </div><!--.container-->
</template>

<script>
  import datePicker from 'vue-bootstrap-datetimepicker';
  import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    export default {
    	data(){
    		return {
          varChartCategorias:null,
          chartCategorias:null,
          arrayDataKeys:[],
          arrayDataVisitas:[],


          primera_busqueda:0,
          fecha_ini:new Date(),
          fecha_fin:new Date(),
          options: {
            format: 'YYYY-MM-DD',
            useCurrent: false,
          },
    			arrayProducts:[],
          products_count:0,
          pagination:{
              'total':0,
              'current_page':0,
              'per_page':0,
              'last_page':0,
              'from':0,
              'to':0
          },
          offset:3,
          criterio:'nombre',
          buscar:''
    		}
    	},
      components: {
        datePicker
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
    		loadVisitas(page,buscar,criterio){
          let me=this;
          var url='';
          if(me.primera_busqueda==0){
            me.fecha_ini = moment(me.fecha_ini).format('YYYY-MM-DD');
            me.fecha_fin = moment(me.fecha_fin).format('YYYY-MM-DD');
            me.primera_busqueda=1;
          }
          url = '/get/visitas-categorias/?fecha_ini='+me.fecha_ini+'&fecha_fin='+me.fecha_fin+'&page='+page+'&buscar='+buscar+'&criterio='+criterio;
          axios.get(url).then(function (response) {
            console.log(response)
            var res = response.data
            me.arrayProducts = res.products.data
            me.products_count = res.products_count
            me.pagination = res.pagination;
            console.log(me.arrayProducts)
            me.loadChart();

					})
					.catch(function (error) {
						// handle error
						console.log(error);
					})
					.finally(function () {
						// always executed
					});

    		},
        loadChart(){
          let me=this;
          me.arrayDataKeys=[]
          me.arrayDataVisitas=[]
          me.arrayProducts.map(function(x){
            me.arrayDataKeys.push(x.name);
            me.arrayDataVisitas.push(x.visitas);
          });
          me.varChartCategorias = document.getElementById('chart-categorias').getContext('2d');
          me.chartCategorias = new Chart(me.varChartCategorias, {
              type: 'bar',
              data: {
                  labels: me.arrayDataKeys,
                  datasets: [{
                      label: 'Visitas',
                      data: me.arrayDataVisitas,
                      backgroundColor: 'rgba(255, 99, 132, 0.2)',
                      borderColor: 'rgba(255, 99, 132, 0.2)',
                      borderWidth: 1
                  }]
          },
          options: {
                  scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero: true
                          }
                      }]
                  }
              }
          });
        },
        cambiarPagina(page,buscar,criterio){
            let me = this;
            me.pagination.current_page = page;
            me.loadVisitas(page,buscar,criterio);
        }
    	},
      mounted() {
          this.loadVisitas(1,'','nombre')
      }
    }
</script>
