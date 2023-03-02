<template>
 <div class="container">
      <div class="card grey lighten-3 chat-room">
        <div class="card-body">

          <!-- Grid row -->
          <div class="row px-lg-2 px-2">

            <!-- Grid column -->
            <div class="col-md-4 col-xl-4 px-0">

              <h6 class="font-weight-bold mb-3 text-center text-lg-left">Clientes</h6>

              <div class="white z-depth-1 px-2 pt-3 pb-0 members-panel-1 scrollbar-light-blue">
                <ul class="list-unstyled friend-list">

                  <li class="p-2" v-for="customer in arrayCustomers" :key="customer.id">
                    <a href="#" class="d-flex" @click="getMessages(customer.user_id)">
                      <img src="/assets/persona.png" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                      <div class="text-small">
                        <strong v-text="customer.name"></strong>
                        <!--<p class="last-message text-muted">Lorem ipsum dolor sit.</p>-->
                      </div>
                      <div class="chat-footer">
                        <!--<p class="text-smaller text-muted mb-0">5 min ago</p>
                        <span class="text-muted float-right">
                          <i class="fas fa-mail-reply" aria-hidden="true"></i>
                        </span>-->
                      </div>
                    </a>
                  </li>

                </ul>
              </div>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-8 col-xl-8 pl-md-3 px-lg-auto px-0">

              <div class="chat-message">
                <template v-if="mostrar_chat">
                <ul class="list-unstyled chat-1 scrollbar-light-blue">
                  <template v-for="message in arrayMessages">

                    <li class="d-flex justify-content-between mb-4" v-if="message.reply==0">
                      <img src="/assets/persona.png" alt="avatar" class="avatar rounded-circle mr-2 ml-lg-3 ml-0 z-depth-1">
                      <div class="chat-body white p-3 ml-2 z-depth-1 w-100">
                        <div class="header">
                          <strong class="primary-font">{{ user_name }}</strong>
                          <small class="pull-right text-muted"><i class="far fa-clock"></i> {{ message.created_at}}</small>
                        </div>
                        <hr class="w-100">
                        <p class="mb-0" v-text="message.message">
                        </p>
                      </div>
                    </li>

                    <li class="d-flex justify-content-between mb-4" v-else>
                        <div class="chat-body white p-3 z-depth-1 w-100">
                          <div class="header">
                            <strong class="primary-font">Yo</strong>
                            <small class="pull-right text-muted"><i class="far fa-clock"></i> <span v-text="message.created_at"></span></small>
                          </div>
                          <hr class="w-100">
                          <p class="mb-0" v-text="message.message"></p>
                        </div>
                        <img src="/assets/soporte-tecnico.png" alt="avatar" class="avatar rounded-circle mr-0 ml-3 z-depth-1">
                    </li>
                  </template>

                   <li class="white">
                      <div class="form-group basic-textarea">
                        <textarea v-model="message" class="form-control pl-2 my-0" id="exampleFormControlTextarea2" rows="3" placeholder="Type your message here..."></textarea>
                      </div>
                    </li>

                    <button type="button" class="btn btn-info btn-rounded btn-sm waves-effect waves-light float-right" @click="guardarMessage()">Enviar</button>
                </ul>
                </template>
                <template v-else>
                  <p class="text-muted"> Seleecione una conversación</p>
                </template>



              </div>

            </div>
            <!-- Grid column -->

          </div>
          <!-- Grid row -->

        </div>
      </div>
 </div>
</template>

<script>
    export default {
      data(){
    		return {
          message:'',
          arrayCustomers:[],
          arrayMessages:[],
          mostrar_chat:0,
          user_id:0,
          user_name:'',

    		}
    	},
    	methods:{

        loadUsersMessages(){
          let me=this;
          axios.get('/admin/messages/get-users').then(function (response) {
            me.arrayCustomers =  response.data.users_messages

          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });

        },
        getMessages(user_id){

          let me=this;
          axios.get('/admin/messages/get-messages/'+user_id).then(function (response) {
            console.log(response)
            me.arrayMessages =[];
            me.arrayMessages =  response.data.messages;
            me.mostrar_chat = me.arrayMessages.length;
            me.user_id= user_id

            me.arrayCustomers.map( function(x){
              if(me.user_id==x.user_id) me.user_name=x.name
            } );

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
          let me=this;
          axios.post('/customer/message/add',{
            'user_id':this.user_id,
            'message':this.message,
            'reply':1,
          }).then(function (response){
            console.log(response)
            me.getMessages(me.user_id);
          }).catch(function (error){
              console.log(error);
          });
        }

    	},
      mounted() {
        this.loadUsersMessages()
      }
    }
</script>
