@extends('layouts.guest')

@section('title')
    Reset Password
@endsection

@section('content')
<div class="container">
            <div class="card bg-light">
                <div class="card-body p-5">
                    <h4 class="card-title">Forgot your password?</h4>
                    <p class="card-text">
                        Please enter the email address you use to log in to Coindera and we'll send you a link to reset your password.
                    </p>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input placeholder="Enter your email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    {{ __('Reset your password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
    </div>
</div>
@endsection
