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
                <option value="" disabled>Select market</option>
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
                    <option value="" disabled>Select metric</option>
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
                    <option value="" disabled>Select condition</option>
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

    <div class="add-actions"><i class="material-icons">arrow_drop_down</i> More actions</div>
    <div class="wrapper-add-actions" style="display: @if( $alert->sound_enable ) block @else none @endif">
        <h5>Browser Alert</h5>
        <label class="container">Play Sound
            <input type="hidden" id="sound_enable" value="0" name="sound_enable">
            <input type="checkbox" value="1" @if(old('sound_enable', $alert->sound_enable)) checked @endif name="sound_enable">
            <span class="checkmark"></span>
        </label>
        <div class="row gutter-10">
            <div class="col-md-6 first-field-gutter">
                <select class="form-control" name="sound" style="display: @if( $alert->sound_enable ) block @else none @endif">
                    <option disabled selected>Choose sound</option>
                    <option @if($alert->sound == 'notification.mp3') selected @endif value="notification.mp3">
                        Notification
                    </option>
                    <option @if($alert->sound == 'phone.mp3') selected @endif value="phone.mp3">Phone</option>
                    <option @if($alert->sound == 'tone.wav') selected @endif value="tone.wav">Tone</option>
                    <option @if($alert->sound == 'viber.mp3') selected @endif value="viber.mp3">Note</option>
                    <option @if($alert->sound == 'vk.mp3') selected @endif value="vk.mp3">Fault</option>
                    <option @if($alert->sound == 'return_tone.wav') selected @endif value="return_tone.wav">Return
                        tone
                    </option>
                </select>
            </div>
        </div>
    </div>
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
        <textarea name="alert_message" class="form-control" id="alert_message" rows="3">
            {{ old('alert_message', $alert->alert_message) }}
        </textarea>
    </div>
</div>
<!-- END combo -->

