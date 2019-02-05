Alert me the {{ strtolower(\App\Enums\AlertMetric::getDescription((int) $alert->conditions['metric'])) }}
every {{ $alert->interval }}