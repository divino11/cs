<?php

namespace App\Http\Controllers\Alerts;

use App\Alert;
use App\AlertNotificationChannel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DuplicateAlertController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Alert $alert)
    {
        $newAlert = $alert->replicate();
        $newAlert->save();

        $alert->notificationChannels()->each(function(AlertNotificationChannel $channel) use ($newAlert) {
            $newAlert->notificationChannels()->save($channel->replicate(['alert_id']));
        });

        return redirect()->route('alerts.edit', ['alert' => $newAlert->id]);
    }
}
