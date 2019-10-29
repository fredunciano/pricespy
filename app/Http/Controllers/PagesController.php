<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Source;
use Validator;

class PagesController extends Controller
{
    /**
     * Display a listing of the repage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->is_sub ? auth()->user()->main_user_id : auth()->id();
        $pages = Page::with('source', 'category')->whereHas('source', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();
        return view('pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new repage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sources = auth()->user()->sources;
        $categories = auth()->user()->categories;
        return view('pages.create', compact('sources', 'categories'));
    }

    /**
     * Store a newly created repage in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = Page::add();

        if (!$res['status']) {
            return back()->withErrors($res['errors'])->withInput($request->input());
        }

        return redirect()->route('pages.index')->with('success', ___('pages.create-success-message'));
    }

    /**
     * Display the specified repage.
     *
     * @param  Page $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        if ($page->source->user_id !== auth()->id()) {
            abort(500);
        }
        return view('pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified repage.
     *
     * @param  Page $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $sources = auth()->user()->sources;
        $categories = auth()->user()->categories;
        return view('pages.edit', compact('page', 'sources', 'categories'));
    }

    /**
     * Update the specified repage in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Page $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $res = $page->modify();

        if (!$res['status']) {
            return back()->withErrors($res['errors'])->withInput($request->input());
        }

        return back()->with('success', 'edit-success-message');
    }

    /**
     * Remove the specified page from storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        auth()->user()->pages()->where('id', $page->id)->where('type', 'page')->delete();
        return back()->with('info', 'delete-success-message');
    }
}

