<p style="font-size: 15px; line-height: 22px; color: #333; text-align:left; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
Alert me when the {{ strtolower(\App\Enums\AlertMetric::getDescription((int) $alert->conditions['metric'])) }}
is {{ $alert->conditions['direction'] ? 'greater' : 'lower' }}
than <strong>{{ $alert->conditions['value'] }}</strong>
</p>