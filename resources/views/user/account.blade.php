@extends('layouts.user.account')

@section('title', 'Account')

@section('tabcontent')
    <div>
        <h1>Hi {{ $user->email }}</h1>
        <hr>
    </div>
    <h3>Account Details</h3>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 text-right">Email:</div>
            <div class="col-sm-3">{{ $user->email }}</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">SMS credits:</div>
            <div class="col-sm-3">0</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">Active channels:</div>
            <div class="col-sm-3">0</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">Alert count:</div>
            <div class="col-sm-3">0</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">Notification count:</div>
            <div class="col-sm-3">0</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">Last login:</div>
            <div class="col-sm-3">{{ now() }}</div>
        </div>
    </div>
    <hr>
    <h3>Subscription Details</h3>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 text-right">Plan:</div>
            <div class="col-sm-3">free</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">Alerts:</div>
            <div class="col-sm-3">0 out of 5</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">Credit card:</div>
            <div class="col-sm-3">none</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right"><a href="#">Change plan</a></div>
        </div>
    </div>
    <hr>
    <h3 class="h3">Settings</h3>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 text-right">Timezone:</div>
            <div class="col-sm-3">none</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right">Alerts:</div>
            <div class="col-sm-3">0 out of 5</div>
        </div>
        <div class="row">
            <div class="col-sm-2 text-right"><a href="#">Change password</a></div>
        </div>
    </div>
@endsection