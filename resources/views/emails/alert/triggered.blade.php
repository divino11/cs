@component('mail::message')
<h2 style="font-size: 30px; color: #222; text-align:left; line-height: 30px; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    Alert {{ $alert->name }} has been triggered.
</h2>

<p style="font-size: 15px; line-height: 22px; color: #333; text-align:left; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
@include('alert.description.' . $alert->type).
    <br>
    The {{ App\Enums\AlertMetric::getDescription((int)$alert->conditions['metric']) }} is currently
    <strong>{{ $value }}.</strong>
</p>

<p style="font-size: 12px; line-height: 20px; color: #333; text-align:left; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    This alert has been triggered {{ $alert->triggerings_number }} out of {{ $alert->triggerings_limit }} times.
</p><br>
@component('mail::button', ['url' => $disableUrl])
    Disable this alert
@endcomponent
<br><br><br>
<p style="font-size: 14px; line-height: 22px; color: #333; text-align:left; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    The CoinSpy team
</p>
@slot('subcopy')
@component('mail::subcopy')
@lang(
"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below ".
"into your web browser:\n\n [:actionURL](:actionURL)",
[
'actionText' => 'Disable this alert',
'actionURL' => $disableUrl,
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