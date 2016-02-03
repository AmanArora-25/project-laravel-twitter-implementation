@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{url('uploadImage')}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="file" name="file"/>
        <button type="submit">Upload Now</button>
        </form>
    </div>
@endsection
