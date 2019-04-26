<?php

namespace App\Http\Controllers\Preview;

use App\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Markdown;

class TriggeredController extends Controller
{
    public function __invoke()
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        return $markdown->render('emails.alert.triggered', [
            'alert' => Alert::latest()->first(),
            'alert_message' => Alert::latest()->first()->alert_message,
            'editUrl' => 'https://example.com/',
            'disableUrl' => 'https://example.com/',
        ]);
    }
}
