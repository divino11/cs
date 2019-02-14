<div class="form-group">
    <label>Alert me when <span class="market_name"></span></label>
    <select class="form-control" name="conditions[metric]" required>
        @foreach(App\Enums\AlertMetric::toSelectArray() as $key => $value)
            <option value="{{ $key }}" @if(old('conditions.metric', $alert->conditions['metric']) == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
    <select class="form-control" name="conditions[direction]" required>
        <option value="0" @if(old('conditions.direction', $alert->conditions['direction']) == 0) selected @endif>falls by</option>
        <option value="1" @if(old('conditions.direction', $alert->conditions['direction']) == 1) selected @endif>rises by</option>
    </select>
    <div class="input-group pad-0">
        <div class="input-group-append">
            <div class="input-group-text">%</div>
        </div>
        <input class="form-control" type="number" step="any" min="0" name="conditions[value]" value="{{ old('conditions.value', $alert->conditions['value']) }}" required />
    </div>
</div>
<div class="form-group">
    <select class="form-control" name="conditions[interval]" required>
        @foreach(config('alerts.intervals') as $interval)
            <option value="{{ $interval }}" @if(old('conditions.interval', $alert->conditions['interval']) == $interval) selected @endif>within a {{ \Carbon\CarbonInterval::make($interval)->forHumans() }} time period</option>
        @endforeach
    </select>
</div>