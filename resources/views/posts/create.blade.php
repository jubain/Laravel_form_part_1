@extends('layout.app')
@section('content')
    <h1>Create Page</h1>
    <form method="post" action="/posts">
        <input type="text" placeholder="enter title" name="title">
        <input type='submit' name="Submit">
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
