@extends('layouts.user')

@section('content')
    <h2>Settings</h2>
    <ul class="nav nav-tabs" role="tablist">
        @tabitem(['route' => 'user.account'])Account @endtabitem
        @tabitem(['route' => 'channels.index'])Channels @endtabitem
        @tabitem(['route' => 'user.sms_credits'])SMS Credits @endtabitem
        @tabitem(['route' => 'user.subscription.index'])Plan @endtabitem
        @tabitem(['route' => 'user.billing'])Billing @endtabitem
        @tabitem(['route' => 'user.support'])Support @endtabitem
        @tabitem(['route' => 'user.faq'])FAQ @endtabitem
    </ul>
    <div class="tab-content">
        @yield('tabcontent')
    </div>
@endsection