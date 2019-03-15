@extends('layouts.guest')

@section('title')
    Reset Password
@endsection

@section('content')
    <div class="tab-pane active login-custom forgotpassword" id="login">

        <h3>Forgot password?</h3>

        <!-- combo -->
        <div class="myaccount-combo">
            <div class="form-group">
                <h5>We'll send you a link to reset your password:</h5>
                <input type="email" class="form-control" placeholder="Enter your email">
            </div>
        </div>
        <!-- END combo -->

        <a class="btn btn-default bt-section-out" href="#" role="button">Reset password</a>

    </div>
@endsection
