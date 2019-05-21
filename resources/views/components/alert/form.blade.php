@csrf
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
                        <option value="{{ $exchange->id }}" data-quote=""
                                @if(old('exchange_id', $alert->exchange_id) == $exchange->id) selected @endif>{{ ucfirst($exchange->name) }}</option>
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
                        <option value="{{ $market->id }}" data-base="{{ $market->base }}"
                                data-quote="{{ $market->quote }}"
                                @if(old('market_id', $alert->market_id) == $market->id) selected @endif>{{ $market->base }}
                            /{{ $market->quote }}</option>
                    @endforeach
                @endif
            </select>
            <!-- END combo -->
        </div>
    </div>
</div>
<div class="myaccount-combo myaccount-combo-lesspad">
    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <!-- combo -->
            <h5>Alert me when <span class="market_name"></span></h5>
            <div class="btn-group special">
                <select class="form-control" name="conditions[metric]" required>
                    @foreach(App\Enums\AlertMetric::toSelectArray() as $key => $value)
                        <option value="{{ $key }}"
                                @if(old('conditions.metric', $alert->conditions['metric']) == $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <!-- END combo -->
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <!-- combo -->
            <h5>Has condition</h5>
            <div class="btn-group special">
                <select class="form-control" name="type" id="type" required>
                    @foreach(App\Enums\AlertType::toSelectArray() as $key => $item)
                        <option value="{{$key}}"
                                @if(old('type', $alert->type) === $key) selected @endif>{{$item}}</option>
                    @endforeach
                </select>
            </div>
            <!-- END combo -->
        </div>
    </div>
</div>

<!-- END combo -->

<div class="percentage myaccount-combo tab-type">
    @include('alert.conditions.percentage')
</div>
<div class="regular_update myaccount-combo tab-type">
    @include('alert.conditions.regular_update')
</div>
<div class="crossing tab-type">
    @include('alert.conditions.crossing')
</div>

<div class="myaccount-combo">
    <div class="form-group currency_price_group" style="display: none">
        <h4></h4><h4 id="currencyPrice"></h4>
    </div>
</div>
<!-- combo -->
<div class="myaccount-combo newalert-module-checks">
    <h5>Notify me by</h5>
    <label class="container">Browser Alert
        <input type="checkbox" id="browser_notification" value="{{ \App\Enums\NotificationChannel::Browser_Alert }}"
               name="notification_channels[][notification_channel]"
               @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Browser_Alert)->isNotEmpty()) checked @endif>
        <span class="checkmark"></span>
    </label>
    @if(request()->user()->hasNotificationEmailVerified())
        <label class="container">Email
            <input type="checkbox" id="email_notification" value="{{ \App\Enums\NotificationChannel::Mail }}"
                   name="notification_channels[][notification_channel]"
                   @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Mail)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    @if(request()->user()->hasEmailToSmsVerified())
        <label class="container">Email-To-Sms
            <input type="checkbox" id="email_notification" value="{{ \App\Enums\NotificationChannel::Email_To_Sms }}"
                   name="notification_channels[][notification_channel]"
                   @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Email_To_Sms)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    <label class="container @if(!request()->user()->hasPhoneVerified()) disabled-channel @endif">SMS
        <input type="checkbox" id="sms_notification" @if(!request()->user()->hasPhoneVerified()) disabled
               @endif value="{{ \App\Enums\NotificationChannel::Nexmo }}"
               name="notification_channels[][notification_channel]"
               @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Nexmo)->isNotEmpty()) checked @endif>
        <span class="checkmark"></span>
        @if(!request()->user()->hasPhoneVerified()) <a href="{{ route('channels.index') }}">Add channel first</a> @endif
    </label>
    @if(request()->user()->hasPushoverVerified())
        <label class="container">Pushover
            <input type="checkbox" id="pushover_notification" value="{{ \App\Enums\NotificationChannel::Pushover }}"
                   name="notification_channels[][notification_channel]"
                   @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Pushover)->isNotEmpty()) checked @endif>
            <span class="checkmark"></span>
        </label>
    @endif
    @if(request()->user()->hasTelegramVerified())
        <label class="container">Telegram
            <input type="checkbox" id="telegram_notification" value="{{ \App\Enums\NotificationChannel::Telegram }}"
                   name="notification_channels[][notification_channel]"
                   @if(collect(old('notification_channels', $alert->notificationChannels))->where('notification_channel', \App\Enums\NotificationChannel::Telegram)->isNotEmpty()) checked @endif>
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
            <input type="radio" name="frequency" value="0" id="once"
                   @if(old('frequency', $alert->frequency) == 0) checked @endif />
            <label for="once">Only once</label>
            <input type="radio" name="frequency" value="1" id="every_time"
                   @if(old('frequency', $alert->frequency) == 1) checked @endif />
            <label for="every_time">Every time</label>
        </div>
    </div>
