Alert me when the {{ strtolower(\App\Enums\AlertMetric::getDescription((int) $alert->conditions['metric'])) }}
is
than {{ $alert->conditions['value'] }}