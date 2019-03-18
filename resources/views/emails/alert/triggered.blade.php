@component('mail::message')
    <h2 style="font-size: 30px; color: #222; text-align:left; line-height: 30px; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        Alert {{ $alert->name }} has been triggered.
    </h2>

    @include('alert.description.' . $alert->type).
    <p style="font-size: 15px; line-height: 22px; color: #333; text-align:left; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        <br>
        The {{ App\Enums\AlertMetric::getDescription((int)$alert->conditions['metric']) }} is currently
        <strong>{{ $value }}.</strong>
    </p> <br>

    <p style="font-size: 12px; line-height: 20px; color: #333; text-align:left; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        This alert has been triggered {{ $alert->triggerings_number }} out of {{ $alert->triggerings_limit }} times.
    </p>



    @component('mail::button', ['url' => $disableUrl])
        Disable this alert
    @endcomponent
    <br>



    <p style="font-size: 14px; line-height: 22px; color: #333; text-align:left; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        The CoinSpy team
    </p>

    @slot('footer')
        @component('mail::footer', ['url' => $disableUrl])
            <p style="text-align: center">© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')</p>
        @endcomponent
    @endslot
    {{--@component('mail::button', ['url' => $editUrl])
        Edit this alert
    @endcomponent--}}
@endcomponent