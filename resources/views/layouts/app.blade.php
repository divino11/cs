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
<header>
    {{--<nav class="navbar navbar-dark fixed-top bg-dark p-0 navbar-expand-lg">
        <a href="#" class="navbar-brand">CS</a>
        <span class="col-xs-9 h3 m-0 p-0 navbar-text">@yield('title')</span>
        <button class="navbar-toggler" type="button" data-target="#mainMenu" data-toggle="collapse"
                aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @auth
            <div class="bg-dark sidebar navbar-collapse collapse" id="mainMenu">
                <ul class="navbar-nav flex-column w-100 h-100">
                    <li>
                        <div class="nav sidebar-links">
                            <a class="border-right border-dark" href="{{ route('user.account') }}">Account</a>
                            <a href="#" onclick="$('#logoutForm').submit()">Logout</a>
                            <form method="post" action="{{ route('logout') }}" id="logoutForm">@csrf</form>
                        </div>
                    </li>
                    <li class="nav-item {{ (Request::is('alerts/create') ? 'active' : '') }}"><a class="nav-link" href="{{ route('alerts.create') }}"><span
                                    class="material-icons">add_circle_outline</span>Add Alert</a></li>
                    <li class="nav-item {{ (Request::is('notifications*') ? 'active' : '') }}"><a class="nav-link" href="{{ route('notifications.index') }}"><span
                                    class="material-icons">view_list</span>Activity @if($notificationUnRead > 0){{$notificationUnRead}}@endif</a></li>
                    <li class="nav-item {{ (Request::is('alerts') ? 'active' : '') }}"><a class="nav-link" href="{{ route('alerts.index') }}"><span
                                    class="material-icons">send</span>Alerts</a></li>
                    <li class="nav-item {{ (Request::is('channels*') ? 'active' : '') }}"><a class="nav-link" href="{{ route('channels.index') }}"><span
                                    class="material-icons">message</span>Channels</a></li>
                </ul>
            </div>
        @endauth
    </nav>--}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
        <a class="navbar-brand" href="#"><img src="{{asset('images/logo.svg')}}" alt=""/></a>
        @auth
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav d-block d-sm-none">
                    <li class="nav-item {{ (Request::is('alerts/create') ? 'active' : '') }}">
                        <a class="nav-link" href="{{ route('alerts.create') }}">Add new alert</a>
                    </li>
                    <li class="nav-item {{ (Request::is('alerts') ? 'active' : '') }}">
                        <a class="nav-link" href="{{ route('alerts.index') }}">Alerts</a>
                    </li>
                    <li class="nav-item {{ (Request::is('channels*') ? 'active' : '') }}">
                        <a class="nav-link" href="{{ route('channels.index') }}">Settings</a>
                    </li>
                    <li class="nav-item {{ (Request::is('notifications*') ? 'active' : '') }}">
                        <a class="nav-link" href="{{ route('notifications.index') }}">Notifications</a>
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
                <li class="{{ (Request::is('alerts/create') ? 'active' : '') }}">
                    <a href="{{ route('alerts.create') }}" class="list-group-item list-group-item-left">
                        Add new alert
                        <span class="material-icons">add_circle_outline</span>
                    </a>
                </li>

                <li class="{{ (Request::is('alerts') ? 'active' : '') }}">
                    <a href="{{ route('alerts.index') }}" class="list-group-item list-group-item-left">
                        Alerts
                    </a>
                </li>

                <li class="{{ (Request::is('user*') || Request::is('channels*') ? 'active' : '') }}">
                    <a href="{{ route('user.account') }}" class="list-group-item list-group-item-left">
                        Settings
                    </a>
                </li>

                <li class="{{ (Request::is('notifications*') ? 'active' : '') }}">
                    <a href="{{ route('notifications.index') }}" class="list-group-item list-group-item-left">
                        Notifications
                        @if($notificationUnRead > 0)
                            <span class="badge sidebar-left-custom-badge pull-right">
                            {{$notificationUnRead}}
                        </span>
                        @endif
                    </a>
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
