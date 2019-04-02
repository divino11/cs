<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications', [
            'notifications' => Auth::user()->notifications()->paginate(10),
            'unRead' => Auth::user()->unreadNotifications
        ]);
    }
}
