@extends('layout.app')
@section('content')
    <h1>Create Page</h1>
    <form method="post" action="/posts" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="enter title" name="title">
        </div>
        <div class="form-group">
            <input class="form-control" type="file" name="file">
        </div>
        <div class="form-group">
            <input type='submit' name="Submit">
        </div>
    </form>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@stop
@section('footer')
@stop
