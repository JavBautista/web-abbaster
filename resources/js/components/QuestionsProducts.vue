<template>
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Index</a></li>
            <li class="breadcrumb-item active" aria-current="page">Preguntas</li>
      </ol>
    </nav>

    <div class="card mb-1" v-for="question in arrayQuestions" :key="question.id">
      <div class="row no-gutters">
        <div class="col-md-4">
          <img :src="question.product.image" class="card-img" :alt="question.product.key">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title" v-text="question.product.name"></h5>
            <p class="card-text" v-text="question.question"></p>
            <p class="card-text"><small class="text-muted" v-text="question.created_at"></small></p>

            <div v-show="errorComentario[question.id]" class="form-group row div-error">
              <div class="container-fluid">
                <div class="alert alert-danger text-center">
                    El comentario no puede estar vacío.
                </div>
              </div>
            </div>

            <div action="" method="post">
              <div class="form-group">
                <textarea require class="form-control" rows="3" v-model="arrayTexts[question.id]"></textarea>
              </div>
              <div class="row">
                <div class="col-6"><button type="button" class="btn btn-primary" @click="guardarRespuesta(question.id)">Responder</button></div>
                <div class="col-6">
                  <button type="button" class="btn btn-danger float-right" @click="eliminarPregunta(question.id)"><span class="fa fa-trash"></span>&nbsp;Borrar</button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
    export default {
    	data(){
    		return {
          arrayQuestions:[],
          arrayTexts:[],
          errorComentario:[],
    		}
    	},
    	methods:{
        cargarQuestions(){
          let me = this
          axios.get('/questions/get').then(function (response) {
            me.arrayQuestions=response.data;
            var temp=new Array();
            for (var i = 0; i < me.arrayQuestions.length; i+=1) {
              temp[me.arrayQuestions[i].id]=''
            }
            me.arrayTexts=temp;
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
        },
        guardarRespuesta(id){
          /*if(this.validarComentario(id)){
                    return;
          }*/
          let me=this;
          console.log(id+' '+me.arrayTexts[id])
          axios.post('/questions/answer/add',{
            'question_id':id,
            'answer':me.arrayTexts[id],
          }).then(function (response){
            me.cargarQuestions();
          }).catch(function (error){
              console.log(error);
          });
        },
        eliminarPregunta(id){

          const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                  })

                  swalWithBootstrapButtons.fire({
                    title: '¿Desea eliminar esta pregunta?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.value) {

                      let me=this;
                      axios.put('/questions/answer/delete',{
                          'id': id
                      }).then(function (response){
                          me.cargarQuestions();
                          swalWithBootstrapButtons.fire(
                            'Pregunta eliminada!',
                            'La pregunta se ha eliminado correctamente.',
                            'success'
                          )
                      }).catch(function (error){
                          console.log(error);
                      });

                    } /* else if (
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
        validarComentario(id){
          this.errorComentario=0;
          this.errorMostrarMsjComentario=[];
          if(!this.arrayTexts[id]){
            this.errorComentario[id]=1;
          }
          return this.errorComentario;
        }
    	},
      mounted() {
          this.cargarQuestions()
      }
    }
</script>
