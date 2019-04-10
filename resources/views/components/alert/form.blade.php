@csrf
<input type="hidden" name="type" value="{{ $alert->type }}">
<input type="hidden" name="hiddenMarket" id="setMarket" value="">
<input type="hidden" name="hiddenType" id="setType" value="">
<input type="hidden" name="hiddenDirection" id="setDirection" value="">
<input type="hidden" name="hiddenValue" id="setValue" value="">
<input type="hidden" name="hiddenCurrencyValue" id="setCurrencyValue" value="">
<input type="hidden" name="hiddenInterval" id="setInterval" value="">
<!-- combo -->
<div class="myaccount-combo">

    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <!-- combo -->
            <h5>Alert Type</h5>
            <div class="btn-group special">
                <select class="form-control" name="type" id="type" required>
                    @foreach(App\Enums\AlertType::getKeys() as $key => $item)
                        <option value="{{$key}}" @if(old('type', $alert->type) === $key) selected @endif>{{App\Enums\AlertType::getDescription($key)}}</option>
                    @endforeach
                </select>
            </div>
            <!-- END combo -->
        </div>
    </div>
    <br>
    <div class="row">
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
            <select class="form-control js-data-example-ajax" name="market_id" id="markets" required>
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

<div class="price_point tab-type">
    @include('alert.conditions.price_point')
</div>
<div class="percentage tab-type">
    @include('alert.conditions.percentage')
</div>
<div class="regular_update tab-type">
    @include('alert.conditions.regular_update')
</div>
<div class="volume tab-type">
    @include('alert.conditions.volume')
</div>
<div class="crossing tab-type">
    @include('alert.conditions.crossing')
</div>


<div class="form-group currency_price_group" style="display: none">
    <h5 class="font-weight-bold text-uppercase"></h5><h5 id="currencyPrice"></h5>
</div>
<!-- combo -->
<div class="myaccount-combo newalert-module-checks">
    <h5>Notify me by</h5>
    <label class="container">Browser Alert
        <input type="checkbox" id="browser_notification" value="{{ \App\Enums\NotificationChannel::Browser_Alert }}" name="notification_channels[][notification_channel]" @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Browser_Alert)->isNotEmpty()) checked @endif>
        <span class="checkmark"></span>
    </label>
    @if(request()->user()->hasNotificationEmailVerified())
        <label class="container">Email
            <input type="checkbox" id="email_notification" value="{{ \App\Enums\NotificationChannel::Mail }}" name="notification_channels[][notification_channel]" @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Mail)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    @if(request()->user()->getNotificationEmailToSms())
        <label class="container">Email-To-Sms
            <input type="checkbox" id="email_notification" value="{{ \App\Enums\NotificationChannel::Email_To_Sms }}" name="notification_channels[][notification_channel]" @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Email_To_Sms)->isNotEmpty()) checked @endif>
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
        <h5>With frequency</h5>
        <div class="toggle">
            <input type="radio" name="frequency" value="0" id="once" @if(old('frequency', $alert->frequency) == 0) checked @endif />
            <label for="once">Once</label>
            <input type="radio" name="frequency" value="1" id="every_time" @if(old('frequency', $alert->frequency) == 1) checked @endif />
            <label for="every_time">Every time</label>
        </div>
    </div>
</div>
<!-- END combo -->

<!-- combo -->
<div class="myaccount-combo">
    <div class="form-group">
        <h5>Per interval of</h5>
        <div class="cooldown-group">
            <select type="number" class="form-control" name="conditions[cooldown_number]">

            </select>
            <select name="conditions[cooldown_unit]" class="form-control">
                <option value="minutes"
                        @if(old('conditions.cooldown_unit', $alert->conditions['cooldown_unit']) == 'minutes') selected @endif>
                    Minutes
                </option>
                <option value="hours"
                        @if(old('conditions.cooldown_unit', $alert->conditions['cooldown_unit']) == 'hours') selected @endif>
                    Hours
                </option>
                <option value="days"
                        @if(old('conditions.cooldown_unit', $alert->conditions['cooldown_unit']) == 'days') selected @endif>
                    Days
                </option>
            </select>
        </div>
    </div>
</div>
<!-- END combo -->

<!-- combo -->
<div class="myaccount-combo">
    <div class="form-group">
        <h5>Expiring on</h5>
        <div class="calendar-group">
            <div class="expiration">
            <input class="form-control" data-input type="text" autocomplete="off" value="{{ old('expiration_date', $alert->expiration_date) }}"
                   name="expiration_date">
            <span class="input-group-addon" title="toggle" data-toggle>
        <i class="material-icons">calendar_today</i>
    </span>
            </div>
            <div class="clockpicker">
                <input type="text" class="form-control expiration-time" autocomplete="off" name="expiration_time">
                <span class="input-group-addon">
        <i class="material-icons">access_time</i>
    </span>
            </div>
        </div>
    </div>
</div>

<div class="myaccount-combo">
    <div class="form-group">
        <label class="container">Open-ended
            <input type="checkbox" id="open_ended" value="@if(old('open_ended', $alert->open_ended)) 0 @else 1 @endif" name="open_ended" @if(old('open_ended', $alert->open_ended)) checked @endif>
            <span class="checkmark"></span>
        </label>
    </div>
</div>
<!-- END combo -->

<!-- combo -->

<div class="myaccount-combo">
    <div class="form-group">
        <h5>Alert Message</h5>
        <textarea name="alert_message" class="form-control" id="alert_message" rows="3">{{ old('alert_message', $alert->alert_message) != null ? old('alert_message', $alert->alert_message) : '{market} {type} {price} {direction} {value} {interval}' }}</textarea>
        <p class="small-description">If you want change message use: <code>{market} {type} {direction} {value} {price} {interval}</code> (with brackets)</p>
    </div>
