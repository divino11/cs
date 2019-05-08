<div class="form-group">
    <div class="input-group pad-0">
        <div class="input-group-append">
            <div class="input-group-text">%</div>
        </div>
        <input class="form-control" type="number" step="any" min="0" name="conditions[value]" value="{{ old('conditions.value', $alert->conditions['value']) }}" required />
    </div>
</div>
<div class="form-group">
    <h5>In a period of</h5>
    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <select type="number" class="form-control" name="conditions[interval_number]">
                <option value="{{ old('conditions.interval_number', $alert->conditions['interval_number']) }}">{{ old('conditions.interval_number', $alert->conditions['interval_number']) }}</option>
            </select>
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <select name="conditions[interval_unit]" class="form-control">
                <option value="minutes"
                        @if(old('conditions.interval_unit', $alert->conditions['interval_unit']) == 'minutes') selected @endif>
                    Minutes
                </option>
                <option value="hours"
                        @if(old('conditions.interval_unit', $alert->conditions['interval_unit']) == 'hours') selected @endif>
                    Hours
                </option>
                <option value="days"
                        @if(old('conditions.interval_unit', $alert->conditions['interval_unit']) == 'days') selected @endif>
                    Days
                </option>
            </select>
        </div>
    </div>
</div>