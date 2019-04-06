@extends('layouts.user')

@section('title', 'New Alert')

@section('content')
    <h2>New alert</h2>

    <!-- blurb -->
    <div class="alerts-module">
        <a href="{{ route('price_point.create') }}">
            <div class="row">
                <div class="col-md-11 col-sm-11 col-xs-10">
                    <div class="pull-left">
                        <img src="{{ asset('images/alerts_ico_pricepoint.svg') }}" alt=""/>
                    </div>
                    <div class="media-body">
                        <h4>Price point</h4>
                        <p>Example: Alert me if BTC/USD's buy price increases to $800 on Coinbase.</p>
                    </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-2 newalert-module-right text-right">
                    <span class="material-icons">chevron_right</span>
                </div>
            </div>
        </a>
    </div>
    <!-- END blurb -->

    <!-- blurb -->
    <div class="alerts-module">
        <a href="{{ route('volume.create') }}">
            <div class="row">
                <div class="col-md-11 col-sm-11 col-xs-10">
                    <div class="pull-left">
                        <img src="{{ asset('images/alerts_ico_pricepoint.svg') }}" alt=""/>
                    </div>
                    <div class="media-body">
                        <h4>Volume</h4>
                        <p>Example: Alert me if BTC/USD's volume increases to 80000 on Coinbase.</p>
                    </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-2 newalert-module-right text-right">
                    <span class="material-icons">chevron_right</span>
                </div>
            </div>
        </a>
    </div>
    <!-- END blurb -->

    <!-- blurb -->
    <div class="alerts-module">
        <a href="{{ route('percentage.create') }}">
            <div class="row">
                <div class="col-md-11 col-sm-11 col-xs-10">
                    <div class="pull-left">
                        <img src="{{ asset('images/alerts_ico_regularupdate.svg') }}" alt=""/>
                    </div>
                    <div class="media-body">
                        <h4>Percentage change</h4>
                        <p>Example: Alert me if BTC/USD's buy price increases by 10% within 5 minutes on Coinbase.</p>
                    </div>
                </div>
                @subscribed
                <div class="col-md-1 col-sm-1 col-xs-2 newalert-module-right text-right">
                    <span class="material-icons">chevron_right</span>
                </div>
                @endsubscribed
            </div>
            @subscribed
            @else
                <div class="ribbon"><span>upgrade</span></div>
                @endsubscribed
        </a>
    </div>
    <!-- END blurb -->


    <!-- blurb -->
    <div class="alerts-module">
        <a href="{{ route('regular_update.create') }}">
            <div class="row">
                <div class="col-md-11 col-sm-11 col-xs-10">
                    <div class="pull-left">
                        <img src="{{ asset('images/alerts_ico_percentage.svg') }}" alt=""/>
                    </div>
                    <div class="media-body">
                        <h4>Regular update</h4>
                        <p>Example: Send me a daily alert showing the BTC/USD buy price on Coinbase.</p>
                    </div>
                </div>
                @subscribed
                <div class="col-md-1 col-sm-1 col-xs-2 newalert-module-right text-right">
                    <span class="material-icons">chevron_right</span>
                </div>
                @endsubscribed
            </div>
            @subscribed
            @else
                <div class="ribbon"><span>upgrade</span></div>
                @endsubscribed
        </a>
    </div>
@endsection