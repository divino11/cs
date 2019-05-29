@extends('layouts.user.account')

@section('title', 'Plan')

@section('tabcontent')
    <div class="tab-pane active" id="plan">
        <div class="settings-plan-section">
            <p>@subscribed You’re currently using the Pro plan. @else You’re currently using the Basic plan. To upgrade choose the Advanced plan. @endsubscribed</p>
            <div class="row">

                <!-- col 1 -->
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6">
                    <div class="pricing-module">
                        <!-- content -->
                        <div class="pricing-module-content">
                            <h4>Basic plan</h4>
                            <div class="pricing-module-ttl"><span class="pricing-module-price">$0</span></div>
                            @subscribed
                                @if($user->subscription('main')->onGracePeriod())
                                    <button class="btn btn-primary bt-section-out" disabled>You have Pro plan</button>
                                @else
                                    <form method="post" action="{{ route('user.subscription.destroy', $user->id) }}"
                                          onsubmit="return confirm('Downgrade your account at the end of your billing cycle? Warning - we will deactivate any alert that free plan does not support.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="downgrade-btn" class="btn btn-primary bt-section">Downgrade</button>
                                    </form>
                                @endif
                            @else
                                <button disabled class="btn btn-primary bt-section-out" role="button">Current plan
                                </button>
                            @endsubscribed
                        </div>
                        <!-- content -->
                        <!-- content wh -->
                        <div class="pricing-module-content-wh">
                            <ul>
                                <li><i class="material-icons">check</i> 5 Active Alerts</li>
                                <li><i class="material-icons">check</i> Price, Volume & More</li>
                                <li><i class="material-icons">check</i> Email, SMS, & Push</li>
                                <li><i class="material-icons">check</i> 3,000+ Currencies</li>
                                <li><i class="material-icons">check</i> 30+ Exchanges</li>
                            </ul>
                        </div>
                        <!-- END content wh -->
                    </div>
                </div>
                <!-- END col 1 -->

                <!-- col 2 -->
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6">
                    <div class="pricing-module">
                        <!-- content -->
                        <div class="pricing-module-content">
                            <h4>Advanced plan</h4>
                            <div class="pricing-module-ttl"><span class="pricing-module-price">$100</span> <span class="pricing-module-month">/year</span></div>
                            <div class="pricing-module-ttl"><span class="pricing-module-month">or</span></div>
                            <div class="pricing-module-ttl"><span class="pricing-module-price">$10</span> <span class="pricing-module-month">/month</span></div>
                            @subscribed
                                <button disabled class="btn btn-primary bt-section-out" role="button">Current Plan</button>
                            @else
                                @if($user->subscription('main'))
                                    <form method="post" action="{{ route('user.subscription.update', $user->id) }}" onsubmit="return confirm('Resume your subscription? Your card will be charged for the next billing period')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" id="downgrade-btn" class="btn btn-primary bt-section">Resume subscription</button>
                                    </form>
                                @else
                                    <a href="{{ route('user.subscription.create') }}" class="btn btn-primary bt-section">Upgrade</a>
                            @endif
                            @endsubscribed
                        </div>
                        <!-- content -->
                        <!-- content wh -->
                        <div class="pricing-module-content-wh">
                            <ul>
                                <li><i class="material-icons">check</i> Unlimited Alerts</li>
                                <li><i class="material-icons">check</i> Advanced Alerts</li>
                                <li><i class="material-icons">check</i> Email, SMS & Push</li>
                                <li><i class="material-icons">check</i> 3,000+ Currencies </li>
                                <li><i class="material-icons">check</i> 30+ Exchanges</li>
                            </ul>
                        </div>
                        <!-- END content wh -->
                    </div>
                </div>
                <!-- END col 2 -->

            </div>
        </div>
    </div>
@endsection