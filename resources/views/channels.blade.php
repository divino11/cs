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
                    @if ($user->getNotificationPhone())
                        <p>
                            {{ $user->getNotificationPhone() }} -
                            <span class="badge badge-{{ $user->hasNotificationPhoneVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationPhoneVerified() ? 'Verified' : 'Not verified' }}
                        </span>
                        </p>
                    @endif
                    @if (!$user->getNotificationPhone())
                        <p>Please enter your full phone number with the country code. You must purchase SMS credits as
                            well to get alerts.</p>
                        <form class="form form-inline" method="post" action="{{route('phone.store')}}">
                            @csrf
                            <div class="input-group">
                                <input class="form-control" type="tel" name="notification_phone" placeholder="Phone number"/>
                                &nbsp;
                                <input class="btn btn-primary" type="submit" value="Save">
                            </div>
                        </form>
                    @else
                        @if (!$user->hasNotificationPhoneVerified())
                            <form class="form d-inline-block" method="post" action="{{route('phone.verify')}}">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control" type="text" name="phoneVerify" placeholder="Enter verification code"/>
                                    &nbsp;
                                    <input class="btn btn-primary text-uppercase ml-1" type="submit" value="Verify">
                                </div>
                            </form>
                            <form class="form d-inline-block" method="post" action="{{route('phone.destroy', $user->id)}}">
                                @csrf
                                @method('delete')
                                <div class="input-group">
                                    <input class="btn btn-outline-secondary text-uppercase ml-1" type="submit"
                                           value="Use another mobile number">
                                </div>
                            </form>
                            <form class="form d-inline-block" method="post" action="{{route('phone.update', $user)}}">
                                @csrf
                                @method('put')
                                <div class="input-group">
                                    <input class="btn btn-outline-secondary text-uppercase ml-1" type="submit"
                                           value="Resend code">
                                </div>
                            </form>
                        @else
                            @if (!isset($user->sms))
                                    <p>
                                        <small>You have 0 SMS credits left. <a
                                                    href="{{ route('user.sms_credits') }}">Purchase some
                                                now.</a></small>
                                    </p>
                                @endif
                            <form class="form d-inline-block" method="post" action="{{route('phone.destroy', $user->id)}}">
                                @csrf
                                @method('delete')
                                <div class="input-group">
                                    <input class="btn btn-outline-secondary text-uppercase ml-1" type="submit"
                                           value="Use another mobile number">
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="card border-top-0 border-left-0 border-right-0 bg-light">
            <div class="card-body">
                <div class="card-title h5">
                    Pushover
                </div>
                <div class="card-text">
                    @if ($user->getNotificationPushover())
                        <p>
                            {{ $user->getNotificationPushover() }} -
                            <span class="badge badge-{{ $user->hasNotificationPushoverVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationPushoverVerified() ? 'Verified' : 'Not verified' }}
                        </span>
                        </p>
                    @endif
                    @if (!$user->getNotificationPushover())
                        <p><a href="http://pushover.net">What's Pushover?</a></p>
                        <form class="form d-inline-block" action="{{ route('pushover.store') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input class="form-control" type="text" name="notification_pushover"
                                       placeholder="Pushover key"/>
                                &nbsp;
                                <input class="btn btn-primary text-uppercase" type="submit" value="Save">
                            </div>
                        </form>
                    @else
                        @if (!$user->hasNotificationPushoverVerified())
                            <form class="form d-inline-block" method="post" action="{{route('pushover.verify')}}">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control" type="text" name="pushoverVerify"
                                           placeholder="Enter verification code"/>
                                    &nbsp;
                                    <input class="btn btn-primary text-uppercase ml-1" type="submit" value="Verify">
                                </div>
                            </form>
                            <form class="form d-inline-block" method="post"
                                  action="{{route('pushover.destroy', $user->id)}}">
                                @csrf
                                @method('delete')
                                <div class="input-group">
                                    <input class="btn btn-default text-uppercase ml-1" type="submit"
                                           value="Change pushover key">
                                </div>
                            </form>
                            <form class="form d-inline-block" method="post"
                                  action="{{route('pushover.update', $user)}}">
                                @csrf
                                @method('put')
                                <div class="input-group">
                                    <input class="btn btn-default text-uppercase ml-1" type="submit"
                                           value="Resend code">
                                </div>
                            </form>
                        @else
                            <form class="form d-inline-block" method="post"
                                  action="{{route('pushover.destroy', $user->id)}}">
                                @csrf
                                @method('delete')
                                <div class="input-group">
                                    <input class="btn btn-default text-uppercase ml-1" type="submit"
                                           value="Change pushover key">
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="card border-top-0 border-left-0 border-right-0 bg-light">
            <div class="card-body">
                <div class="card-title h5">
                    Telegram
                </div>
                <div class="card-text">
                    @if (!$user->hasNotificationTelegramVerified())
                        <p>Your verification code is {{ $user->telegram_verification_code }} -
                            <span class="badge badge-{{ $user->hasNotificationTelegramVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationTelegramVerified() ? 'Verified' : 'Not verified' }}
                        </span>
                        </p>
                        <p>You can either click the button below and open Telegram or you can direct message @CoinSpy_bot
                            then enter:</p>
                        <blockquote>
                            <p>/start {{ $user->telegram_verification_code }}</p>
                        </blockquote>
                        <form class="form d-inline-block">
                            <div class="input-group">
                                <a class="btn btn-outline-secondary text-uppercase" target="_blank"
                                   href="https://telegram.me/CoinSpy_bot?start={{ $user->telegram_verification_code }}">Open Telegram</a>
                            </div>
                        </form>
                        <form action="{{ route('telegram.update') }}" method="post" class="form d-inline-block">
                            @csrf
                            <div class="input-group">
                                <input class="btn btn-outline-secondary text-uppercase" type="submit" value="Reset verification code">
                            </div>
                        </form>
                    @else
                        <span class="badge badge-{{ $user->hasNotificationTelegramVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationTelegramVerified() ? 'Verified' : 'Not verified' }}
                        </span>
                        <br>
                        <form action="{{ route('telegram.update') }}" method="post" class="form d-inline-block">
                            @csrf
                            <input class="btn btn-outline-secondary text-uppercase" type="submit" value="Remove">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection