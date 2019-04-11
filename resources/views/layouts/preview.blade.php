<!doctype html>
<html lang="{{ app()->getLocale() }}" class="overflow-x">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{'favicon/site.webmanifest'}}">
    <link rel="mask-icon" href="{{asset('favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="/css/app.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @auth
        <script>
            window.userId = {{ \Illuminate\Support\Facades\Auth::user()->id }};
        </script>
    @endauth
    <script src="/js/app.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
        <a class="navbar-brand" href="#"><img src="{{asset('images/logo.svg')}}" alt=""/></a>
        @auth
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav d-block d-sm-none">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('preview.triggered', ['route' => 'preview.triggered']) }}">Alert Triggered</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('preview.mails', ['route' => 'preview.channel_confirm']) }}">Channel Confirm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('preview.mails', ['route' => 'preview.change_email']) }}">Change Email</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('preview.mails', ['route' => 'preview.change_password']) }}">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('preview.mails', ['route' => 'preview.registration']) }}">Registration</a>
                    </li>
                </ul>
                <span class="ml-auto d-none d-sm-block">
                    <a href="#" onclick="$('#logoutForm').submit()">Log out</a>
                    <form method="post" action="{{ route('logout') }}" id="logoutForm">@csrf</form>
                </span>
            </div>
        @endauth
    </nav>
</header>
<div class="wrapper">
@auth
    <!-- Sidebar LEFT -->
        <nav id="sidebar">
            <ul class="list-group">
                <li>
                    <a href="{{ route('preview.mails', ['route' => 'preview.triggered']) }}" class="list-group-item list-group-item-left">
                        Alert Triggered
                    </a>
                </li>
                <li>
                    <a class="list-group-item list-group-item-left" href="{{ route('preview.mails', ['route' => 'preview.channel_confirm']) }}">Channel Confirm</a>
                </li>
                <li>
                    <a class="list-group-item list-group-item-left" href="{{ route('preview.mails', ['route' => 'preview.change_email']) }}">Change Email</a>
                </li>
                <li>
                    <a class="list-group-item list-group-item-left" href="{{ route('preview.mails', ['route' => 'preview.change_password']) }}">Change Password</a>
                </li>
                <li>
                    <a class="list-group-item list-group-item-left" href="{{ route('preview.mails', ['route' => 'preview.registration']) }}">Registration</a>
                </li>
            </ul>
        </nav>
        <!-- END sidebar left -->

@endauth
<!-- MAIN CONTENT -->
    <div id="content" style="width: 100%;">
        @yield('main')
    </div>
</div>
@stack('scripts')
</body>
</html>
