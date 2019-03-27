@extends('layouts.guest')

@section('title')
    Reset Password
@endsection

@section('content')
    <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 offset-xs-0">
    <div class="tab-pane active login-custom forgotpassword" id="login">

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <h3>Forgot password?</h3>
        <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <!-- combo -->
            <div class="myaccount-combo">
                <div class="form-group">
                    <h5>We'll send you a link to reset your password:</h5>
                    <input placeholder="Enter your email" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <!-- END combo -->

            <button type="submit" class="btn btn-default bt-section-out">Reset password</button>
        </form>
    </div>
    </div>
@endsection
