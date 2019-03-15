<!doctype html>
<html lang="{{ app()->getLocale() }}" class="overflow-x">
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

<div class="container col-md-6 mt-5 px-0">
    <div class="log-content">
        <div class="col-md-8 offset-md-2 col-sm-8 offset-sm-2 offset-xs-0">

            <div class="log-content-top">
                <img src="{{ asset('images/logo.svg') }}" alt="">
            </div>
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>