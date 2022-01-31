<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Create and track the new released movies and tv shows">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="32x32" href="https://assets.reelgood.com/p/122804730ea4576d54970e60501759f0044ba394/icons/favicon-32x32.png">
        <title>Reelgood</title>
        <!-- Fonts -->
    </head>
    <body class="antialiased">
    <div id="app">
        <app-component></app-component>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
