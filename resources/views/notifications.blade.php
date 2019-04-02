@extends('layouts.user')

@section('title', 'Notifications')

@section('content')
    <h2>Notifications</h2>

    <!-- CREDITS -->
    <div class="tab-pane" id="credits">
    @forelse($notifications as $notification)
        <!-- blurb -->
        <div class="alerts-module notification-module @if(!$notification->read_at)notification-module-new @endif">

            <div class="pull-left">
                <img src="{{ asset('images/notifications_ico_bell.svg') }}" alt=""/>
            </div>
            <div class="media-body">
                <h6>{{ $notification->created_at->timezone(\Illuminate\Support\Facades\Auth::user()->timezone) }}
                    @if (!$notification->read_at)
                        <span class="label label-danger">New</span>
                    @endif
                </h6>
                <p><span class="notification-module-ttl">{{ $notification['data']['alert_name'] }}</span> {{ $notification['data']['alert_description'] }}.
                    The {{ $notification['data']['ticker_key'] }} is currently {{ $notification['data']['ticker_value'] }}.</p>
            </div>

        </div>
        @empty
            <h3 class="text-center pt-5">You don't have any notifications</h3>
        @endforelse
        {{$unRead->markAsRead()}}
        <div class="pull-right">{{$notifications->links()}}</div>
    </div>
@endsection