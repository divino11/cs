@extends('layouts.user.account')

@section('title', 'Channels')

@section('tabcontent')
    <div class="tab-pane active" id="channels">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="settings-generalmodule">

                    <!-- combo -->
                    <div class="myaccount-combo channels-combo">
                        <div class="form-group">
                            <h5>Email <span
                                        class="badge badge-secondary badge-{{ $user->hasNotificationEmailVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationEmailVerified() ? 'Verified' : 'Not verified' }}
                                </span></h5>
                            <input type="email" class="form-control" placeholder="{{ $user->getNotificationEmail() }}"
                                   disabled>
                        </div>
                        <form class="form" action="{{ route('channels.email') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" class="form-control" name="notification_email"
                                       placeholder="Use an additional email">
                                <span class="input-group-btn">
    	                        <button class="btn btn-default bt-custom" type="submit">Save</button>
                            </span>
                            </div>
                        </form>
                        <!-- input with bt -->
                        <!-- END input with bt -->
                    </div>
                    <!-- END combo -->

                    <!-- combo -->
                    <div class="myaccount-combo channels-combo">
                        <div class="form-group">
                            @if ($user->getNotificationPhone())
                                <h5>SMS <span
                                            class="badge badge-secondary badge-{{ $user->hasNotificationPhoneVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationPhoneVerified() ? 'Verified' : 'Not verified' }}
                                    </span>
                                    <br><span class="entered-channel">{{$user->getNotificationPhone()}}</span></h5>
                            @else
                                <h5>SMS</h5>
                            @endif
                            @if (!$user->getNotificationPhone())
                                <p>Please enter your full phone number with the country code.
                                    You must <a href="{{ route('user.sms_credits') }}">purchase SMS credits</a> as well
                                    to get alerts.</p>
                                <form class="form form-inline" method="post" action="{{route('channels.phone.store')}}">
                                    @csrf
                                    <div class="input-group">
                                        <input class="form-control" type="tel" name="notification_phone"
                                               placeholder="Phone number"/>
                                        <span class="input-group-btn">
    	                                    <button class="btn btn-default bt-custom" type="submit">Save</button>
                                        </span>
                                    </div>
                                </form>
                            @else
                                @if (!$user->hasNotificationPhoneVerified())
                                    <form class="form" method="post"
                                          action="{{ route('channels.verification.store') }}">
                                        @csrf
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="phoneVerify"
                                                   placeholder="Enter verification code"/>
                                            <button class="btn btn-primary bt-custom text-uppercase" type="submit">
                                                Verify
                                            </button>
                                        </div>
                                    </form>
                                    <div class="form-buttons">
                                        <form class="form" method="post"
                                              action="{{route('channels.phone.destroy', $user->id)}}">
                                            @csrf
                                            @method('delete')
                                            <div class="input-group">
                                                <button class="btn btn-primary bt-custom-out text-uppercase"
                                                        type="submit">Use another mobile number
                                                </button>
                                            </div>
                                        </form>
                                        <form class="form" method="post"
                                              action="{{ route('channels.verification.update', $user->id) }}">
                                            @csrf
                                            @method('put')
                                            <div class="input-group">
                                                <button class="btn btn-primary bt-custom text-uppercase"
                                                        type="submit">Resend code
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    @if (!isset($user->sms))
                                        <p>
                                            <small>You have 0 SMS credits left. <a
                                                        href="{{ route('user.sms_credits') }}">Purchase some
                                                    now.</a></small>
                                        </p>
                                    @endif
                                    <form class="form" method="post"
                                          action="{{route('channels.phone.destroy', $user->id)}}">
                                        @csrf
                                        @method('delete')
                                        <div class="input-group">
                                            <button class="btn btn-primary bt-custom-out text-uppercase ml-1"
                                                    type="submit">Use another mobile number
                                            </button>
                                        </div>
                                    </form>
                            @endif
                        @endif
                        <!-- END input with bt -->
                        </div>
                    </div>
                    <!-- END combo -->

                    <!-- combo -->
                    <div class="myaccount-combo channels-combo">
                        <div class="form-group">
                            @if ($user->getNotificationPushover())
                                <h5>Pushover
                                    <span class="badge badge-{{ $user->hasNotificationPushoverVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationPushoverVerified() ? 'Verified' : 'Not verified' }}
                                    </span></h5>
                            @else
                                <h5>Pushover</h5>
                            @endif
                            @if (!$user->getNotificationPushover())
                                <p><a href="http://pushover.net" class="myaccount-pushover-link">What's Pushover?</a>
                                </p>
                                <form class="form" action="{{ route('channels.pushover.store') }}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="notification_pushover"
                                               placeholder="Pushover key"/>
                                        <button class="btn btn-primary bt-custom text-uppercase" type="submit">Save
                                        </button>
                                    </div>
                                </form>
                            @else
                                @if (!$user->hasNotificationPushoverVerified())
                                    <form class="form" method="post"
                                          action="{{route('channels.pushover.verify')}}">
                                        @csrf
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="pushoverVerify"
                                                   placeholder="Enter verification code"/>
                                            <button class="btn btn-primary bt-custom text-uppercase" type="submit">
                                                Verify
                                            </button>
                                        </div>
                                    </form>
                                    <div class="form-buttons">
                                        <form class="form" method="post"
                                              action="{{route('channels.pushover.destroy', $user->id)}}">
                                            @csrf
                                            @method('delete')
                                            <div class="input-group">
                                                <button class="btn btn-primary bt-custom-out text-uppercase"
                                                        type="submit">Change pushover key
                                                </button>
                                            </div>
                                        </form>
                                        <form class="form" method="post"
                                              action="{{route('channels.pushover.update', $user)}}">
                                            @csrf
                                            @method('put')
                                            <div class="input-group">
                                                <button class="btn btn-primary bt-custom text-uppercase"
                                                        type="submit">Resend code
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <form class="form" method="post"
                                          action="{{route('channels.pushover.destroy', $user->id)}}">
                                        @csrf
                                        @method('delete')
                                        <div class="input-group">
                                            <button class="btn btn-primary bt-custom-out text-uppercase" type="submit">
                                                Change pushover key
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                    <!-- END combo -->

                    <!-- combo -->
                    <div class="myaccount-combo channels-combo">
                        <div class="form-group">
                            @if (!$user->hasNotificationTelegramVerified())
                                <h5>Telegram <span
                                            class="badge badge-{{ $user->hasNotificationTelegramVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationTelegramVerified() ? 'Verified' : 'Not verified' }}
                        </span></h5>
                                <p>Your verification code is <b>{{ $user->telegram_verification_code }}</b></p>
                                <p>You can either click the button below and open Telegram or you can direct message
                                    @CoinSpy_bot
                                    then enter:</p>
                                <blockquote>
                                    <p><b>/start {{ $user->telegram_verification_code }}</b></p>
                                </blockquote>
                                <div class="form-buttons">
                                    <form class="form">
                                        <div class="input-group">
                                            <a class="btn btn-primary bt-custom text-uppercase link-telegram"
                                               target="_blank"
                                               href="https://telegram.me/CoinSpy_bot?start={{ $user->telegram_verification_code }}">Open
                                                Telegram</a>
                                        </div>
                                    </form>
                                    <form action="{{ route('channels.telegram.update') }}" method="post"
                                          class="form">
                                        @csrf
                                        <div class="input-group">
                                            <button class="btn btn-primary bt-custom text-uppercase" type="submit">Reset
                                                verification code
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <h5>Telegram <span
                                            class="badge badge-{{ $user->hasNotificationTelegramVerified() ? 'success' : 'danger' }}">
                            {{ $user->hasNotificationTelegramVerified() ? 'Verified' : 'Not verified' }}
                                </span></h5>
                                <form action="{{ route('channels.telegram.update') }}" method="post"
                                      class="form">
                                    @csrf
                                    <button class="btn btn-primary bt-custom-out text-uppercase" type="submit">Remove
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <!-- END combo -->
                </div>
            </div>
        </div>
    </div>
@endsection