</div>
<!-- END combo -->

<!-- combo -->
<div class="myaccount-combo section-interval">
    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <h5>With cooldown of</h5>
            <select type="number" class="form-control" name="interval_number" id="cooldown_value">
                @foreach(config('alerts.intervals.' . old('interval_unit', $alert->interval_unit)) as $value)
                    <option value="{{ $value }}"
                            @if(old('interval_number', $alert->interval_number) == $value) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <h5>&nbsp;</h5>
            <select name="interval_unit" class="form-control" id="cooldown">
                @foreach(App\Enums\AlertPeriod::toSelectArray() as $key => $value)
                    <option value="{{ strtolower(App\Enums\AlertPeriod::getDescription($key)) }}"
                            @if(old('interval_unit', $alert->interval_unit) == strtolower(App\Enums\AlertPeriod::getDescription($key))) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<!-- END combo -->

<!-- combo -->
<div class="myaccount-combo section-expiration">
    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <h5>Expiring on</h5>
            <div class="calendar-group">
                <div class="expiration">
                    <input class="form-control" data-input type="text" autocomplete="off"
                           value="{{ old('expiration_date', $alert->expiration_date) }}"
                           name="expiration_date">
                    <span class="input-group-addon" title="toggle" data-toggle>
        <i class="material-icons">calendar_today</i>
    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <h5>&nbsp;</h5>
            <div class="clockpicker">
                <input type="text" class="form-control expiration-time"
                       value="{{ old('expiration_time', $alert->expiration_time ?? '00:00') }}" autocomplete="off"
                       name="expiration_time">
                <span class="input-group-addon">
        <i class="material-icons">access_time</i>
    </span>
            </div>
        </div>
    </div>
</div>

<div class="myaccount-combo">
    <div class="form-group">
        <label class="container">Never expires
            <input type="hidden" id="open_ended" value="0" name="open_ended">
            <input type="checkbox" id="open_ended" value="1" name="open_ended"
                   @if(old('open_ended', $alert->open_ended ?? '')) checked @endif>
            <span class="checkmark"></span>
        </label>
    </div>
</div>
<!-- END combo -->

<!-- combo -->

<div class="myaccount-combo">
    <div class="form-group">
        <h5>Message</h5>
        <textarea name="alert_message" class="form-control" id="alert_message"
                  rows="3">{{ old('alert_message', $alert->alert_message) }}</textarea>
    </div>
</div>
<!-- END combo -->

