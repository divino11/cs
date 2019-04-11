<?php

namespace App\Http\Controllers\Preview;

use App\Alert;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function __invoke()
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        return $markdown->render('vendor.notifications.email', [
            'url' => 'https://example.com/',
            'user' => User::latest()->first(),
            'level' => 'primary',
            'introLines' => ['test' => 'You are receiving this email because we received a password reset request for your account.'],
            'outroLines' => [
                'test' => 'This password reset link will expire in 60 minutes.',
                'test1' => 'If you did not request a password reset, no further action is required.'
            ],
            'actionText' => 'Verify Email Address',
            'actionUrl' => 'http://example.com/',
        ]);
    }
}
