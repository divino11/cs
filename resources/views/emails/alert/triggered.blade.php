@component('mail::message')
Alert {{ $alert->name }} has been triggered.

@include('alert.description.' . $alert->type).
The {{ App\Enums\AlertMetric::getKey((int)$alert->conditions['metric']) }} is currently {{ $value }}.

This alert has been triggered {{ $alert->triggerings_number }} out of {{ $alert->triggerings_limit }} times.
@component('mail::button', ['url' => $disableUrl])
    Disable this alert
@endcomponent
@component('mail::button', ['url' => $editUrl])
    Edit this alert
@endcomponent
@endcomponent