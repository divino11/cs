<!-- combo -->
<div class="myaccount-combo">
    <div class="row gutter-10">
        <!-- combo -->
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text" id="quoteCurrency"></span>
            </div>
            <input type="number" step="any" class="form-control input-value" name="conditions[values][{{ \App\Enums\AlertType::Less_Than }}]" required
                   value="{{ old('conditions.values.' . \App\Enums\AlertType::Less_Than, $alert->conditions['values'][\App\Enums\AlertType::Less_Than] ?? '') }}"
                   aria-label="Amount (to the nearest dollar)">
        </div>
    </div>
    <!-- END combo -->
</div>
<!-- END combo -->
