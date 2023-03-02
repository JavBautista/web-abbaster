@extends('layouts.app_customer')
@section('content')
<div class="container">
    <customer-course-video :course_id="{{$course_id}}"></customer-course-video>
</div>

@endsection