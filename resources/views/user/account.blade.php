@extends('layouts.user.account')

@section('title', 'Account')

@section('tabcontent')
    <div>
        <h1 class="account-name">Hi {{ $user->email }}</h1>
        <hr>
    </div>
    <h3>Account Details</h3>
    <div class="container-fluid details-wrapper">
        <div class="details-item">
            <div class="detail">Email:</div>
            <div class="detail">{{ $user->email }}</div>
        </div>
        <div class="details-item">
            <div class="detail">SMS credits:</div>
            <div class="detail">{{ $user->sms }}</div>
        </div>
        <div class="details-item">
            <div class="detail">Active channels:</div>
            <div class="detail">0</div>
        </div>
        <div class="details-item">
            <div class="detail">Alert count:</div>
            <div class="detail">{{ $user->alerts()->count() }}</div>
        </div>
        <div class="details-item">
            <div class="detail">Notification count:</div>
            <div class="detail">{{ $user->notifications()->count() }}</div>
        </div>
        <div class="details-item">
            <div class="detail">Last login:</div>
            <div class="detail">{{ now() }}</div>
        </div>
    </div>
    <hr>
    <h3>Subscription Details</h3>
    <div class="container-fluid">
        <div class="details-item">
            <div class="detail">Plan:</div>
            <div class="detail">@subscribed pro @else free @endsubscribed</div>
        </div>
        @if($user->subscribed('main'))
            <div class="details-item">
                <div class="detail">Billing cycle end:</div>
                <div class="detail">{{ $subscription->ends_at ? $subscription->ends_at : $subscription->updated_at->addYear()}}</div>
            </div>
        @endif
        <div class="details-item">
            <div class="detail">Alerts:</div>
            <div class="detail">{{ $user->alerts()->count() }} @unless($user->subscribed('main')) out of 5 @endunless</div>
        </div>
        @if($user->card_last_four)
        <div class="details-item">
            <div class="detail">Credit card on File:</div>
            <div class="detail">{{ $user->card_brand }} ending on {{ $user->card_last_four }}</div>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-2 text-right"><a href="{{ route('subscription.index') }}">Change plan</a></div>
        </div>
    </div>
    <hr>
    <h3 class="h3">Settings</h3>
    <div class="container-fluid">
        <div class="details-item">
            <div class="detail">Timezone:</div>
            <div class="detail">none</div>
        </div>
        <div class="details-item">
            <div class="detail"><a href="{{ route('user.changePassword') }}">Change password</a></div>
        </div>
    </div>
@endsection