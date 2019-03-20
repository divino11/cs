@extends('layouts.guest')

@section('title')
    Reset Password
@endsection

@section('content')
    <div class="tab-pane login-custom active reset-password show" id="reset">
        <h3>Reset password</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="myaccount-combo">
                <div class="form-group">
                    <h5>{{ __('E-Mail Address') }}</h5>
                    <input placeholder="mark@coinspy.com" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ $email ?? old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="myaccount-combo">
                <div class="form-group">
                    <h5>{{ __('Password') }}</h5>
                    <input placeholder="Password" id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="myaccount-combo">
                <div class="form-group">
                    <h5>{{ __('Confirm Password') }}</h5>
                    <input placeholder="Confirm password" id="password-confirm" type="password"
                           class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn btn-default bt-section-out">{{ __('Reset Password') }}</button>
        </form>
    </div>
@endsection
