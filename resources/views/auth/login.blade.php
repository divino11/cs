@extends('layouts.guest')

@section('title')
    Login
@endsection

@section('content')
    <div class="card bg-light login-card">
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" accept-charset="UTF-8">
                @csrf
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" type="email" value="{{ old('email') }}" required autofocus> </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" type="password" required> </div>
                <div class="form-group row">
                    <div class="checkbox col-6">
                        <label><input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}> Remember me</label>
                    </div>
                    <div class="col-6 text-right w-100">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg center-block w-50">Login</button>
                </div>
                <div class="form-group text-center">
                    <a href="{{ route('register') }}"><strong>New to Coinspy</strong></a>
                </div>
            </form>
        </div>
    </div>
@endsection
