@extends('layouts.user.account')

@section('title', 'Plan')

@section('tabcontent')
    <div>
        <p>Your current plan: @subscribed pro @else free @endsubscribed</p>
        <div class="row">
            <div class="col-lg-6 col-xs-12 col-md-6">
                <div class="card card-primary text-center">
                    <div class="card-header bg-primary text-white h5">
                        FREE
                    </div>
                    <div class="list-group list-group-flush">
                        <li class="list-group-item bg-light">
                            <h1>Free</h1>
                            <p>Forever</p>
                        </li>
                        <li class="list-group-item">5 Active Alerts</li>
                        <li class="list-group-item bg-light">Price Point </li>
                        <li class="list-group-item">All Channels</li>
                        <li class="list-group-item bg-light">30+ Markets</li>
                        <li class="list-group-item">11,000+ Cryptocurrencies</li>
                        <li class="list-group-item bg-light">
                            @subscribed
                            <form method="post" action="{{ route('subscription.destroy') }}" onsubmit="return confirm('Downgrade your account at the end of your billing cycle? Warning - we will deactivate any alert that free plan does not support.')">
                                @csrf
                                @method('DELETE')
                                <input type="submit" href="#" id="downgrade-btn" class="btn btn-danger" value="Downgrade">
                            </form>
                            @else
                                <button class="btn btn-outline-info" disabled>Current Plan</button>
                            @endsubscribed
                        </li>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xs-12 col-md-6">
                <div class="card card-primary text-center">
                    <div class="card-header bg-success text-white h5">
                        PRO
                    </div>
                    <div class="list-group list-group-flush">
                        <li class="list-group-item bg-light">
                            <h1>$100/year</h1>
                            <p>$10/month</p>
                        </li>
                        <li class="list-group-item">Unlimited Alerts</li>
                        <li class="list-group-item bg-light">Pro Alerts </li>
                        <li class="list-group-item">All Channels</li>
                        <li class="list-group-item bg-light">30+ Markets</li>
                        <li class="list-group-item">11,000+ Cryptocurrencies</li>
                        <li class="list-group-item bg-light">
                            @subscribed
                                <button class="btn btn-outline-success" disabled>Current Plan</button>
                            @else
                                @if($user->subscription('main')->onGracePeriod())
                                    <form method="post" action="{{ route('subscription.update') }}" onsubmit="return confirm('Resume your subscription? Your card will be charged for the next billing period')">
                                        @csrf
                                        @method('PUT')
                                        <input type="submit" href="#" id="downgrade-btn" class="btn btn-success" value="Resume subscription">
                                    </form>
                                @else
                                    <a href="{{ route('subscription.create') }}" class="btn btn-success">Upgrade</a>
                                @endif
                            @endsubscribed
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection