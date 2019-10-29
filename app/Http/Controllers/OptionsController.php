<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OptionBinding;
use App\Option;
use App\Source;

class OptionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = auth()->user()->options()->whereHas('source', function($q) use ($request) {
            if ($request->has('s')) {
                $q->where('id', $request->s);
            }
        })->get();
        return view('options.options', compact('options'));
    }

    /**
     * Display the comparison of the options.
     *
     * @return \Illuminate\Http\Response
     */
    public function getComparison()
    {
        $bindings = OptionBinding::whereHas('option', function($q) {
            $q->where('user_id', auth()->id());
        })->with('mainOption')->with('option')->get();
        return view('options.comparison', compact('bindings'));
    }


    /**
     * Get bind main options to concurrent options page
     *
     * @return \Illuminate\Http\Response
     */
    public function getBinding()
    {
        $options = auth()->user()->options()->whereHas('source', function($q) {
            $q->where('is_main', 1);
        })->orderBy('name', 'asc')->get();
        $sources = auth()->user()->sources()->where('is_main', 0)->has('options')->with('options')->get();
        $mainSource = auth()->user()->sources()->where('is_main', 1)->whereHas('options')->first();

        return view('options.binding', compact('options', 'sources', 'mainSource'));
    }

    /**
     * Source the bindings among the options
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postBinding(Request $request)
    {
        $input = $request->input();

        $mainOption = auth()->user()->options()->find($input['main-option']);
        $mainOption->bindings()->delete();

        if (isset($input['options'])) {
            foreach ($input['options'] as $ids) {
                $options = auth()->user()->options()->whereIn('id', $ids)->get();
                if (count($options)) {
                    foreach ($options as $option) {
                        $mainOption->bindings()->create([
                            'bound_option_id' => $option->id
                        ]);
                    }
                }
            }
        }

        return back()->with('success', 'changes_saved');
    }


    /**
     * Loads the bindings for a specific option
     *
     * @param Option $option
     *
     * @return mixed
     */

    public function loadBindings(Option $option)
    {
        if ($option->user_id !== auth()->id()) {
            abort(500);
        }
        return $option->bindings->pluck('bound_option_id');
    }


    /**
     * Delete a binding between options
     *
     * @param OptionBinding $binding
     * @return int
     */

    public function deleteBinding(OptionBinding $binding)
    {
        if ($binding && $binding->option->user_id == auth()->id()) {
            $binding->delete();
            return 1;
        }
        return 0;
    }
}
