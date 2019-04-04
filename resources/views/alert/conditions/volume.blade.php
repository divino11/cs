<!-- combo -->
<div class="myaccount-combo myaccount-combo-lesspad">
    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <!-- combo -->
            <h5>Alert me when <span class="market_name"></span></h5>
            <div class="btn-group special">
                <select class="form-control" name="conditions[direction]" required>
                    <option value="0" @if(old('conditions.direction', $alert->conditions['direction']) == 0) selected @endif>is less than or equals</option>
                    <option value="1" @if(old('conditions.direction', $alert->conditions['direction']) == 1) selected @endif>is greater than or equals</option>
                </select>
            </div>
            <!-- END combo -->
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <!-- combo -->
            &nbsp;
            <div class="d-flex">
                <select name="conditions[metric]" style="display: none">
                    <option value="{{ App\Enums\AlertMetric::Volume }}">{{ App\Enums\AlertMetric::getDescription(App\Enums\AlertMetric::Volume) }}</option>
                </select>
                <span class="input-group-addon" id="quoteCurrency"></span>
                <input type="number" step="any" class="form-control" name="conditions[value]" required value="{{ old('conditions.value', $alert->conditions['value']) }}" aria-label="Amount (to the nearest dollar)">
            </div>
            <!-- END combo -->
        </div>
    </div>
</div>
<!-- END combo -->