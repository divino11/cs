<div class="row gutter-10">
    <input type="hidden" name="conditions[value]" value="1">
    <div class="col-md-6 col-sm-6">
        <h5>Starting on</h5>
        <div class="calendar-group">
            <div class="starting-date">
                <input class="form-control" data-input type="text" autocomplete="off"
                       value="{{ old('conditions.starting_date', $alert->conditions['starting_date'] ?? date('Y-m-d')) }}"
                       name="conditions[starting_date]">
                <span class="input-group-addon" title="toggle" data-toggle>
        <i class="material-icons">calendar_today</i>
    </span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
        <h5>&nbsp;</h5>
        <div class="starting-time">
            <input type="text" class="form-control"
                   value="{{ old('conditions.starting_time', $alert->conditions['starting_time'] ?? '00:00') }}"
                   autocomplete="off"
                   name="conditions[starting_time]">
            <span class="input-group-addon">
        <i class="material-icons">access_time</i>
    </span>
        </div>
    </div>
</div>