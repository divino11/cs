@extends('layouts.guest')

@section('title')
    Reset Password
@endsection

@section('content')
    <div class="tab-pane active login-custom forgotpassword" id="login">

        <h3>Forgot password?</h3>
        <form method="POST" action="{{ route('password.email') }}">
         @csrf
        <!-- combo -->
        <div class="myaccount-combo">
            <div class="form-group">
                <h5>We'll send you a link to reset your password:</h5>
                <input placeholder="Enter your email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            </div>
        </div>
        <!-- END combo -->

        <button type="submit" class="btn btn-default bt-section-out">Reset password</button>
        </form>
    </div>
@endsection
