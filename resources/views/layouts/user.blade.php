@extends('layouts.app')

@section('main')
    <div class="container-fluid p-0">
        <nav class="bg-dark sidebar">
            <ul class="nav flex-column">
                <li>
                    <div class="nav sidebar-links">
                        <a class="border-right border-dark" href="{{ route('user.account') }}">Account</a>
                        <a href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('alerts.create') }}"><span class="material-icons">add_circle_outline</span>Add Alert</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('notifications.index') }}"><span class="material-icons">view_list</span>Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('alerts.index') }}"><span class="material-icons">send</span>Alerts</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('channels') }}"><span class="material-icons">message</span>Channels</a></li>
            </ul>
        </nav>
        <div class="content">
            <div class="messages">
                @if (session('status'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('status') }}
                    </div>
                @endif
                    @if($errors->any())
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif
            </div>
            @yield('content')
        </div>
    </div>
@endsection