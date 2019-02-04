@extends('layouts.user')

@section('content')
    <div class="container-fluid pt-4">
        <ul class="nav nav-tabs" role="tablist">
            @tabitem(['route' => 'user.account'])Account @endtabitem
            @tabitem(['route' => 'user.sms_credits'])SMS credits @endtabitem
            @tabitem(['route' => 'subscription.index'])Plan @endtabitem
            @tabitem(['route' => 'user.billing'])Billing @endtabitem
            @tabitem(['route' => 'user.support'])Support @endtabitem
            @tabitem(['route' => 'user.faq'])FAQ @endtabitem
        </ul>
        <div class="tab-content pt-3">
            @yield('tabcontent')
        </div>
    </div>
@endsection