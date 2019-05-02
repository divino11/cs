@component('mail::message')
@lang(
"CoinSpy - your verification code is: :code",
[
'code' => $code
]
)
@endcomponent