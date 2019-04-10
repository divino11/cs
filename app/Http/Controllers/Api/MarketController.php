<?php

namespace App\Http\Controllers\Api;

use App\Exchange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MarketController extends Controller
{
    /**
     * @param Request $request
     * @return Exchange[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function __invoke(Request $request)
    {
        $name = preg_replace('/[^a-zA-Z\\/]/', '', $request->name);
        return Exchange::where('id', $request->id)
            ->with(['markets' => function ($query) use ($name) {
                $query->where(
                    DB::raw("CONCAT(base, '', quote)"), 'LIKE', '%' . $name . '%'
                );
                $query->orWhere(
                    DB::raw("CONCAT(quote, '', base)"), 'LIKE', '%' . $name . '%'
                );
                $query->orWhere(
                    DB::raw("CONCAT(base, '/', quote)"), 'LIKE', '%' . $name . '%'
                );
            }])
            ->get();
    }
}
