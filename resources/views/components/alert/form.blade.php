@csrf
<input type="hidden" name="type" value="{{ $alert->type }}">
<div class="form-group">
    <label for="exchange_id">Exchange</label>
    <select class="form-control" name="exchange_id" id="exchange" required>
        <option value="" disabled>Select exchange</option>
        @foreach($exchanges as $exchange)
            <option value="{{ $exchange->id }}" data-quote="" @if(old('exchange_id', $alert->exchange_id) == $exchange->id) selected @endif>{{ ucfirst($exchange->name) }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="market_id">Market</label>
    <select class="form-control" name="market_id" id="markets" required>
        @if(old('exchange_id', $alert->exchange_id))
            @foreach($exchanges->where('id', old('exchange_id', $alert->exchange_id))->first()->markets as $market)
                <option value="{{ $market->id }}" data-quote="{{ $market->quote }}" @if(old('market_id', $alert->market_id) == $market->id) selected @endif>{{ $market->base }}/{{ $market->quote }}</option>
            @endforeach
        @endif
    </select>
</div>
@include("alert.conditions.{$alert->type_key}")
<div class="form-group currency_price_group" style="display: none">
    <span class="font-weight-bold text-uppercase"></span><span id="currencyPrice"></span>
</div>
<div class="form-group">
    <label for="">How should we notify you of this alert?</label>
    <div class="form-row" id="notificationChannels">
        @if(request()->user()->hasNotificationEmailVerified())
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="email_notification" value="{{ \App\Enums\NotificationChannel::Mail }}" name="notification_channels[][notification_channel]" required @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Mail)->isNotEmpty()) checked @endif>
                <label class="form-check-label" for="email_notification">Email</label>
            </div>
        @endif
        @if(request()->user()->hasPhoneVerified())
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="sms_notification" value="{{ \App\Enums\NotificationChannel::Nexmo }}" name="notification_channels[][notification_channel]" required @if(old('notification_channels', $alert->notification_channels) && in_array(['notification_channel' => \App\Enums\NotificationChannel::Nexmo], old('notification_channels', $alert->notification_channels->toArray()))) checked @endif>
                <label class="form-check-label" for="sms_notification">SMS</label>
            </div>
        @endif
        @if(request()->user()->hasTelegramVerified())
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="telegram_notification" value="{{ \App\Enums\NotificationChannel::Telegram }}" name="notification_channels[][notification_channel]" required @if(old('notification_channels', $alert->notification_channels) && in_array(['notification_channel' => \App\Enums\NotificationChannel::Telegram], old('notification_channels', $alert->notification_channels->toArray()))) checked @endif>
                <label class="form-check-label" for="telegram_notification">Telegram</label>
            </div>
        @endif
            @if(request()->user()->hasPushoverVerified())
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="pushover_notification" value="{{ \App\Enums\NotificationChannel::Pushover }}" name="notification_channels[][notification_channel]" required @if(old('notification_channels', $alert->notification_channels) && in_array(['notification_channel' => \App\Enums\NotificationChannel::Pushover], old('notification_channels', $alert->notification_channels->toArray()))) checked @endif>
                    <label class="form-check-label" for="pushover_notification">Pushover</label>
                </div>
            @endif
    </div>
    @if(request()->user()->hasPhoneVerified())
        @if(!request()->user()->sms)
            <p class="text-danger">Warning: you have 0 SMS Credits. Your alerts will not be sent to your mobile number
                until you've <a href="{{ route('user.sms_credits') }}">added credits</a>.</p>
        @endif
    @endif
</div>
<div class="form-group">
    <label for="triggerings_limit">Maximum notification for this alert</label>
    <input class="form-control" name="triggerings_limit" id="triggerings_limit" type="number" max="100" min="1" value="{{ old('triggerings_limit', $alert->triggerings_limit) }}" required>
</div>

@push('scripts')
    <script>
        const exchanges = @json($exchanges->keyBy('id'));
        $(document).ready(function(){
            var metricVal;
            var metricText;
            var selectedPlatform;
            var selectedCurrency;
            var currencyPrice;
            $('#exchange').change(function() {
                if (!exchanges.hasOwnProperty($('#exchange').val())) {
                    return;
                }
                $('.market_name').text('');
                $('#quoteCurrency').text('');
                selectedMarket = $('#markets').val();
                $('#markets').html('<option value="" disabled>Select market</option>');
                $.each(exchanges[$('#exchange').val()].markets, function(key, value){
                    $('#markets').append(
                        option = $("<option></option>")
                            .attr("value",value.id)
                            .text(value.base+'/'+value.quote)
                            .data('quote', value.quote)
                    );
                    if (selectedMarket == value.id) {
                        $('#markets').val(value.id).change();
                    }
                });
                $('#markets').trigger('chosen:updated');
            }).change();
            $('#markets').change(function () {
                selectedPlatform = $('#exchange option:selected').val();
                selectedCurrency = $('#markets option:selected').val();
                $("select[name='conditions[metric]']").change(function () {
                    metricVal = $("select[name='conditions[metric]']").val();
                    metricText = $("select[name='conditions[metric]'] option:selected").text();
                    var data = {
                        selectedPlatform: selectedPlatform,
                        selectedCurrency: selectedCurrency
                    };
                    if (!selectedPlatform || !selectedCurrency) {
                        return;
                    }
                    $.get({{ route('api.alert.metric') }}, data, function (response) {
                        if (response) {
                            switch (metricVal) {
                                case '0':
                                    currencyPrice = response.data.bid;
                                    break;
                                case '1':
                                    currencyPrice = response.data.ask;
                                    break;
                                case '2':
                                    currencyPrice = response.data.high_price;
                                    break;
                                case '3':
                                    currencyPrice = response.data.low_price;
                                    break;
                                case '4':
                                    currencyPrice = response.data.volume;
                                    break;
                            }
                            $('.currency_price_group').show();
                            $('.currency_price_group span').text(metricText + ': ');
                            $('#currencyPrice').text(currencyPrice);
                        }
                    }, 'json');
                }).change();
            });
            $('#markets').change(function() {
                var selected = $('#markets option:selected');
                $('.market_name').text(selected.text());
                $('#quoteCurrency').text(selected.data('quote'));
            }).change();
            var requiredCheckboxes = $('#notificationChannels :checkbox[required]');
            requiredCheckboxes.change(function(){
                if(requiredCheckboxes.is(':checked')) {
                    requiredCheckboxes.removeAttr('required');
                } else {
                    requiredCheckboxes.attr('required', 'required');
                }
            });
        });
        $(document).ready(function(){
            $('#exchange, #markets').chosen();
        });
    </script>
@endpush