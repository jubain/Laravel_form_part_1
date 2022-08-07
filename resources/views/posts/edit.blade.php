@extends('layout.app')
@section('content')
    <h1>Edit Post</h1>
    <form method="post" action="/posts/{{ $post->id }}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT" />
        <input type="text" value={{ $post->title }} placeholder="enter title" name="title">
        <input type='submit' name="Submit" value="Update">
    </form>
    <form method="post" action="/posts/{{ $post->id }}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" />
        <input type='submit' name="Submit" value="Delete">
    </form>
@endsection
@section('footer')
@endsection
