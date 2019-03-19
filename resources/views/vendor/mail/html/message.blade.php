@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Footer --}}
    @slot('footer')
        @isset($subcopy)
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endisset
        @component('mail::footer')
            <p style="text-align: center">© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')</p>
        @endcomponent
    @endslot
@endcomponent
