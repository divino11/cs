@component('mail::message')
{{-- Greeting --}}
<p style="font-size: 24px; font-weight: bold; color: #333; text-align:left; line-height: 30px;margin-bottom: 7px; font-family:Circular, sans-serif;">
@if (! empty($greeting))
{{ $greeting }}
@else
@if ($level === 'error')
@lang('Whoops!')
@else
@lang('Hello!')
@endif
@endif
</p>

{{-- Intro Lines --}}
@foreach ($introLines as $line)
<p style="font-size: 16px; line-height: 24px; margin-bottom: 20px; color: #333; text-align:left; font-family:Circular-Book, sans-serif;">
{{ $line }}
</p>
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset
{{-- Outro Lines --}}
@foreach ($outroLines as $line)
<p style="font-size: 16px; line-height: 22px; color: #333; margin-bottom: 0; text-align:left; font-family:Circular-Book, sans-serif;">
{{ $line }}
</p>
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@endif

{{-- Subcopy --}}
@isset($actionText)
    @slot('subcopy')
@component('mail::subcopy')
@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below ".
    "into your web browser:\n\n [:actionURL](:actionURL)",
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endcomponent
@endslot
@endisset
@slot('footer')
    @component('mail::footer')

    @endcomponent
@endslot
@endcomponent
