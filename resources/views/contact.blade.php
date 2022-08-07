@extends('layout.app')
@section('content')
    <h1>Contact Page</h1>
    @if (count($people))
        <ul>
            @foreach ($people as $person)
                <li>{{ $person }}</li>
            @endforeach
        </ul>
    @endif
@stop

@section('footer')
    <script>
        alert('hello')
    </script>
@stop
<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title> -->

<!-- Fonts -->
<!-- <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="container">
    <h1>Contact Page</h1>
</body>

</html> -->
