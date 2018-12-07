@extends('layouts.user')

@section('title', 'Channels')

@section('content')
    <div class="container-fluid p-4">
        <div class="card border-top-0 border-left-0 border-right-0 bg-light">
            <div class="card-body">
                <div class="card-title h5">
                    Email
                </div>
                <div class="card-text">
                    <p>
                        {{ $user->getNotificationEmail() }} -
                        <span class="badge badge-{{ $user->hasNotificationEmailVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationEmailVerified() ? 'Verified' : 'Not verified' }}
                        </span>
                    </p>
                    <form class="form form-inline" action="{{ route('channels.email') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" type="email" name="notification_email" placeholder="Email" />
                            &nbsp;
                            <input class="btn btn-primary" type="submit" value="Use another address">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card border-top-0 border-left-0 border-right-0 bg-light">
            <div class="card-body">
                <div class="card-title h5">
                    SMS
                </div>
                <div class="card-text">
                    <p>Please enter your full phone number with the country code. You must purchase SMS credits as well to get alerts.</p>
                    <form class="form form-inline">
                        <div class="input-group">
                            <input class="form-control" type="phone" placeholder="Phone number" />
                            &nbsp;
                            <input class="btn btn-primary" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card border-top-0 border-left-0 border-right-0 bg-light">
            <div class="card-body">
                <div class="card-title h5">
                    Pushover
                </div>
                <div class="card-text">
                    <p><a href="http://pushover.net">What's Pushover?</a></p>
                    <form class="form form-inline">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Pushover key" />
                            &nbsp;
                            <input class="btn btn-primary" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card border-top-0 border-left-0 border-right-0 bg-light">
            <div class="card-body">
                <div class="card-title h5">
                    Telegram
                </div>
                <div class="card-text">
                    <p>Your verification code is 224914 - <span class="badge badge-danger">Not Verified</span></p>
                    <p>You can either click the button below and open Telegram or you can direct message @ourbot then enter:</p>
                    <form class="form form-inline">
                        <div class="input-group">
                            <a class="btn btn-outline-secondary" href="#">Open Telegram</a>
                            &nbsp;
                            <input class="btn btn-outline-secondary" type="submit" value="Reset verification code">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection