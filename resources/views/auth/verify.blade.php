@extends('layouts.user')

@section('content')
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@if (\Illuminate\Support\Facades\Auth::user()->email) {{ __('Verify Your Email Address') }} @else {{ __('Add Your Email Address') }} @endif</div>

                <div class="card-body">
                    @if (\Illuminate\Support\Facades\Auth::user()->email)
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                    @else
                        <form action="{{ route('oauth.email') }}">
                            @csrf
                            <input type="email" name="email" placeholder="Enter your email">
                            <button class="btn btn-default bt-custom">Save</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
