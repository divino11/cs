<?php

namespace App\Http\Controllers\Preview;

use App\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Markdown;

class ChangeEmailController extends Controller
{
    public function __invoke()
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        return $markdown->render('emails.user.change_email', [
            'url' => 'https://example.com/',
        ]);
    }
}
