Alert me when the {{ strtolower(\App\Enums\AlertMetric::getDescription((int) $alert->conditions['metric'])) }}
 by
{{ $alert->conditions['value'] }}% within {{ $alert->interval }}