@push('scripts')
    <script>
        const exchanges = @json($exchanges->keyBy('id'));
        var selectedType;
        $(document).ready(function () {
            localStorage.clear();
            var metricVal, metricText, selectedPlatform, selectedCurrency, currencyPrice, currentValue;
            var flag = 1;
            $('#exchange').change(function () {
                if (!exchanges.hasOwnProperty($('#exchange').val())) {
                    return;
                }
                $('.market_name').text('');
                selectedMarket = $('#markets').val();
                $('#markets').html('<option value="" disabled>Select market</option>');
                $.each(exchanges[$('#exchange').val()].markets, function (key, value) {
                    $('#markets').append(
                        option = $("<option></option>")
                            .attr("value", value.id)
                            .text(value.base + '/' + value.quote)
                            .data('quote', value.quote)
                    );
                    if (selectedMarket == value.id) {
                        $('#markets').val(value.id).change();
                    }
                });
            }).change();

            $('select[name="conditions[metric]"], #markets, #type').change(function () {
                selectedPlatform = $('#exchange option:selected').text().toLowerCase();
                selectedCurrency = $('#markets option:selected').text();
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
                                currencyPrice = response.last;
                                break;
                            case '1':
                                currencyPrice = response.baseVolume;
                                break;
                        }

                        $('.currency_price_group').show();
                        $('.currency_price_group h4').text(metricText + ': ');
                        $('#currencyPrice').text(currencyPrice);

                        if (selectedType == 5 || selectedType == 6) {
                            $("input[name='conditions[value]']:visible").val('2');
                        } else if (selectedType == 7 || selectedType == 8) {
                            $("input[name='conditions[value]']:visible").val('5');
                        } else {
                            $("input[name='conditions[value]']:visible").val(currencyPrice);
                        }

                        if ('{{ $alert->conditions['value'] }}') {
                            $("input[name='conditions[value]']:visible").val({{ $alert->conditions['value'] }});
                        }

                        currentValue = $("input[name='conditions[value]']:visible").val();
                        currencyPrice = getStorage(metricVal, selectedType, currentValue);
                        $("input[name='conditions[value]']:visible").val(currencyPrice);

                        if (flag == 1) {
                            if ('{{ $alert->alert_message }}') {
                                var message = '{{ $alert->alert_message }}';
                            }
                            flag = 0;
                            $('#alert_message').val(message.replace(/\s+/g, ' ').trim());
                        } else {
                            $('#alert_message').text(changeTextarea(currencyPrice));
                            if ($('#alert_message').keyup()) {
                                $('#alertForm').change(function () {
                                    $('#alert_message').text(changeTextarea(currencyPrice));
                                });
                                return false;
                            }
                        }
                    }
                }, 'json')
            }).change();

            $('#type').change(function () {
                selectedType = $('#type option:selected').val();
                if (selectedType == '9') {
                    $('#every_time').prop('checked', true);
                }
            }).change();
            $('#markets').change(function () {
                var selected = $('#markets option:selected');
                $('.market_name').text(selected.text());
                if ($('select[name="conditions[metric]"]').val() == '1') {
                    $('.input-group-text').text(selected.text().split('/')[0]);
                } else {
                    $('.input-group-text').text(selected.data('quote'));
                }
            }).change();
            var requiredCheckboxes = $('#notificationChannels :checkbox[required]');
            requiredCheckboxes.change(function () {
                if (requiredCheckboxes.is(':checked')) {
                    requiredCheckboxes.removeAttr('required');
                } else {
                    requiredCheckboxes.attr('required', 'required');
                }
            });

            $('#alert_message').bind('change', function () {
                if ($('#alert_message').val() == '') {
                    $('#alert_message').val(changeTextarea(currencyPrice));
                }
            });

            $('input[name="conditions[value]"]').bind('change', function () {
                setStorage(metricVal, selectedType, $('input[name="conditions[value]"]:visible').val());
            });

            function setStorage(metric, type, value) {
                localStorage.setItem(metric + '_' + type, value);
            }

            function getStorage(metric, type, value) {
                return localStorage.getItem(metric + '_' + type) ? localStorage.getItem(metric + '_' + type) : value;
            }

            function changeTextarea(price) {
                var market = $('#markets option:selected').text();
                var metric = $("select[name='conditions[metric]'] option:selected").text().toLowerCase() ? $("select[name='conditions[metric]'] option:selected").text().toLowerCase() : '';
                var type = $("#type option:selected").text().toLowerCase() ? $("#type option:selected").text().toLowerCase() : '';
                var value = price ? price : '';
                var intervalTime = $('select[name="conditions[interval_number]"] option:selected').val() + ' ' + $('select[name="conditions[interval_unit]"] option:selected').val();
                var regular = '';
                var interval = '';
                if (selectedType == 9) {
                    value = '';
                    regular = 'is currently {price}';
                    type = '';
                    interval = '';
                }
                if (selectedType == 5 || selectedType == 6) {
                    if (selectedType == 5) {
                        type = 'increased';
                        regular = ' times';
                    }
                    if (selectedType == 6) {
                        type = 'decreased';
                        regular = ' times';
                    }
                    interval = ' in ' + intervalTime;
                }
                if (selectedType == 7 || selectedType == 8) {
                    if (selectedType == 7) {
                        type = 'increased by';
                    }
                    if (selectedType == 8) {
                        type = 'decreased by';
                    }
                    regular = '%';
                    interval = ' in ' + intervalTime;
                }
                var message = market + ' ' + metric + ' ' + type + ' ' + value + regular + interval;

                return message.replace(/\s+/g, ' ').trim();
            }
        });

        $(document).ready(function () {
            setTimeout(function () {
                $('input[name="expiration_date"]').attr("readonly", false);
                if ($('input[name="open_ended"]').is(":checked")) {
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time').prop('disabled', true);
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time, .expiration .input-group-addon, .clockpicker .input-group-addon').addClass('expiration-disabled');
                }
            }, 1000);
            $('input[name="open_ended"]').change(function () {
                if ($('input[name="open_ended"]').is(":checked")) {
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time').prop('disabled', true);
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time').removeAttr('required');
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time, .expiration .input-group-addon, .clockpicker .input-group-addon').addClass('expiration-disabled');
                } else {
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time').prop('disabled', false);
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time').attr('required');
                    $('.expiration .flatpickr-input, .clockpicker .expiration-time, .expiration .input-group-addon, .clockpicker .input-group-addon').removeClass('expiration-disabled');
                }
            });
        });

        $(document).ready(function () {
            //remove required
            $('#alertForm button[type="submit"]').click(function () {
                $('input, textarea, select').filter('[required]:not(:visible), [disabled], .regular_update input[name="conditions[value]"]').each(function () {
                    if (!$(this)[0].checkValidity()) {
                        $(this).remove();
                    }
                });
                if ($('#type option:selected').val() == 5 || $('#type option:selected').val() == 6 || $('#type option:selected').val() == 7 || $('#type option:selected').val() == 8) {
                    $('input, textarea, select').filter('[required]:not(:visible), [disabled], .regular_update input[name="conditions[value]"]').remove();
                }
            });

            //view alerts
            $('#alertForm').bind('change keyup', function () {
                var selected = $('#markets option:selected');
                if ($('select[name="conditions[metric]"]').val() == '1') {
                    $('.input-group-text').text(selected.text().split('/')[0]);
                } else {
                    $('.input-group-text').text(selected.data('quote'));
                }
                if (selectedType == '7' || selectedType == '8') {
                    $('.input-group-text').text('%');
                }
                if (selectedType == '5' || selectedType == '6' || selectedType == '7' || selectedType == '8') {
                    $('.tab-type').removeClass('active-type');
                    $('.percentage').addClass('active-type');
                } else if (selectedType == '9') {
                    $('.tab-type').removeClass('active-type');
                    $('.regular_update').addClass('active-type');
                } else {
                    $('.tab-type').removeClass('active-type');
                    $('.crossing').addClass('active-type');
                }
            }).change();
            //select2
            $('#exchange').select2();
            $('select[name="conditions[metric]"]').select2();
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
        });

        $(document).ready(function () {
            $('.expiration').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "today",
                wrap: true,
                defaultDate: new Date().fp_incr(30)
            });

            $('.clockpicker, .starting-time').clockpicker({
                default: '00:00',
                autoclose: true,
            });

            $('.starting-date').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "today",
                wrap: true,
            });

            var freshIntervalValues = function (e) {
                intervalOptions = @json(config('alerts.intervals'));
                var unitList = $(e.target);
                var valueList = $('#' + unitList.attr('id') + '_value');
                var intervalUnit = unitList.val();

                valueList.empty();
                $.each(intervalOptions[intervalUnit], function (key, value) {
                    valueList.append(
                        $("<option></option>").attr("value", value).text(value)
                    );
                });
            };
            $("#cooldown").change(freshIntervalValues);
            $("#period").change(freshIntervalValues);

        });
    </script>
@endpush