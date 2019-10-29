<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use Carbon\Carbon;

class LogsController extends Controller
{
    /**
     * Logs for current user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $logs = auth()->user()->logs()->where('created_at', '>', Carbon::now()->subDays(3))
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('d/m/Y');
            });
        return view('logs.index', compact('logs'));
    }

    /**
     * Logs history for current user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function history()
    {
        $logs = auth()->user()->logs()->orderBy('created_at', 'desc')->paginate(25);
        $history = true;
        return view('logs.history', compact('logs', 'history'));
    }

}
