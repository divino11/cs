@component('mail::message')
Hi {{ $user->name }}

You have registered new account at coinspy.it.
@component('mail::button', ['url' => $url])
    Confirm email
@endcomponent
@endcomponent