<template>
  <div class="row">
    <div class="col-md-12">
      <hr>
      <h2>Comentarios, preguntas y respuestas</h2>
      <div class="form-group">
        <textarea class="form-control"  v-model="comentario" placeholder="Ingresa comentario o pregunta."></textarea>
      </div>
      <div v-show="errorComentario" class="form-group row div-error mt-2">
        <div class="container-fluid">
          <div class="alert alert-danger text-center">
              <div v-for="error in errorMostrarMsjComentario" :key="error" v-text="error">
              </div>
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-primary" @click="guardarComentario()">Enviar</button>
      <button type="button" class="btn btn btn-success" @click="guardarComentarioyEnviarWhats()">Enviar y Whats <i class="fas fa-paper-plane"></i></button>
      <hr>

        <div v-for="question in arrayComentarios" :key="question.id">
          <hr>
          <p><i class="fas fa-question-circle"></i>&nbsp;<span class="small text-muted" v-text="question.created_at"></span></p>
          <p v-text="question.question"></p>
          <div class="ml-4" v-for="answer in question.answers">
            <p><li class="fa fa-reply"></li>&nbsp;<span class="small text-muted" v-text="answer.created_at "></span></p>
            <p v-text="answer.answer"></p>
          </div>

        </div>

    </div>
  </div>
</template>

<script>
    export default {
    	props:['product_id','product_name'],
    	data(){
    		return {
          comentario:'',
          arrayComentarios:[],
          errorComentario:0,
          errorMostrarMsjComentario:[],
    		}
    	},
    	methods:{
    		getComentarios(){
    			let me=this;
					axios.get('/web/product/comentarios/get/'+me.product_id).then(function (response) {
						console.log(response.data)
            me.arrayComentarios = response.data
					})
					.catch(function (error) {
						// handle error
						console.log(error);
					})
					.finally(function () {
						// always executed
					});

    		},
        guardarComentario(){
          if(this.validarComentario()){
                    return;
          }
          let me=this;
          axios.post('/web/product/comentarios/store',{
            'product_id':me.product_id,
            'comentario':me.comentario,
          }).then(function (response){
            me.comentario=''
            me.errorComentario=0
            me.errorMostrarMsjComentario=[]
            me.getComentarios();
          }).catch(function (error){
              console.log(error);
          });
        },
        guardarComentarioyEnviarWhats(){
          if(this.validarComentario()){
                    return;
          }
          let me=this;
          axios.post('/web/product/comentarios/store',{
            'product_id':me.product_id,
            'comentario':me.comentario,
          }).then(function (response){
            var msg = 'Hola, realice un comentario en la página web, me interesa obtener información de este producto: '+me.product_name
            msg = msg.toString().replace(/\s/g, '%20')
            let url ='https://api.whatsapp.com/send?phone=5212225353084&text='+msg
            window.open(url);
            me.comentario=''
            me.errorComentario=0
            me.errorMostrarMsjComentario=[]
            me.getComentarios();
          }).catch(function (error){
              console.log(error);
          });
        },
        validarComentario(){
          this.errorComentario=0;
          this.errorMostrarMsjComentario=[];
          if(!this.comentario) this.errorMostrarMsjComentario.push('Ingrese un comentario y/o pregunta.');
          if(this.errorMostrarMsjComentario.length) this.errorComentario=1;
          return this.errorComentario;
        },

    	},
      mounted() {
          this.getComentarios()
      }
    }
</script>
