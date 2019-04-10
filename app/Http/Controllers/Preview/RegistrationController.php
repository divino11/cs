<?php

namespace App\Http\Controllers\Preview;

use App\Alert;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Markdown;

class RegistrationController extends Controller
{
    public function __invoke()
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        return $markdown->render('vendor.notifications.email', [
            'url' => 'https://example.com/',
            'user' => User::latest()->first(),
            'level' => 'primary',
            'introLines' => ['test' => 'test'],
            'outroLines' => ['test' => 'test'],
            'actionText' => 'test',
            'actionUrl' => 'http://example.com/',

        ]);
    }
}
