@extends('layouts.app_dashboard')
@section('content')
<main class="main">
@include('admin.breadcrumb',['item'=>'store.courses.admin_course'])

<admin-course-videos :shop_id="{{$shop_id}}" :course_id="{{$course_id}}"></admin-course-videos>

<hr>
<div class="container mt-3">
    <div class="row">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif

        <div class="col-lg-12">
            <div id="myModal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Cargar video</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form id="nuevo" name="nuevo" method="post" action="{{route('dashboard.store.course.store_video')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{$shop_id}}">
                        <input type="hidden" name="course_id" value="{{$course_id}}">
                       <div class="form-group">
                           <label>Nombre</label>
                           <input class="form-control" autocomplete="off" type="text" name="name" value="{{old('name')}}">


                           <div class="invalid-feedback d-block">
                            @foreach ($errors->get('name') as $error)
                                 {{ $error }}
                             @endforeach
                         </div>
                       </div>

                        <div class="form-group">
                           <label>Descripción</label>
                           <input class="form-control" autocomplete="off"  type="text" name="description" value="{{old('description')}}">

                           <div class="invalid-feedback d-block">
                            @foreach ($errors->get('description') as $error)
                                 {{ $error }}
                             @endforeach
                         </div>
                       </div>

                       <div class="form-group">
                        <label>Video</label>
                        <input class="form-control"  type="file" name="video" required>

                        <div class="invalid-feedback d-block">
                            @foreach ($errors->get('video') as $error)
                                 {{ $error }}
                             @endforeach
                         </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" onclick="document.forms.nuevo.submit();">Guardar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>

                </form>
                  </div>
                </div>
              </div>


            <button id="btn-post" type="button" class="btn btn-primary"> <i class="fa fa-plus"></i> Nuevo video</button>



            @foreach ($videos as $video)

                <div class="card mb-3" style="max-width: 540px;">
                  <div class="row g-0">
                    <div class="col-md-4">
                        @if ($video->video)
                            <video width="125" height="125" controls>
                                <source src="{{Storage::disk('s3')->url($video->video)}}" type="video/mp4">
                                Tu navegador no soporta los vídeos de HTML5
                            </video>
                        @endif
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title">{{$video->name}}</h5>
                        <p class="card-text">{{$video->description}}</p>
                        <p class="card-text"><small class="text-muted">{{$video->created_at}}</small></p>
                        <form method="post" action="{{route('dashboard.store.course.destroy_video', ['video_id'=>$video->id,'shop_id'=>$shop_id,'course_id'=>$course_id])}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach

        </div>
    </div>
</div><!--./container-fluid-->
</main>
@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    //Mantener modal abierto si hay errores de validación.
    @if (count($errors) > 0)
        $('#myModal').modal('show');
    @endif
    </script>

  <script>
      $(document).ready(function() {
         //Evitar que el modal se bloquee.
        $("#myModal").prependTo("body");


        $("#btn-post").click(function(){

            $('#myModal').modal('show')


        })
      });
  </script>
@endpush
