@component('mail::message')
# Please confirm your new email

Hi

You have requested to change your notification email at Coinspy to this one.

@component('mail::button', ['url' => $url])
Confirm email change
@endcomponent

@endcomponent
