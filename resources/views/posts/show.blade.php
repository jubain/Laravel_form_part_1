@extends('layout.app')
@section('content')
    <h1>Show Page</h1>
    <h3><a href="{{ route('post.edit', $post->id) }}">{{ $post->title }}</a></h3>
@stop
@section('footer')
@stop
