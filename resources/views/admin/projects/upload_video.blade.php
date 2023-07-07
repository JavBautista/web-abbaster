@extends('layouts.app_main_dashboard')
@section('content')

<h2>UPLAD VIDEO</h2>
<form action="{{ route('upload-video') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="video">Video:</label>
        <input type="file" id="video" name="video">
    </div>

    <button type="submit">Subir Video</button>
</form>


@endsection
