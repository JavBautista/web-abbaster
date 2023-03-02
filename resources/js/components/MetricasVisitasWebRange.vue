<template>
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> Resultados del <span v-text="fecha_ini"></span> al <span v-text="fecha_fin"></span>. Registros: <span v-text="views_count"></span>
      </div>
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
              <button type="submit" class="btn btn-primary mb-2" @click="loadVisitas(buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
            </div>

            <h4> <strong>Vistas Totales <span v-text="views_total"></span> </strong> </h4>
            <div class="card card-chart">
              <div class="card-content">
                <div class="ct-chart">
                  <canvas id="chart-visitas"></canvas>
                </div>
              </div>
            </div>
            <h4> Datos: Registros <span v-text="views_count"></span>, vistas totales <span v-text="views_total"></span> </h4>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Visitas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="view in arrayViews" :key="view.day">
                    <td v-text="view.day"></td>
                    <td v-text="view.visitas"></td>
                  </tr>
                </tbody>
            </table>
      </div>
    </div>
  </div><!--./container-->
</template>

<script>
  import datePicker from 'vue-bootstrap-datetimepicker';
  import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    export default {
    	data(){
    		return {
          varChartVisitas:null,
          chartVisitas:null,
          arrayDataKeys:[],
          arrayDataVisitas:[],

          primera_busqueda:0,
          fecha_ini:new Date(),
          fecha_fin:new Date(),
          options: {
            format: 'YYYY-MM-DD',
            useCurrent: false,
          },
    			arrayViews:[],
          views_count:0,
          views_total:0,

          criterio:'nombre',
          buscar:''
    		}
    	},
      components: {
        datePicker
      },

    	methods:{
    		loadVisitas(buscar,criterio){
          let me=this;
          var url='';
          if(me.primera_busqueda==0){
            me.fecha_ini = moment(me.fecha_ini).format('YYYY-MM-DD');
            me.fecha_fin = moment(me.fecha_fin).format('YYYY-MM-DD');
            me.primera_busqueda=1;
          }
          url = '/get/visitas-web-range/?fecha_ini='+me.fecha_ini+'&fecha_fin='+me.fecha_fin+'&buscar='+buscar+'&criterio='+criterio;
          axios.get(url).then(function (response) {
            console.log(response)
            var res = response.data
            me.arrayViews = res.views
            me.views_count = res.views_count
            me.views_total = res.views_total
            console.log(me.arrayViews)
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
            me.arrayDataKeys.push(x.day);
            me.arrayDataVisitas.push(x.visitas);
          });
          me.varChartVisitas = document.getElementById('chart-visitas').getContext('2d');
          me.chartVisitas = new Chart(me.varChartVisitas, {
              type: 'line',
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
    	},
      mounted() {
          this.loadVisitas('','nombre')
      }
    }
</script>
