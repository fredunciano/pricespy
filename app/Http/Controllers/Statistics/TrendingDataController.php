<?php

namespace App\Http\Controllers\Statistics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrendingDataController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function priceChange()
    {
        return view('statistics.priceChange');
    }
}
