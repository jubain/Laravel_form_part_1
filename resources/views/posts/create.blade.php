@extends('layout.app')
@section('content')
    <h1>Create Page</h1>
    <form method="post" action="/posts">
        <input type="text" placeholder="enter title" name="title">
        <input type='submit' name="Submit">
    </form>
@stop
@section('footer')
@stop
