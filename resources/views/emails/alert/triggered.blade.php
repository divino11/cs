@component('mail::message')
<h2 style="font-size: 30px; color: #222; text-align:center; line-height: 30px; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    Your {{ $alert->currency_pair }} alert was triggered.
</h2>

<p style="font-size: 18px; line-height: 22px; color: #333; text-align:center; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
{{$alert_message}}
</p>
<br>
<p style="text-align: center;">
@component('mail::button', ['url' => $editUrl])
    Modify Your Alert
@endcomponent
</p>
@slot('subcopy')
@component('mail::subcopy')
@lang(
"You are receiving this email because you are subscribed to get email notifications from the CoinSpy Alert Service.
Click the following links to \n [:pauseText](:pauseURL) or [:editText](:editURL) your alert.",
[
'pauseText' => 'pause',
'pauseURL' => $disableUrl,
'editText' => 'modify',
'editURL' => $editUrl,
]
)
@endcomponent
@endslot
@slot('footer')
@component('mail::footer', ['url' => $disableUrl])
<p style="text-align: center">© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')</p>
@endcomponent
@endslot
@endcomponent