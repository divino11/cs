Alert me when the {{--{{ strtolower(\App\Enums\AlertMetric::getDescription((int) $alert->conditions['metric'])) }}
{{ $alert->conditions['direction'] ? 'rises' : 'falls' }} by
{{ $alert->conditions['value'] }}% within {{ $alert->interval }}--}}