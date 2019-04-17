<div class="form-group">
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