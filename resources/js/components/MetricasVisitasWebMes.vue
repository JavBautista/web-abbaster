<template>
  <div class="container-fluid">

    <!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Resultados por meses. Registros: <span v-text="views_count"></span>
            <!-- btn new-->
        </div>
        <div class="card-body">
            <h4> <strong>Vistas Totales <span v-text="views_total"></span> </strong> </h4>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Visitas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="view in arrayViews" :key="view.months">
                    <td v-text="view.months"></td>
                    <td v-text="view.visitas"></td>
                  </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Fin ejemplo de tabla Listado -->

    <div class="card">
      <div class="car-body">
        <div class="row">
          <div class="col">
            <div class="card card-chart">
              <div class="card-header">
                <h4>Visitas</h4>
              </div>
              <div class="card-content">
                <div class="ct-chart">
                  <canvas id="chart-visitas"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!--./container-->
</template>

<script>

    export default {
    	data(){
    		return {
          varChartVisitas:null,
          chartVisitas:null,
          arrayDataKeys:[],
          arrayDataVisitas:[],

          arrayMeses:[
            {'enero':0},
            {'febrero':0},
            {'marzo':0},
            {'abril':0},
            {'mayo':0},
            {'junio':0},
            {'julio':0},
            {'agosto':0},
            {'septiembre':0},
            {'octubre':0},
            {'noviembre':0},
            {'diciembre':0},
          ],
    			arrayViews:[],
          views_count:0,
          views_total:0,
    		}
    	},
    	methods:{
    		loadVisitas(){

          let me=this;
          var url='';
          url = '/get/visitas-web-mes';
          axios.get(url).then(function (response) {
            //console.log(response)
            var res = response.data
            me.arrayViews = res.views
            me.views_count = res.views_count
            me.views_total = res.views_total

            for(var ind in me.arrayViews){
              console.log(me.arrayViews[ind].months);
              switch(me.arrayViews[ind].months){
                case "January":{
                  me.arrayMeses[0].enero = me.arrayViews[ind].visitas;
                  break;
                }
                case "February":{
                  me.arrayMeses[0].febrero = me.arrayViews[ind].visitas;
                  break;
                }
                case "March":{
                  me.arrayMeses[0].marzo = me.arrayViews[ind].visitas;
                  break;
                }
                case "April":{
                  me.arrayMeses[0].abril = me.arrayViews[ind].visitas;
                  break;
                }
                case "May":{
                  me.arrayMeses[0].mayo = me.arrayViews[ind].visitas;
                  break;
                }
                case "June":{
                  me.arrayMeses[0].junio = me.arrayViews[ind].visitas;
                  break;
                }
                case "July":{
                  me.arrayMeses[0].julio = me.arrayViews[ind].visitas;
                  break;
                }
                case "August":{
                  me.arrayMeses[0].agosto = me.arrayViews[ind].visitas;
                  break;
                }
                case "September":{
                  me.arrayMeses[0].septiembre = me.arrayViews[ind].visitas;
                  break;
                }
                case "October":{
                  me.arrayMeses[0].octubre = me.arrayViews[ind].visitas;
                  break;
                }
                case "November":{
                  me.arrayMeses[0].noviembre = me.arrayViews[ind].visitas;
                  break;
                }
                case "December":{
                  me.arrayMeses[0].diciembre = me.arrayViews[ind].visitas;
                  break;
                }
              }//switch
            }
            console.log(me.arrayMeses)
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
          me.arrayViews.map(function(x){
            me.arrayDataKeys.push(x.months);
            me.arrayDataVisitas.push(x.visitas);
          });
          me.varChartVisitas = document.getElementById('chart-visitas').getContext('2d');
          me.chartVisitas = new Chart(me.varChartVisitas, {
              type: 'bar',
              data: {
                  labels: me.arrayDataKeys,
                  datasets: [{
                      label: 'Visitas',
                      data: me.arrayDataVisitas,
                      backgroundColor: 'rgba(54, 162, 235, 0.2)',
                      borderColor: 'rgba(54, 162, 235, 0.2)',
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
            me.loadVisitas();
        }
    	},
      mounted() {
          this.loadVisitas()
      }
    }
</script>
