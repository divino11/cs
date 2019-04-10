<?php

namespace App\Http\Controllers\Preview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreviewMailController extends Controller
{
    public function __invoke()
    {
        return view('preview_mail');
    }
}
