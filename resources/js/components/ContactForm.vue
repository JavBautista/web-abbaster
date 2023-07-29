<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Formulario de Contacto</h2>
                        <div class="row justify-content-center">
                          <div class="col-md-6">
                            <form>
                              <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre">
                              </div>
                              <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Ingrese su email">
                              </div>
                              <div class="form-group">
                                <label for="mensaje">Mensaje</label>
                                <textarea class="form-control" id="mensaje" rows="5" placeholder="Ingrese su mensaje"></textarea>
                              </div>
                              <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
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
        mounted() {
            console.log('Contact Form mounted.')
        }
    }
</script>
