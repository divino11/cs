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
    <nav class="navbar navbar-dark fixed-top bg-dark p-0 navbar-expand-md">
        <a href="#" class="navbar-brand">CS</a>
        <span class="col-xs-9 h3 m-0 p-0 navbar-text">@yield('title')</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</header>
<main class="full-width">
    @yield('main')
</main>
@stack('scripts')
</body>
</html>
