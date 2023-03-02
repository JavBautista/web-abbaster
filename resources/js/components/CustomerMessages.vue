<template>
  <div class="container">
    <div class="container">

        <div class="card grey lighten-3 chat-room">
          <div class="card-body">

            <!-- Grid row -->
            <div class="row px-lg-2 px-2">

              <!-- Grid column -->
              <div class="col-lg-12 pl-md-3 px-lg-auto px-0">

                <div class="chat-message">

                  <ul class="list-unstyled chat scrollbar-light-blue">

                    <li class="d-flex justify-content-between mb-4">
                      <img src="/assets/soporte-tecnico.png" alt="avatar" class="avatar rounded-circle mr-2 ml-lg-3 ml-0 z-depth-1">
                      <div class="chat-body white p-3 ml-2 z-depth-1 w-100" >
                        <div class="header">
                          <strong class="primary-font">Abbaster</strong>
                          <!--<small class="pull-right text-muted"><i class="far fa-clock"></i> 12 mins ago</small>-->
                        </div>
                        <hr class="w-100">
                        <p class="mb-0">
                          Hola, en Abbaster estamos para ayudarlo con sus consultas de los servicios, productos y procesos de compra.
                        </p>
                      </div>
                    </li>

                    <li v-for="message in arrayMessages" :key="message.id" class="d-flex justify-content-between mb-4">

                      <template v-if="message.reply">
                        <img src="/assets/soporte-tecnico.png" alt="avatar" class="avatar rounded-circle mr-2 ml-lg-3 ml-0 z-depth-1">
                        <div class="chat-body white p-3 z-depth-1 w-100">
                          <div class="header">
                            <strong class="primary-font">Abbaster</strong>
                            <small class="pull-right text-muted"><i class="far fa-clock"></i> <span v-text="message.created_at"></span></small>
                          </div>
                          <hr class="w-100">
                          <p class="mb-0" v-text="message.message"></p>
                        </div>
                      </template>
                      <template v-else>
                        <div class="chat-body white p-3 z-depth-1 w-100">
                          <div class="header">
                            <strong class="primary-font">Yo</strong>
                            <small class="pull-right text-muted"><i class="far fa-clock"></i> <span v-text="message.created_at"></span></small>
                          </div>
                          <hr class="w-100">
                          <p class="mb-0" v-text="message.message"></p>
                        </div>
                        <img src="/assets/persona.png" alt="avatar" class="avatar rounded-circle mr-0 ml-3 z-depth-1">
                      </template>

                    </li>


                    <li class="white">
                      <div class="form-group basic-textarea">
                        <textarea v-model="message" class="form-control pl-2 my-0" id="exampleFormControlTextarea2" rows="3" placeholder="Type your message here..."></textarea>
                      </div>
                    </li>

                    <button type="button" class="btn btn-info btn-rounded btn-sm waves-effect waves-light float-right" @click="guardarMessage()">Enviar</button>
                  </ul>

                </div>

              </div>
              <!-- Grid column -->

            </div>
            <!-- Grid row -->
          </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
      props:['user_id'],
    	data(){
    		return {
          message:'',
          arrayMessages:[],

    		}
    	},
    	methods:{
        getMessages(){
          let me=this;
          axios.get('/customer/messages/get/'+me.user_id).then(function (response) {
            console.log(response.data)
            me.arrayMessages = response.data

          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });

        },
        guardarMessage(){
          console.log('guardar msg')
          let me=this;
          axios.post('/customer/message/add',{
            'user_id':this.user_id,
            'message':this.message,
            'reply':0,
          }).then(function (response){
            console.log(response)
            me.getMessages();
          }).catch(function (error){
              console.log(error);
          });
        }

    	},
      mounted() {
        console.log('Msg Mounted '+this.user_id)
        this.getMessages()
      }
    }
</script>
