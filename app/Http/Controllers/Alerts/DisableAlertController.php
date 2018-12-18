<?php

namespace App\Http\Controllers\Alerts;

use App\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisableAlertController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Alert $alert)
    {
        $alert->update(['enabled' => 0]);

        return view('message', ['message' => 'Alert has been disabled!']);
    }
}
