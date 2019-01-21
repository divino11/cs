<div class="form-group">
    <label>Send me an alert with the <span class="market_name"></span></label>
    <select class="form-control" name="conditions[metric]" required>
        @foreach(App\Enums\AlertMetric::toSelectArray() as $key => $value)
            <option value="{{ $key }}" @if(old('conditions.metric', $alert->conditions['metric']) == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <select class="form-control" name="conditions[interval]" required>
        @foreach(config('alerts.updates') as $interval)
            <option value="{{ $interval }}" @if(old('conditions.interval', $alert->conditions['interval']) == $interval) selected @endif>every {{ \Carbon\CarbonInterval::make($interval)->forHumans() }}</option>
        @endforeach
    </select>
</div>