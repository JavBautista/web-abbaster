@extends('layouts.app_dashboard')
@section('content')
<main class="main">
  <div class="container">
    @include('admin.breadcrumb',['item'=>'store.courses.admin_course'])
    <admin-course-videos :shop_id="{{$shop_id}}" :course_id="{{$course_id}}"></admin-course-videos>
  </div>
</main>
@endsection
