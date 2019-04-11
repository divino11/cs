<!-- combo -->
<div class="myaccount-combo myaccount-combo-lesspad">
    <div class="row gutter-10">
        <div class="col-md-6 col-sm-6">
            <!-- combo -->
            <h5>Alert me when <span class="market_name"></span></h5>
            <div class="btn-group special">
                <select class="form-control" name="conditions[metric]" required>
                    @foreach(App\Enums\AlertMetric::toSelectArray() as $key => $value)
                        <option value="{{ $key }}" @if(old('conditions.metric', $alert->conditions['metric']) == $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <!-- END combo -->
        </div>
        <div class="col-md-6 col-sm-6 myaccount-combo-righthalf">
            <!-- combo -->
            <h5>&nbsp;</h5>
            <div class="btn-group special">
                <select class="form-control" name="conditions[direction]" required>
                    <option value="0" @if(old('conditions.direction', $alert->conditions['direction']) == 0) selected @endif>crossing</option>
                    <option value="1" @if(old('conditions.direction', $alert->conditions['direction']) == 1) selected @endif>crossing up</option>
                    <option value="2" @if(old('conditions.direction', $alert->conditions['direction']) == 2) selected @endif>crossing down</option>
                </select>
            </div>
            <!-- END combo -->
        </div>
        <!-- combo -->
        <div class="myaccount-combo">
            <div class="input-group">
                <span class="input-group-addon" id="quoteCurrency"></span>
                <input type="number" step="any" class="form-control" name="conditions[value]" required value="{{ old('conditions.value', $alert->conditions['value']) }}" aria-label="Amount (to the nearest dollar)">
            </div>
        </div>
        <!-- END combo -->
    </div>
</div>
<!-- END combo -->