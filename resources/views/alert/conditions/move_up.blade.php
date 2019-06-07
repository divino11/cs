<div class="form-group">
    <div class="input-group pad-0">
        <div class="input-group-append">
            <div class="input-group-text"></div>
        </div>
        <input class="form-control input-value" type="number" step="any" min="0" name="conditions[values][{{ \App\Enums\AlertType::Moving_Up }}]"
               value="{{ old('conditions.values.' . \App\Enums\AlertType::Moving_Up, $alert->conditions['values'][\App\Enums\AlertType::Moving_Up] ?? '') }}" required />
    </div>
</div>
<div class="form-group">
    <h5>In a period of</h5>
    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <select type="number" class="form-control" name="conditions[interval_number]" id="period_value">
                @foreach(config('alerts.intervals.' . $conditions_intervals) as $value)
                    <option value="{{ $value }}" @if(old('conditions.interval_number', $alert->conditions['interval_number']) == $value) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <select name="conditions[interval_unit]" class="form-control" id="period">
                @foreach(App\Enums\AlertPeriod::toSelectArray() as $key => $value)
                    <option value="{{ App\Enums\AlertPeriod::getValue($value) }}"
                            @if($conditions_intervals == App\Enums\AlertPeriod::getValue($value)) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>