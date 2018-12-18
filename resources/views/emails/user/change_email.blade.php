@component('mail::message')
# Please confirm your new email

Hi, {{ $user->name }}

You have requested to change your email at Coinspy to this one.

@component('mail::button', ['url' => $url])
Confirm email change
@endcomponent

@endcomponent
