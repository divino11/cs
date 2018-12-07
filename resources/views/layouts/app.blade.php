<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/app.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="/js/app.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-dark fixed-top bg-dark p-0">
        <img alt="CoinSpy" src="{{ asset('images/logo-cs.png') }}">
        <h3 class="col-sm-9 h3 m-0 p-0 text-white navbar-text">@yield('title')</h3>
    </nav>
</header>
<main class="full-width">
    @yield('main')
</main>
@stack('scripts')
</body>
</html>
