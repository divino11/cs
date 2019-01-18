@extends('layouts.user')

@section('content')
    <div class="container-fluid pt-4">
        <ul class="nav nav-tabs" role="tablist">
            @tabitem(['route' => 'user.account'])Account @endtabitem
            @tabitem(['route' => 'login'])SMS credits @endtabitem
            @tabitem(['route' => 'login'])Plan @endtabitem
            @tabitem(['route' => 'login'])Billing @endtabitem
            @tabitem(['route' => 'login'])Support @endtabitem
            @tabitem(['route' => 'user.faq'])FAQ @endtabitem
        </ul>
        <div class="tab-content pt-3">
            @yield('tabcontent')
        </div>
    </div>
@endsection