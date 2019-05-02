@component('mail::message')
<h2 style="font-size: 28px; color: #222; text-align:center; line-height: 30px; font-family: 'Circular-Book', sans-serif">
    Your {{ $alert->currency_pair }} alert was triggered.
</h2>

<p style="font-size: 18px; line-height: 22px; color: #333; margin-bottom: 25px; text-align:center; font-family: 'Circular-Book', sans-serif">
{{$alert_message}}
</p>
<p style="text-align: center; margin-bottom: 0;">
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