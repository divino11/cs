Alert me when the {{ strtolower(\App\Enums\AlertMetric::getDescription((int) $alert->conditions['metric'])) }}
is {{ $alert->conditions['direction'] ? 'greater' : 'lower' }}
than {{ $alert->conditions['value'] }}