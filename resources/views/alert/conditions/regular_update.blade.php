<div class="form-group">
    <select class="form-control" name="conditions[interval]" required>
        @foreach(config('alerts.updates') as $interval)
            <option value="{{ $interval }}" @if(old('conditions.interval', $alert->conditions['interval']) == $interval) selected @endif>every {{ \Carbon\CarbonInterval::make($interval)->forHumans() }}</option>
        @endforeach
    </select>
</div>