<?php

namespace App\Http\Requests\Alerts;

use App\Enums\AlertMetric;
use App\Enums\AlertType;
use App\Enums\NotificationChannel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreAlertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $expiration = $this->expiration_date . ' ' . $this->expiration_time;
        $starting = $this->conditions['starting_date'] . ' ' . $this->conditions['starting_time'];
        $this->merge([
            'expiration_date' => $expiration,
            'conditions.starting_date' => $starting
        ]);

        return [
            'exchange_id' => 'required|exists:exchanges,id',
            'market_id' => 'required|exists:markets,id',
            'conditions.metric' => 'required|enum_value:' . AlertMetric::class .',false',
            //'conditions.value' => 'required|numeric|min:0',
            'conditions.interval_number' => 'required',
            'conditions.interval_unit' => 'required',
            'notification_channels' => 'required',
            'notification_channels.*.notification_channel' => 'enum_value:' . NotificationChannel::class.',false',
            'frequency' => 'required|boolean',
            'cooldown_number' => 'numeric|min:5',
            'expiration_date' => 'after:' . now()->timezone(Auth::user()->timezone)->format('Y-m-d H:i'),
            'conditions.starting_date' => 'before:expiration_date',
            'alert_message' => 'required',
            'open_ended' => 'boolean'
        ];
    }
}
