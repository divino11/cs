<?php

namespace App\Http\Controllers\Api;

use App\Alert;
use App\Enums\AlertType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeAlertController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function __invoke(Request $request)
    {
        if ($request->id) {
            $alert = Alert::where('id', $request->id)->get();
        } else {
            $alert = new Alert();
        }
        $type = strtolower(AlertType::getKey((int)$request->type));
        $view = view('alert.conditions.' . $type, ['alert' => $alert[0] ? $alert[0] : $alert])->render();
        return response()->json( ['success' => true, 'view' => $view] );
    }
}
