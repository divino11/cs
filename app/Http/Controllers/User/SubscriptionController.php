<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Subscriptions\CancelRequest;
use App\Http\Requests\Subscriptions\CreateRequest;
use App\Http\Requests\Subscriptions\ResumeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.subscription.index', ['user' => Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request)
    {
        return view('user.subscription.create');
    }

    public function update(ResumeRequest $request)
    {
        $request->user()->subscriptions()->update([
            'ends_at' => null
        ]);

        return redirect()->back()->with('status', 'Your subscription has been restored');
    }

    public function destroy(CancelRequest $request)
    {
        $request->user()->subscription('main')->cancel();

        return redirect()->route('subscription.index')->with('status', 'Your subscription has been canceled');
    }

}
