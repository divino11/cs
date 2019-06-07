@extends('layouts.user.account')

@section('title', 'Plan')

@section('tabcontent')
    <div class="tab-pane active" id="plan">
        <div class="settings-plan-section">
            <p>@subscribed You’re currently using the Pro plan. @else You’re currently using the Basic plan. To upgrade choose the Advanced plan. @endsubscribed</p>
            <div class="row">

                <!-- col 1 -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="pricing-module">
                        <!-- content -->
                        <div class="pricing-module-content">
                            <h4>Basic plan</h4>
                            <div class="pricing-module-ttl"><span class="pricing-module-price">$0</span> <span class="pricing-module-month">/month</span></div>
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
                                <button disabled class="btn btn-default bt-section-out" role="button">Current plan
                                </button>
                            @endsubscribed
                        </div>
                        <!-- content -->
                        <!-- content wh -->
                        <div class="pricing-module-content-wh">
                            <ul>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>5 Active Alerts</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>Price, Volume &amp; More</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>Email, SMS, &amp; Push</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>3,000+ Currencies</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>30+ Exchanges</li>
                            </ul>
                        </div>
                        <!-- END content wh -->
                    </div>
                </div>
                <!-- END col 1 -->

                <!-- col 2 -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="pricing-module">
                        <!-- content -->
                        <div class="pricing-module-content">
                            <h4>Advanced plan</h4>
                            <div class="pricing-module-ttl"><span class="pricing-module-price">$10</span> <span class="pricing-module-month">/month</span></div>
                            @subscribed
                                <button disabled class="btn btn-default bt-section-out" role="button">Current Plan</button>
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
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>Unlimited Alerts</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>Advanced Alerts</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>Email, SMS, &amp; Push</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>3,000+ Currencies</li>
                                <li><svg class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>30+ Exchanges</li>
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