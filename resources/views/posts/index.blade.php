@extends('layout.app')
@section('content')
    <h1>Lists</h1>
    <ul>
        @foreach ($posts as $post)
            <li><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></li>
        @endforeach
    </ul>
@stop
@section('footer')
@stop
