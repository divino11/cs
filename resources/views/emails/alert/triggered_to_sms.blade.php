Alert {{ $alert->name }} has been triggered.
@include('alert.description.' . $alert->type).
The {{ App\Enums\AlertMetric::getDescription((int)$alert->conditions['metric']) }} is currently {{ $value }}.