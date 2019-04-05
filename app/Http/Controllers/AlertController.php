<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Enums\AlertType;
use App\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Auth::user()->alerts;

        return view('alert.index', ['alerts' => $alerts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alert.create', [
            'exchanges' => Exchange::enabled()->with('markets')->get(),
            'alert' => new Alert(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alert = Auth::user()->alerts()->create($request->except('notification_channels'));
        $alert->notificationChannels()->create($request->notification_channels[0]);

        return redirect()->route('alerts.index')->with('status', 'New alert created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        return view('alert.edit', [
            'exchanges' => Exchange::enabled()->with('markets')->get(),
            'alert' => $alert,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        $alert->update($request->except(['notification_channels']));
        $alert->notificationChannels()->update($request->notification_channels[0]);

        return redirect()->route('alerts.index')->with('status', 'Alert has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();

        return redirect()->route('alerts.index')->with('status', "Alert {$alert->exchange->name} - {$alert->market->base}/{$alert->market->quote} has been deleted");
    }
}
