<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        $subUsers = User::where('is_sub', 1)->where('main_user_id', auth()->user()->user_id)->with('verification')->with('permissions')->get();
        return view('settings.index', compact('countries', 'subUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('settings.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'equality_percent' => 'required|between:0,10'
        ]);
        $data['equality_percent'] = (float) $request->input('equality_percent');
        $data['after_tax_prices'] = $request->has('after_tax_prices');
        $data['locale'] = $request->input('locale');
        auth()->user()->update($data);
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Config::set('app.locale', $request->input('locale'));
        Session::remove('locale');
        Session::put('locale', $request->input('locale'));
        return back()->with('success', 'changes_saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function updateUserLocale(Request $request)
    {
        $data['locale'] = $request->input('locale');
        auth()->user()->update($data);
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Config::set('app.locale', $request->input('locale'));
        Session::remove('locale');
        Session::put('locale', $request->input('locale'));

        return back()->with('success', 'changes_saved');
    }
}
