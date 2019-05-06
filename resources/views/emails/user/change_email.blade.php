@component('mail::message')
<p style="font-size: 24px; color: #333; text-align:left; font-weight: bold; line-height: 30px;margin-bottom: 7px; font-family:Circular, sans-serif;">
    Please confirm your new email
</p>
<p style="color: #333; font-family:Circular-Book, sans-serif;margin-bottom: 20px;">
You have requested to change your notification email at Coinspy to this one.
</p>
@component('mail::button', ['url' => $url])
Confirm email change
@endcomponent

@endcomponent