@push('scripts')
    <script>
        const exchanges = @json($exchanges->keyBy('id'));
        var selectedType;
        $(document).ready(function () {
            localStorage.clear();
            var selectedPlatform, selectedCurrency, currencyPrice = '', currentValue, alertMessage;
            var flag = 1;
            var ticker, metricVal, metricText = {};
            if ('{{ $alert->conditions['value'] }}') {
                setStorage('value', '0', {{ $alert->conditions['value'] }});
            }

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

            $('#markets').change(function () {
                selectedPlatform = $('#exchange option:selected').text().toLowerCase();
                selectedCurrency = $('#markets option:selected').text();
                var data = {
                    selectedPlatform: selectedPlatform,
                    selectedCurrency: selectedCurrency
                };
                if (!selectedPlatform || !selectedCurrency) {
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: '{{ route('api.alert.metric') }}',
                    data: data,
                    beforeSend: function () {
                        $('#currencyPrice').text('Loading...');
                    },
                    complete: function (response) {
                        ticker = response.responseJSON;
                        updatePrice();
                        return ticker;
                    }
                });
            });

            $("select[name='conditions[metric]']").change(function () {
                if (ticker) {
                    updatePrice();
                }
            });

            $('#type').change(function () {
                selectedType = $('#type option:selected').val();

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

                if (ticker) {
                    updatePrice();
                }

                if (getStorage(metricVal, selectedType, null)) {
                    $('input[name="conditions[value]"]:visible').val(getStorage(metricVal, selectedType, null));
                    $('#alert_message').val(changeTextarea(getStorage(metricVal, selectedType, null)));
                }

                if (selectedType == '9') {
                    $('#every_time').prop('checked', true);
                }
            }).change();

            $('select[name="conditions[metric]"], #markets, #type').change(function () {
                var selected = $('#markets option:selected');
                selectedType = $('#type option:selected').val();
                $('.market_name').text(selected.text());
                if ($('select[name="conditions[metric]"]').val() == '1') {
                    if (selectedType >= 0 && selectedType <= 6) {
                        $('.input-group-text').text(selected.text().split('/')[0]);
                    } else if (selectedType == 7 || selectedType == 8) {
                        $('.input-group-text').text('%');
                    }
                } else {
                    if (selectedType >= 0 && selectedType <= 6) {
                        $('.input-group-text').text(selected.data('quote'));
                    } else if (selectedType == 7 || selectedType == 8) {
                        $('.input-group-text').text('%');
                    }
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

            $('#alert_message').bind('keyup', function () {
                localStorage.setItem('alert_0', $('#alert_message').val());
                cleanMessage(selectedType);
            });

            $('input[name="conditions[value]"]').change(function () {
                $('#alert_message').val(changeTextarea($('input[name="conditions[value]"]:visible').val()));
                setStorage(metricVal, selectedType, $('input[name="conditions[value]"]:visible').val());
            });

            function setStorage(metric = 0, type = 0, value) {
                localStorage.setItem(metric + '_' + type, value);
            }

            function getStorage(metric, type, value) {
                return localStorage.getItem(metric + '_' + type) ? localStorage.getItem(metric + '_' + type) : value;
            }

            function cleanMessage(selectedType) {
                if ($('#alert_message').val() == '') {
                    if (selectedType == 5 || selectedType == 6) {
                        $("input[name='conditions[value]']:visible").val('2');
                    } else if (selectedType == 7 || selectedType == 8) {
                        $("input[name='conditions[value]']:visible").val('5');
                    }
                    localStorage.removeItem('alert_0');
                    $('#alert_message').val(changeTextarea($("input[name='conditions[value]']:visible").val()));
                }
            }

            function updatePrice() {
                selectedType = $('#type option:selected').val();
                metricVal = $("select[name='conditions[metric]']").val();
                metricText = $("select[name='conditions[metric]'] option:selected").text();
                switch (metricVal) {
                    case '0':
                        currencyPrice = ticker.last;
                        break;
                    case '1':
                        currencyPrice = ticker.baseVolume;
                        break;
                }

                $('.currency_price_group').show();
                $('.currency_price_group h4').text(metricText + ': ');
                $('#currencyPrice').text(currencyPrice);

                currentValue = $("input[name='conditions[value]']:visible");
                if (selectedType == 5 || selectedType == 6) {
                    currentValue.val('2');
                } else if (selectedType == 7 || selectedType == 8) {
                    currentValue.val('5');
                } else {
                    currentValue.val(currencyPrice);
                }

                if (getStorage('value', '0', null)) {
                    $("input[name='conditions[value]']:visible").val(getStorage('value', '0', null));
                    localStorage.removeItem('value_0');
                }

                $('#alert_message').val(changeTextarea(currentValue.val()));
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

                if (localStorage.getItem('alert_0')) {
                    return localStorage.getItem('alert_0');
                }
                return message.replace(/\s+/g, ' ').trim();
            }
        });


        $(document).ready(function () {
            setTimeout(function () {
                $('input[name="expiration_date"]').attr("readonly", false);
            }, 500);
            if ($('input[name="open_ended"]').is(":checked")) {
                $('.expiration').prop('disabled', true);
                $('.expiration .flatpickr-input, .clockpicker .expiration-time').prop('disabled', true);
                $('.expiration .flatpickr-input, .clockpicker .expiration-time, .expiration .input-group-addon, .clockpicker .input-group-addon').addClass('expiration-disabled');
            }
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

        $('.add-actions').click(function () {
            if ($('.add-actions').hasClass('active')) {
                $('.add-actions').html('<i class="material-icons">arrow_drop_down</i> More actions');
                $('.add-actions').removeClass('active');
            } else {
                $('.add-actions').addClass('active');
                $('.add-actions').html('<i class="material-icons">arrow_drop_up</i> Less actions');
            }
            $('.wrapper-add-actions').slideToggle();
        });

        $('.wrapper-add-actions input:checkbox').click(function () {
            $('.wrapper-add-actions select').slideToggle();
        });
    </script>
@endpush