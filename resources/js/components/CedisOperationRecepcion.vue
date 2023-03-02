<template>
  <div class="container">
    <div v-if="show_msg" class="alert alert-warning text-center">
      <span v-text="msg_alert"></span>
    </div>
    <div v-if="mostrar_oc">
      <div class="float-right">
        <button type="button" class="btn btn-danger mb-2" @click="cerrarOC()"><i class="fa fa-window-close"></i> Cerrar OC</button>
        <button type="button" class="btn btn-success mb-2" @click="guardarOC()"><i class="fa fa-save"></i> Guardar OC</button>
      </div>
      <h2>Orden de compra: <span v-text="oc_id"></span></h2>
      <hr>
      <div class="form-inline">
        <label class="sr-only">Escanee Codigo</label>
        <input type="text" class="form-control mb-2 mr-sm-2" v-model="codigo" placeholder="Ingrese codigo" autofocus>
        <button type="button" class="btn btn-primary mb-2" @click="buscarCodigo()">Buscar</button>
      </div>

      <div class="container">
        <div v-if="alert_codigo"  class="alert alert-danger text-center">
          <span v-text="alert_codigo_msg"></span>
        </div>

        <div v-for="reg in array_scans" :key="reg.id">
          <div class="card" v-if="reg.scans">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <p v-text="reg.product"></p>
                </div>
                <div class="col-4">
                  <span v-if="reg.scans < reg.qty">
                    <p v-text="reg.scans"></p>
                  </span>
                  <span v-else-if="reg.scans == reg.qty">
                    <p class="badge badge-success" v-text="reg.scans"></p>
                  </span>
                  <span v-else>
                    <p class="badge badge-danger" v-text="reg.scans"></p>
                  </span>
                </div>
              </div><!--./row-->
            </div><!--./card-body-->
          </div><!--./card-->
        </div><!--./v-for-->

      </div><!--./container-->

    </div><!--./v-if-->
    <div v-else>
      <div class="form-inline">
        <label class="sr-only">Orden de Compra</label>
        <input type="number" class="form-control mb-2 mr-sm-2" v-model="oc_id"  placeholder="Ingrese número">
        <button type="button" class="btn btn-primary mb-2" @click="buscarOC()">Buscar</button>
      </div>

    </div>

  </div>
</template>

<script>
    export default {
      data(){
        return {
          alert_codigo:0,
          mostrar_oc:0,
          show_msg:0,
          msg_alert:'',
          oc_id:'',
          codigo:'',
          barcodes:[],
          purchase_order:{},
          array_scans:[],
        }
      },
      methods:{
        cargarInfo(){
        },
        clearMsgAlert(){
          this.show_msg=0;
          this.msg_alert='';
        },
        msgAlert(text){
          this.show_msg=1;
          this.msg_alert=text;
        },
        buscarOC(){
          console.log('buscarOC')
          let me=this;
          var url = '/cedis/operation/get-oc/'+me.oc_id;
          me.clearMsgAlert();
          axios.get(url).then(function (response) {
            //console.log(response);
            if(response.data){
              me.purchase_order= response.data.oc;
              me.barcodes=[];
              me.barcodes= response.data.barcodes;
              if(me.purchase_order.estatus=="recepcion"){
                me.mostrar_oc=1;
                //como existe la OC y el estatus es recepcion
                //recorremos cada elemento del detalle de arts
                let detail = me.purchase_order.purchase_order_detail;
                for (var i = 0; i < detail.length; i+=1){
                  //por cada art del detalle armamos un objeto temporal con los datos del articulo y el dato de
                  //codigo de barras que lo traemos por separado
                  //ademas agregamos este objeto un contador en O para el contabilizar el escaned/busqueda
                  var temp={
                      id:detail[i].id,
                      product:detail[i].product,
                      qty:detail[i].qty,
                      cost:detail[i].cost,
                      created_at:detail[i].created_at,
                      updated_at:detail[i].updated_at,
                      purchase_order_id:detail[i].purchase_order_id,
                      product_id:detail[i].product_id,
                      status:detail[i].status,
                      barcode: me.barcodes[detail[i].product_id],
                      scans:0
                    }
                  me.array_scans.push(temp);
                }
                console.log(me.array_scans);
              }else{
                me.msgAlert('La orden de compra: '+me.oc_id+' busacada no se encuentra en estatus de recepcion.')
              }
            }else{
              me.msgAlert('No existe el numero de Orden de Compra Proporcionado')
              me.mostrar_oc=0;
            }
          })
          .catch(function (error) {
          // handle error
          console.log(error);
          })
          .finally(function () {
          // always executed
          });
        },
        cerrarOC(){
          this.clearMsgAlert();
          this.oc_id='';
          this.mostrar_oc=0;
        },
        buscarCodigo(){
          let me = this;
          var no_mostrar=1
          var no_existe=1;
          var otro_estatus=1;

          //recorre todos los arts del detalle de la OC
          for (var i = 0; i < me.array_scans.length; i+=1){

            //si el articulo escaneado existe
            if(me.codigo==me.array_scans[i].barcode){
              no_existe=0
              //existe y esta en pendiente
              if(me.array_scans[i].estatus=='pendiente'){
                me.array_scans[i].scans++;
                otro_estatus=0
                no_mostrar=0
              }
            }

          }//.for




          if(no_mostrar){
            me.alert_codigo_msg='Codigo no encontrado.'
          }else{
            me.alert_codigo_msg=''
          }
          me.alert_codigo=no_mostrar
        }
      },
      mounted() {
          this.cargarInfo()
      }
    }
</script>
