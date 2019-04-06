<?php

namespace App\Http\Controllers\Alerts;

use App\Alert;
use App\Enums\AlertType;
use App\Exchange;
use App\Http\Requests\Alerts\StorePricePointAlertRequest;
use App\Market;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PricePointAlertController extends Controller
{
    public function create()
    {
        return view('alert.create', [
            'exchanges' => Exchange::enabled()->with('markets')->get(),
            'alert' => new Alert(['type' => AlertType::Price_Point]),
        ]);
    }

    public function update(StorePricePointAlertRequest $request, Alert $alert)
    {
        $alert->update($request->except(['type', 'notification_channels']));
        $alert->notificationChannels()->update($request->notification_channels[0]);

        return redirect()->route('alerts.index')->with('status', 'Alert has been updated');
    }

    public function store(StorePricePointAlertRequest $request)
    {
        $alert_message = str_replace([
            '{market}',
            '{type}',
            '{direction}',
            '{value}',
            '{price}',
        ], [
            $request->hiddenMarket,
            $request->hiddenType,
            $request->hiddenDirection,
            $request->hiddenValue,
            $request->hiddenCurrencyValue
        ], $request->alert_message);
        $request->merge(['alert_message' => $alert_message]);

        $alert = Auth::user()->alerts()->create($request->except('notification_channels'));
        $alert->notificationChannels()->create($request->notification_channels[0]);

        return redirect()->route('alerts.index')->with('status', 'New alert created');
    }
}