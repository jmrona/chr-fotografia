<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
        var BASE_URL = '{{ URL::to('/')}}';
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Acme|Advent+Pro|Bangers|Caveat|Comfortaa|Concert+One|Courgette|Dancing+Script|Domine|Great+Vibes|Indie+Flower|Kalam|Lobster|Orbitron|Pacifico|Patrick+Hand|Permanent+Marker|Righteous|Teko&display=swap" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="app">
    </div>
</body>
</html>
