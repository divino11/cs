<?php

namespace App\Http\Controllers\Api;

use App\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToggleAlertController extends Controller
{
    public function __invoke(Alert $alert)
    {
        $alert->toggle()->save();
    }
}
