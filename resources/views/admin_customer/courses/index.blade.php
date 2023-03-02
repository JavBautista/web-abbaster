@extends('layouts.app_customer')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr> <th>Curso</th> <th>Option</th> </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{$course->course->name}}</td>
                            <td>
                                <a href="{{route('customer.course',['course_id'=>$course->course->id])}}" class="btn btn-primary"><i class="fa fa-play"></i> Ir al curso</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
