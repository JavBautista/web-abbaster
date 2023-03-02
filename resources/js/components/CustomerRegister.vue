<template>
  <div class="container">
    <div class="card mt-2 mb-2">
      <div class="card-header">
          Bienvenido a Abbaster.
      </div>
      <div class="card-body">

        <div v-show="error" class="alert alert-danger text-center">
          <li class="fa fa-exclamation-triangle"></li>
          <p v-for="msg in errorMostrarMsj" :key="msg" v-text="msg"></p>
        </div>

        <h3>¡Resgitrate Gratis!</h3>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" v-model="name" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control" v-model="email" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control" v-model="password" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar Password</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="button" class="btn btn-primary" @click="registrarse()">Registrarse</button>
            </div>
        </div>

        <hr>
        <p class="card-text">¿Ya tienes una cuenta? Ingresa <a :href="'/login'">AQUI</a></p>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        data(){
            return {
          name:'',
          email:'',
          password:'',
          password_confirmation:'',
          error:0,
          errorMostrarMsj:[],
            }
        },
        methods:{
        registrarse(){
          if(this.validarDatos()){
              return;
          }
          let me=this;
          axios.post('/customer/register',{
              'name': this.name,
              'email': this.email,
              'password': this.password,
          }).then(function (response){
            //consol.log(response)
            window.location.href = '/login';
          }).catch(function (error){
              if (error.response.status == 422){
               //this.validationErrors = error.response.data.errors;
                me.error=1;
                me.errorMostrarMsj=[];
                me.errorMostrarMsj=error.response.data.errors;
              }
          });
        },
        validarDatos(){
          this.error=0;
          this.errorMostrarMsj=[];
          if(!this.name) this.errorMostrarMsj.push('El nombre no puede estar vacio');
          if(!this.email) this.errorMostrarMsj.push('El email no puede estar vacio');
          if(!this.password) this.errorMostrarMsj.push('El password no puede estar vacio');
          if(!this.password_confirmation) this.errorMostrarMsj.push('La confirmación del password no puede estar vacio');
          if(this.password!=this.password_confirmation)this.errorMostrarMsj.push('El password no coincide.');
          if(this.errorMostrarMsj.length) this.error=1;
          return this.error;

        }

        },
      mounted() {

      }
    }
</script>
