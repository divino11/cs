@extends('layouts.user')

@section('title', 'Add Alert')

@section('content')
    <div class="list-group">
        <a href="{{ route('price_point.create') }}" class="list-group-item list-group-item-action flex-column align-items-start p-4">
            <span class="material-icons chevron-right">chevron_right</span>
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">PRICE POINT</h5>
            </div>
            <p class="mb-1 text-muted alert-description">
                Example: "Alert me if BTC/USD buy price increases to $6000 on Bitfinex"
            </p>
        </a>
        <a href="{{ route('percentage.create') }}" class="list-group-item list-group-item-action flex-column align-items-start p-4">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">PERCENTAGE CHANGE</h5>
                <span class="material-icons chevron-right">chevron_right</span>
            </div>
            <p class="mb-1 text-muted alert-description">
                Example: "Alert me if BTC/USD buy price increases by 10% within 5 minutes on Bitfinex"
            </p>
        </a>
        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start p-4">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">REGULAR UPDATE</h5>
                <span class="material-icons chevron-right">chevron_right</span>
            </div>
            <p class="mb-1 text-muted alert-description">
                Example: "Send me a daily alert showing the BTC/USD buy price on Binance"
            </p>
        </a>
    </div>
@endsection