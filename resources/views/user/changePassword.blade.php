@extends('layouts.user.account')

@section('title', 'Change password')

@section('content')
    <div class="change-password">
        <div class="container w-50">
            <form method="post" action="{{ route('user.password.update', ['user' => \Illuminate\Support\Facades\Auth::user()]) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input class="form-control" name="new_password" autocomplete="off" id="new_password" type="password"
                           required>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">Confirm new password</label>
                    <input class="form-control" name="new_password_confirmation" autocomplete="off"
                           id="new_password_confirmation" type="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default bt-section-out">Update password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
