@php
  $input_shop_id = isset($shop_id)?$shop_id:0;
@endphp
  <section class="contacto">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
              <div class="card-body">
                @if (Session::has('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ session('success') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                @endif
                <h2 class="text-center mb-4">Contactenos</h2>

                <form action="{{ route('form_contact.store') }}" method="post">
                    @csrf
                    <input type="hidden" name='shop_id' value="{{ $input_shop_id }}">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su nombre" required maxlength="255" pattern="[A-Za-z\s]+">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Ingrese su teléfono" maxlength="20" pattern="[0-9]+">
                    </div>
                    <div class="form-group">
                        <label for="message">Mensaje</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Ingrese su mensaje" required pattern="[\w\s.,!?()-]+"></textarea>
                    </div>
                    <!-- Agregar el campo CAPTCHA aquí si decides implementarlo -->
                    <!--<div class="form-group">
                        <div class="g-recaptcha" data-sitekey="{ { config('services.nocaptcha.sitekey') }}"></div>
                    </div>-->
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
              </div>
            </div>
        </div>
        <div class="col-md-6">
          <img src="{{ asset('assets/contacto_abbaster.jpg') }}" class="img-fluid" alt="contacto">
        </div>
      </div>
    </div>
  </section>


@push('styles-contacto')
  <style>
    .contacto {
      padding: 50px 0;
      margin-top: 20px; /* Agregar un margen superior de 20px */
    }

    .card {
      margin-bottom: 20px;
      border: 1px solid #e5e5e5;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-body {
      padding: 30px;
    }

    /* Estilos para el formulario */
    form {
      margin: 0 auto;
      max-width: 400px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: bold;
    }

    textarea.form-control {
      resize: none;
    }

    /* Estilos para la imagen */
    .col-md-6 .img-fluid {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }
  </style>
@endpush

