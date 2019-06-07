<!-- combo -->
<div class="myaccount-combo">
    <div class="row gutter-10">
        <!-- combo -->
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text" id="quoteCurrency"></span>
            </div>
            <input type="number" step="any" class="form-control input-value" name="conditions[values][{{ \App\Enums\AlertType::Crossing_Down }}]" required
                   value="{{ old('conditions.values.' . \App\Enums\AlertType::Crossing_Down, $alert->conditions['values'][\App\Enums\AlertType::Crossing_Down] ?? '') }}"
                   aria-label="Amount (to the nearest dollar)">
        </div>
    </div>
    <!-- END combo -->
</div>
<!-- END combo -->
