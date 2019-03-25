@csrf
<input type="hidden" name="type" value="{{ $alert->type }}">
<!-- combo -->
<div class="myaccount-combo">

    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <!-- combo -->
            <h5>Exchange</h5>
            <div class="btn-group special">
                <select class="form-control" name="exchange_id" id="exchange" required>
                    <option value="" disabled>Select exchange</option>
                    @foreach($exchanges as $exchange)
                        <option value="{{ $exchange->id }}" data-quote="" @if(old('exchange_id', $alert->exchange_id) == $exchange->id) selected @endif>{{ ucfirst($exchange->name) }}</option>
                    @endforeach
                </select>
            </div>
            <!-- END combo -->
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <!-- combo -->
            <h5>Market</h5>
            <select class="form-control" name="market_id" id="markets" required>
                @if(old('exchange_id', $alert->exchange_id))
                    @foreach($exchanges->where('id', old('exchange_id', $alert->exchange_id))->first()->markets as $market)
                        <option value="{{ $market->id }}" data-quote="{{ $market->quote }}" @if(old('market_id', $alert->market_id) == $market->id) selected @endif>{{ $market->base }}/{{ $market->quote }}</option>
                    @endforeach
                @endif
            </select>
            <!-- END combo -->
        </div>
    </div>
</div>
<!-- END combo -->

@include("alert.conditions.{$alert->type_key}")
<div class="form-group currency_price_group" style="display: none">
    <h5 class="font-weight-bold text-uppercase"></h5><h5 id="currencyPrice"></h5>
</div>
<!-- combo -->
<div class="myaccount-combo newalert-module-checks">
    <h5>Notify me by</h5>
    @if(request()->user()->hasNotificationEmailVerified())
        <label class="container">Email
            <input type="checkbox" id="email_notification" value="{{ \App\Enums\NotificationChannel::Mail }}" name="notification_channels[][notification_channel]" @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Mail)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    @if(request()->user()->hasPhoneVerified())
        <label class="container">SMS
            <input type="checkbox" id="sms_notification" value="{{ \App\Enums\NotificationChannel::Nexmo }}" name="notification_channels[][notification_channel]" @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Nexmo)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    @if(request()->user()->hasPushoverVerified())
        <label class="container">Pushover
            <input type="checkbox" id="pushover_notification" value="{{ \App\Enums\NotificationChannel::Pushover }}" name="notification_channels[][notification_channel]" @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Pushover)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    @if(request()->user()->hasTelegramVerified())
        <label class="container">Telegram
            <input type="checkbox" id="telegram_notification" value="{{ \App\Enums\NotificationChannel::Telegram }}" name="notification_channels[][notification_channel]" @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Telegram)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    @if(request()->user()->hasPhoneVerified())
        @if(!request()->user()->sms)
            <p class="text-danger">Warning: you have 0 SMS Credits. Your alerts will not be sent to your mobile number
                until you've <a href="{{ route('user.sms_credits') }}">added credits</a>.</p>
        @endif
    @endif
</div>
<!-- END combo -->

<!-- combo -->
<div class="myaccount-combo">
    <div class="form-group">
        <h5>Maximum notifications for this alert:</h5>
        <div class="btn-group special">
            <input class="form-control" name="triggerings_limit" id="triggerings_limit" type="number" max="100" min="1" value="{{ old('triggerings_limit', $alert->triggerings_limit) }}" required>
        </div>
    </div>
</div>
<!-- END combo -->

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
                    $.get('{{ route('api.alert.metric') }}', data, function (response) {
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
                            $('.currency_price_group h5').text(metricText + ': ');
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
    <script>
        $(document).ready(function () {
            $('.chosen-search input').autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: '{{ route('api.alert.markets') }}',
                        dataType: "json",
                        data: {name: document.getElementsByClassName("chosen-search-input")[1].value, id: $('#exchange').val()},
                        beforeSend: function(){$('ul.chosen-results').empty();},
                        success: function( data ) {
                            $('ul.chosen-results').empty();
                            response( $.map( data, function( item ) {
                                item.markets.forEach(function (pair) {
                                    $('ul.chosen-results').append('<li class="active-result" data-option-array-index="' + pair.id + '">' + pair.base + '/' + pair.quote + '</li>');
                                });
                            }));
                        }
                    });
                }
            });
        });
    </script>
@endpush