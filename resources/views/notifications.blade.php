@extends('layouts.user')

@section('title', 'Activity')

@section('content')
    <div class="list-group notifications">
        @foreach($notifications as $notification)
            <div class="list-group-item list-group-item-action flex-column align-items-start p-4">
                <div class="d-flex w-100">
                    <span class="material-icons">mail</span>
                    <h5 class="mb-1">ALERT TRIGGERED AT {{ $notification->created_at->timezone(\Illuminate\Support\Facades\Auth::user()->timezone) }}</h5>
                </div>
                <p class="mb-1 text-muted">
                    Your {{ $notification['data']['alert_name'] }} alert has been triggered.
                    {{ $notification['data']['alert_description'] }}.
                    The {{ $notification['data']['ticker_key'] }} is currently {{ $notification['data']['ticker_value'] }}.
                </p>
            </div>
        @endforeach
    </div>
@endsection