</div>
<!-- END combo -->

<div class="myaccount-combo">
    <div class="form-group">
        <h5>Alert Preview</h5>
        <div class="live-preview">
            <p></p>
        </div>
    </div>
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
                //$('#quoteCurrency').text('');
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
            }).change();
            $('#alertForm').change(function () {
                selectedPlatform = $('#exchange option:selected').val();
                selectedCurrency = $('#markets option:selected').val();
                metricVal = $("select[name='conditions[metric]']").val();
                metricText = $(".price_point select[name='conditions[metric]'] option:selected").text();
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
        $(document).ready(function () {
            var currentType;
            //remove required
            $('#alertForm button[type="submit"]').click(function(){
                $('input, textarea, select').filter('[required]:not(:visible)').each(function(){
                    if (!$(this)[0].checkValidity()) {
                        $(this).remove();
                    }
                });
            });
            //view alerts
            $('#alertForm').bind('change keyup', function () {
                var selectedType = $('#type option:selected').val();
                var selected = $('#markets option:selected');
                currentType = $('.tab-type')[selectedType].classList[0];
                $('.' + currentType + ' #quoteCurrency').text(selected.data('quote'));
                if (selectedType == '0') {
                    $('.tab-type').removeClass('active-type');
                    $('.price_point').addClass('active-type');
                }
                if (selectedType == '1') {
                    $('.tab-type').removeClass('active-type');
                    $('.percentage').addClass('active-type');
                }
                if (selectedType == '2') {
                    $('.tab-type').removeClass('active-type');
                    $('.regular_update').addClass('active-type');
                }
                if (selectedType == '3') {
                    $('.tab-type').removeClass('active-type');
                    $('.volume').addClass('active-type');
                }
                if (selectedType == '4') {
                    $('.tab-type').removeClass('active-type');
                    $('.crossing').addClass('active-type');
                }

                changeTextarea();
                //change options interval
            }).change();
            //select2
            $('#exchange').select2();
            $('#type').select2();
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{ route('api.alert.markets') }}',
                    data: function (params) {
                        return {
                            name: params.term,
                            id: $('#exchange').val(),
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data[0].markets, function (item) {
                                    return {
                                        id: item.id,
                                        text: item.base + '/' + item.quote,
                                    }
                            })
                        };
                    }
                }
            });

            function changeTextarea()
            {
                setTimeout(function () {
                    var market = $('.' + currentType + ' .market_name').text() ? $('.' + currentType + ' .market_name').text() : '';
                    var type = $('.' + currentType + " select[name='conditions[metric]'] option:selected").text().toLowerCase() ? $('.' + currentType + " select[name='conditions[metric]'] option:selected").text().toLowerCase() : '';
                    var direction = $('.' + currentType + " select[name='conditions[direction]'] option:selected").text() ? $('.' + currentType + " select[name='conditions[direction]'] option:selected").text() : '';
                    var value = $('.' + currentType + " input[name='conditions[value]']").val() ? $('.' + currentType + " input[name='conditions[value]']").val() : '';
                    var currencyValue = $('#currencyPrice').text() ? $('#currencyPrice').text() : '';
                    var interval = $('.' + currentType + " select[name='conditions[interval]'] option:selected").text() ? $('.' + currentType + " select[name='conditions[interval]'] option:selected").text() : '';
                    $('#setMarket').val(market);
                    $('#setType').val(type);
                    $('#setDirection').val(direction);
                    $('#setValue').val(value);
                    $('#setCurrencyValue').val(currencyValue);
                    $('#setInterval').val(interval);
                    var textarea = $('#alert_message').val();
                    var find = ["{market}", "{type}", "{direction}", "{value}", "{price}", "{interval}"];
                    var replace = [market, type, direction, value, currencyValue, interval];
                    textarea = textarea.replaceArray(find, replace);
                    $('.live-preview').text(textarea);
                }, 1000);
            }

            String.prototype.replaceArray = function(find, replace) {
                var replaceString = this;
                for (var i = 0; i < find.length; i++) {
                    replaceString = replaceString.replace(find[i], replace[i]);
                }
                return replaceString;
            };

        });
        $(document).ready(function () {
           $('.expiration').flatpickr({
               dateFormat: "Y-m-d",
               minDate: "today",
               wrap: true,
               maxDate: new Date().fp_incr(30)
           });

            $('.clockpicker').clockpicker({
                default: 'now',
                autoclose: true,
            });

            $("select[name='conditions[cooldown_unit]']").change(function () {
                var newOptions;
                var interval_unit = $("select[name='conditions[cooldown_unit]']").val();
                if (interval_unit == 'minutes') {
                    newOptions = {
                        "5": "5",
                        "15": "15",
                        "30": "30",
                        "40": "40",
                        "60": "60",
                        "90": "90"
                    };
                } else if (interval_unit == 'hours') {
                    newOptions = {
                        "1": "1",
                        "2": "2",
                        "3": "3",
                        "4": "4",
                        "6": "6",
                        "12": "12",
                        "24": "24"
                    };
                } else if (interval_unit == 'days') {
                    newOptions = {
                        "1": "1",
                        "2": "2",
                        "3": "3",
                        "4": "4",
                        "7": "7",
                        "30": "30"
                    };
                }
                var $el = $("select[name='conditions[cooldown_number]']");
                $el.empty();
                $.each(newOptions, function(key,value) {
                    $el.append($("<option></option>")
                        .attr("value", value).text(key));
                });
            }).change();
        });
    </script>
@endpush