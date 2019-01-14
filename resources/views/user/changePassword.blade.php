@extends('layouts.user.account')

@section('title', 'Change password')

@section('tabcontent')
    <div class="container w-50">
        <form method="post" action="{{ route('user.changePassword_update') }}">
            @csrf
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input class="form-control" name="new_password" autocomplete="off" id="new_password" type="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm new password</label>
                <input class="form-control" name="confirm_new_password" autocomplete="off" id="confirm_new_password" type="password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary text-uppercase" value="Update password">
            </div>
        </form>
    </div>
@endsection
